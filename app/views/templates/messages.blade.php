@if($data['channelId']!='')
<div class="ms-body" style='padding-left:0 !important'>
    <div class="listview lv-message">
        <div class="lv-header-alt clearfix">
            <div id="ms-menu-trigger">
                <div class="line-wrap">
                    <div class="line top"></div>
                    <div class="line center"></div>
                    <div class="line bottom"></div>
                </div>
            </div>

            <div id="teamProfile" class="lvh-label hidden-xs">

                @if(isset($data['toUserDetails']))
                <div class="lv-avatar pull-left">
                    <img src="fusionmate/public/plugins/profile_pics/<?php echo ($data['toUserDetails']['profile_pic'] == '') ? 'default_user_icon.png' : $data['toUserDetails']['profile_pic']; ?>" alt="">
                </div>


                <span class="c-black">{{ $data['toUserDetails']['first_name']." ".$data['toUserDetails']['last_name'] }}</span>
                @else

                <span class="c-black">{{$data['teamName']}}</span>
                @endif
            </div>

            <ul class="lv-actions actions">
                <li>
                    <a href="">
                        <i class="zmdi zmdi-delete"></i>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="zmdi zmdi-check"></i>
                    </a>
                </li>
                @if(isset($data['toUserDetails']))
                <li data-toggle="tooltip" data-placement="bottom" title="Upload File">
                    <a href="#" data-toggle="modal" data-target="#myModal">
                        <i style="" class="zmdi zmdi-upload "  ></i>
                    </a>
                </li> 
                @else
                <li data-toggle="tooltip" data-placement="bottom" title="Upload File">
                    <a href="#" data-toggle="modal" data-target="#myModal">
                        <i class="zmdi zmdi-upload"></i>
                    </a>
                </li> 
                @endif
                <li data-toggle="tooltip" data-placement="bottom" title="Upload Snippet">
                    <a href="#" onclick="initializeAce()" data-toggle="modal" data-target="#myModal1">
                        <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal1">Open Modal</button>-->
                        <i class="zmdi zmdi-unfold-more"></i>
                    </a>

                </li>                             
                <li class="dropdown">
                    <a href="" data-toggle="dropdown" aria-expanded="true">
                        <i class="zmdi zmdi-more-vert"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <a href="">Refresh</a>
                        </li>
                        <li>
                            <a href="">Message Settings</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div id="messageWindow" class="lv-body mCustomScrollbar   "  data-mcs-theme="dark-2"> 
            <div id="innerMessage">                                  
                <!--Messages To be appended here-->
                @foreach($data['messages'] as $message)
                <div class="lv-item media">

                    <div class="lv-avatar pull-left">
                        @if(isset($data['toUserDetails']))
                        @if($message['from_user_id']==Auth::user()->id)
                        <img src="fusionmate/public/plugins/profile_pics/<?php echo (Session::get('profilePic') == '') ? 'default_user_icon.png' : Session::get('profilePic'); ?>" alt="">
                        <h6 class='elipsee'> <a target="_blank" href="/view_profile/<?php echo (Auth::user()->id) ?>">
                                Me
                                @else
                                <img src="fusionmate/public/plugins/profile_pics/<?php echo ($data['toUserDetails']['profile_pic'] == '') ? 'default_user_icon.png' : $data['toUserDetails']['profile_pic']; ?>" alt="">
                                <h6 class='elipsee'> <a target="_blank" href="/view_profile/<?php echo $data['toUserDetails']['id'] ?>">
                                        {{ucfirst(strtolower($data['toUserDetails']['first_name']))}}
                                        @endif
                                        @else
                                        <img src="fusionmate/public/plugins/profile_pics/<?php echo ($message['profile_pic'] == '') ? 'default_user_icon.png' : $message['profile_pic']; ?>" alt="">
                                        <h6 class='elipsee'> <a target="_blank" href="/view_profile/<?php echo $message['user_id'] ?>">
                                                {{ucfirst(strtolower($message['first_name']))}}
                                                @endif
                                        </h6></a>
                                    </div>
                                    <div class="media-body">
                                        <!--Check if either from user i.e if from personal conversation OR user_id i.e from general is the logged in user id-->
                                        @if(isset($message['from_user_id'])==Auth::user()->id || isset($message['user_id'])==Auth::user()->id )
                                        <div id="{{$message['id']}}"  class="tools btn-toolbar btn-toolbar-light pull-right"><i class="fa fa-cog"></i></div>
                                        @endif
                                        <?php
                                        $key = $message['message'];

                                        if (strpos($key, '#_$') !== false) {
                                            $link = (explode("#_$", $key));
                                            $fileExt = $link[0];
                                            $extensionArray = array('avi', 'csv', 'doc', 'flv', 'sql', 'm4v', 'mp3', 'mp4', 'mpg', 'odt', 'ogv', 'pps', 'ppsx', 'ppt', 'pptx', 'psd', 'rtf', 'txt', 'wma', 'xls', 'xlsx', 'zip', 'pdf', 'docx');
                                            $imageArry = array('png', 'jpg', 'jpeg', 'gif', 'bmp', 'tiff');

                                            $second = array_slice($link, 1, 1, true);
                                            $uploadComment = array_slice($link, 2, 1, true);
                                            ?>
                                            <!--<div class="ms-item">--> 

                                            <div class="card uploadCard">
                                                <div class="custom-file-display card-header bgm-cyan fileUploadText"> Uploaded a File
                                                    <span class="pull-right lv-actions actions"><a download data-toggle="tooltip" data-html="true" data-placement="bottom" data-original-title="Download file"  href=" <?php
                                                            foreach ($second as $value) {
                                                                $imageName = $value;
                                                                echo $value;
                                                            }
                                                            ?>"><i style="font-size:24px;color:#000" class="zmdi zmdi-case-download"></i></a><a href="<?php
                                                            foreach ($second as $value) {
                                                                $imageName = $value;
                                                                echo $value;
                                                            }
                                                            ?>" target="_blank" data-toggle="tooltip" data-html="true" data-placement="bottom" data-original-title="Open in new window"><i style="padding-left:4px;font-size:22px;color:#000" class="zmdi zmdi-open-in-new"></i></a></span>
                                                </div>

                                                <div class="card-body custom-file-dsiplay-body card-padding" style="">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <a href="<?php
                                                            foreach ($second as $value) {
                                                                $imageName = $value;
                                                                echo $value;
                                                            }
                                                            ?>" target="_blank">
                                                                   <?php
                                                                   if (in_array($fileExt, $extensionArray)) {
                                                                       echo '<img src="fusionmate/public/plugins/uploadIcons/' . $fileExt . '.png" alt="">';
                                                                   } else if (in_array($fileExt, $imageArry)) {
                                                                       echo '<img  class="img-thumbnail" width="504" height="465" src="' . $imageName . '" alt="">';
                                                                   } else {
                                                                       echo '<img src="fusionmate/public/plugins/uploadIcons/default.png" alt="">';
                                                                   }
                                                                   ?>

                                                            </a>
                                                        </div>
                                                        <div class="col-md-8">

                                                            <?php
                                                            foreach ($second as $value) {

                                                                $subject = $value;
                                                                $search = 'fusionmate/public/plugins/userUploads/';
                                                                $trimmed = str_replace($search, '', $subject);
                                                                echo '<h2 class="uploadedFileName">' . $trimmed . '</h2>';
                                                            }
                                                            ?>
                                                            <?php
                                                            foreach ($uploadComment as $commentVal) {
                                                            if (!empty($commentVal)){
                                                                    echo '<h2 class="comment">"' . $commentVal . ' "</h2>';
                                                            }
                                                            }
                                                            ?>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        else if (strpos($key, 'snippet$#fmslipt') !== false) {
                                            ?>
                                            <div class="card uploadCard">
                                                <div class="custom-file-display card-header bgm-cyan" style=""> <!-- Please refer the Colors page in User Interface for more color classes -->
                                                    <span class="pull-right lv-actions actions">
                                                        <a href="#" onclick="viewSnippet({{$message['id'] }})" data-toggle="tooltip" data-html="true" data-placement="bottom" data-original-title="View Snippet"><i style="padding-left:4px;font-size:22px;color:#000" class="zmdi zmdi-view-dashboard"></i></a>
                                                    </span>
                                                </div>

                                                <div class="card-body custom-file-dsiplay-body card-padding" style="">
                                                    <div class="row">
                                                        <div class="col-md-4" >
                                                            <?php echo '<img src="fusionmate/public/plugins/uploadIcons/code.png" alt="">'; ?>
                                                        </div>
                                                        <div class="col-md-8 snippetTextFormal">
                                                            Added a Snippet Code
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } else { ?>


                                            <!--</div>-->  

                                            <div   class="ms-item" id="messageSection">
                                               
                                                   <textarea contenteditable="false"  data-emojiable="true"> {{htmlentities($message['message']) }}</textarea>
                                                
                                            </div>
                                        <?php } ?>
                                        <small class="ms-date"><i class="zmdi zmdi-time"></i> {{toDatetime($message['created_at'])}}</small>
                                    </div><br/>
                                    <div class="progress">
                                        <div class="progress-bar" style="height:24% !important" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                            <span class="sr-only">100% Complete</span>
                                        </div>
                                    </div>
                                    </div>
                                    @endforeach
                                    @if(count($data['messages'])==0)
                                    <h4 id='noConversations' class="text-center" style="color: #ccc;padding-top: 10%">No Conversations yet.<br/>Be the first to start a conversation</h4>
                                    @endif
                                    </div>



                                    </div>
                                        <div class="typing-loader"></div>
                                    <div class="lv-footer ms-reply message-box">
                                        @if(isset($data['toUserDetails']))
                                        <textarea  data-channel-id="{{$data['channelId']}}" data-emojiable="true" onkeyup="process(event, this,'{{$data['toUserDetails']['id']}}')" id='messageBox' placeholder="What's on your mind..."></textarea>

                                        <button room='user' cid='{{$data['toUserDetails']['id']."_".$data['channelId']}}' id="send" onclick="sendMessage('{{$data['toUserDetails']['id']."_".$data['channelId']}}', true)"><i class="zmdi zmdi-mail-send"></i></button>
                                        <span id='typing'></span>
                                        @else
                                        <textarea data-emojiable="true" onkeyup="process(event, this)" id='messageBox' placeholder="What's on your mind..."></textarea>

                                        <button room='general' cid='{{$data['channelId']}}' id="send"  onclick="sendMessage('{{$data['channelId']}}',false)"><i class="zmdi zmdi-mail-send"></i></button>
                                        @endif

                                    </div>
                                    </div>
                                    </div>
                                    @else
                                   @include('templates/introduction/introduction')
                                    @endif

                                    <script>
                                 
                                        $(document).ready(function(){
//                                             document.getElementsByClassName("emoji-wysiwyg-editor").addClass('custom-emoji');
//                                            $('#messageSection').children(':first-child').next().addClass('custom-emoji');
//                                            .addClass('custom-emoji');
//                                            $('.emoji-wysiwyg-editor').addClass('custom-emoji');
//                                              $('#messageSection').children().removeClass('emoji-picker-icon emoji-picker fa fa-smile-o');
//                                          document.getElementById('messageSection').children().removeClass('emoji-picker-icon emoji-picker fa fa-smile-o');
                                        $('.tools').toolbar({
                                        content: '#toolbar-options',
                                                position: 'left',
                                        });
                                        $('.tools').on('toolbarItemClick',
                                                function(event, buttonClicked) {
                                                alert(buttonClicked.id);
//                                                    console.log(event);

                                                // this: the element the toolbar is attached to
                                                }
                                        );
                                        $('[data-toggle="tooltip"]').tooltip();
                                       
                                    });
                                    </script>
                                    
  <script>
    $(function() {
         
                                           
                                          
      // Initializes and creates emoji set from sprite sheet
      window.emojiPicker = new EmojiPicker({
        emojiable_selector: '[data-emojiable=true]',
        assetsPath: 'fusionmate/public/plugins/images/emoji/',
        popupButtonClasses: 'fa fa-smile-o'
      });
      // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
      // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
      // It can be called as many times as necessary; previously converted input fields will not be converted again
      window.emojiPicker.discover();
       $("#messageSection .emoji-wysiwyg-editor").attr("contenteditable","false");
    });
  </script>