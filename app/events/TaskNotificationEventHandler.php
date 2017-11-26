<?php

use Illuminate\Support\Facades\Redis;

class TaskNotificationEventHandler {

	CONST EVENT   = 'task.status';
	CONST CHANNEL = 'task.status';

	public function handle($data)
    {
        $redis = Redis::connection();
        $redis->publish(self::CHANNEL, $data);
    }
}