<?php

use Illuminate\Support\Facades\Redis;

class JoinNotificationEventHandler {

	CONST EVENT   = 'invite.status';
	CONST CHANNEL = 'invite.status';

	public function handle($data)
    {
        $redis = Redis::connection();
        $redis->publish(self::CHANNEL, $data);
    }
}