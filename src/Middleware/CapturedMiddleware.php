<?php


namespace App\Http\Middleware;


use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Captured;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;

class CapturedMiddleware implements Captured
{

    public function captured(IncomingMessage $message, $next, BotMan $bot)
    {

        if( !empty($message->getPayload()) ) {

            $key =  $message->getPayload()->all()['sender']['id'];

            $cachedMessages = collect();

            if ( Redis::exists($key) ) {
                $cachedMessages = unserialize(Redis::get($key));
            }


            if($cachedMessages->contains($message->getPayload()->all()['sig'])) {
                abort('413');
            }

            $cachedMessages->add($message->getPayload()->all()['sig']);

            $cachedMessages = $cachedMessages->unique();

            Redis::set($key, serialize($cachedMessages), 30);
        }


        return $next($message);
    }
}