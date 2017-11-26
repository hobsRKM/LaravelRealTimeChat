<?php

use Illuminate\Support\Facades\Redis;

class LoginStatusEventHandler {

	CONST EVENT   = 'chat.status';
	CONST CHANNEL = 'chat.status';

	public function handle($data)
    {
        $redis = Redis::connection();
        $redis->publish(self::CHANNEL, $data);
    }
}