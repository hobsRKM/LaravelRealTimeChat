<?php

Event::listen(ChatMessagesEventHandler::EVENT, 'ChatMessagesEventHandler');
Event::listen(ChatConversationsEventHandler::EVENT, 'ChatConversationsEventHandler');
Event::listen(LoginStatusEventHandler::EVENT, 'LoginStatusEventHandler');
Event::listen(JoinNotificationEventHandler::EVENT, 'JoinNotificationEventHandler');