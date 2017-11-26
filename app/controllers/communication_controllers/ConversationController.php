<?php

//use LaravelRealtimeChat\Repositories\Conversation\ConversationRepository;
//use LaravelRealtimeChat\Repositories\User\UserRepository;

class ConversationController extends \BaseController {

//    /**
//     * @var LaravelRealtimeChat\Repositories\Conversation\ConversationRepository
//     */
//    private $conversationRepository;
//
//    /**
//     * @var LaravelRealtimeChat\Repositories\User\UserRepository
//     */
//    private $userRepository;
//
//    public function __construct(ConversationRepository $conversationRepository, UserRepository $userRepository) {
//        $this->conversationRepository = $conversationRepository;
//        $this->userRepository = $userRepository;
//    }
//
//    /**
//     * Display a listing of conversations.
//     *
//     * @return Response
//     */
//    public function index() {
//        $viewData = array();
//
//        $users = $this->userRepository->getAllExcept(Auth::user()->id);
//
//        foreach ($users as $key => $user) {
//            $viewData['recipients'][$user->id] = $user->username;
//        }
//
//        $viewData['current_conversation'] = $this->conversationRepository->getByName(Input::get('conversation'));
//        $viewData['conversations'] = Auth::user()->conversations()->get();
//
//        return View::make('templates/conversations', $viewData);
//    }

    public function conversations() {
        $channelId = Input::get('channelId');
        $teamName = DB::table('team_channels')
                        ->select('channel_view_name')
                        ->where('team_channel_id', '=', $channelId)->first();
        $messages = DB::table('messages')
                        ->select('messages.message', 'messages.id', 'messages.created_at', 'users.first_name', 'users.last_name', 'users.profile_pic', 'users.id as user_id')
                        ->leftJoin('team_conversations', 'messages.id', '=', 'team_conversations.message_id')
                        ->leftJoin('users', 'users.id', '=', 'team_conversations.user_id')
                        ->where('team_conversations.team_channel_id', '=', $channelId)->orderBy('messages.id', 'desc')->take(10)->get();
//         print_r($messages);
        $messages = array_reverse($messages);
        $data = array("messages" => $messages, "channelId" => $channelId, "teamName" => $teamName['channel_view_name']);


        return View::make('templates/messages')->with('data', $data);
    }

    public function personal_conversations() {
//      \Debugbar::enable();
        $userData = Input::get('channelId');
        $data = explode("_", $userData);
        $to_user_id = $data[0];
        $teamChannelId = $data[1];
        /**
         * Get the to_user details
         * 
         */
        $toUserDetails = DB::table('users')
                        ->select('id', 'first_name', 'last_name', 'profile_pic')
                        ->where('id', '=', $to_user_id)->first();
        $messages = DB::table('messages')
                        ->select('messages.message', 'messages.id', 'messages.created_at', 'personal_conversations.to_user_id', 'personal_conversations.from_user_id')
                        ->leftJoin('personal_conversations', 'messages.id', '=', 'personal_conversations.message_id')
                        ->whereIn('personal_conversations.to_user_id', array(Auth::user()->id, $to_user_id))
                        ->whereIn('personal_conversations.from_user_id', array(Auth::user()->id, $to_user_id))
                        ->where('personal_conversations.team_channel_id', '=', $teamChannelId)->orderBy('messages.id', 'desc')->take(10)->get();
        $messages = array_reverse($messages);
        $queries = DB::getQueryLog();
        $last_query = end($queries);
        $data = array("messages" => $messages, "channelId" => $teamChannelId, "toUserDetails" => $toUserDetails);
//         
//         
        return View::make('templates/messages')->with('data', $data);
    }

    /**
     * Store a newly created conversation in storage.
     *
     * @return Response
     */
    public function store() {

        $rules = array(
            'users' => 'required|array',
            'body' => 'required'
        );

        $validator = Validator::make(Input::only('users', 'body'), $rules);

        if ($validator->fails()) {
            return Response::json([
                        'success' => false,
                        'result' => $validator->messages()
            ]);
        }

        // Create Conversation
        $params = array(
            'created_at' => new DateTime,
            'name' => str_random(30),
            'author_id' => Auth::user()->id
        );

        $conversation = Conversation::create($params);

        $conversation->users()->attach(Input::get('users'));
        $conversation->users()->attach(array(Auth::user()->id));

        // Create Message
        $params = array(
            'conversation_id' => $conversation->id,
            'body' => Input::get('body'),
            'user_id' => Auth::user()->id,
            'created_at' => new DateTime
        );

        $message = Message::create($params);

        // Create Message Notifications
        $messages_notifications = array();

        foreach (Input::get('users') as $user_id) {
            array_push($messages_notifications, new MessageNotification(array('user_id' => $user_id, 'read' => false, 'conversation_id' => $conversation->id)));

            // Publish Data To Redis
            $data = array(
                'room' => $user_id,
                'message' => array('conversation_id' => $conversation->id)
            );

            Event::fire(ChatConversationsEventHandler::EVENT, array(json_encode($data)));
        }

        $message->messages_notifications()->saveMany($messages_notifications);

        return Redirect::route('chat.index', array('conversation', $conversation->name));
    }

    function get_snippet_code() {
        $msgId = Input::get('snipetId');
        $messages = DB::table('messages')
                        ->select('messages.message')
                        ->where('messages.id', '=', $msgId)->first();
        return $messages['message'];
//        return View::make('templates/snippet/snippet_view_modal.blade')->with('snippetData', $snippetData);
    }

}
