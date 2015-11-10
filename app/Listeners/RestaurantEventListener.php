<?php

namespace App\Listeners;

use App\Events\RestaurantEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RestaurantEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserEvent  $event
     * @return void
     */
    public function handle(RestaurantEvent $event)
    {
//        $data['user_id'] = (\Session::has('session_id'))?\Session::get('session_id'):0;
//        $data['restaurant_id'] = (\Session::has('session_restaurant_id'))?\Session::get('session_restaurant_id'):0;
//        $data['date'] = date('Y-m-d H:i:s');
//        $data['type'] = (isset($event->type))?$event->type:'';
//        $data['text'] = json_encode($event);
//        $ob = new Eventlog();
//        $ob->populate($data);
//        $ob->save();
    }
}
