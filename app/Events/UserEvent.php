<?php

namespace App\Events;

use App\Http\Models\Profiles;
use App\Http\Models\Eventlog;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserEvent extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Profiles $profiles, $type)
    {
        $this->doAction($profiles, $type);
    }
    
    /**
     * User action events.
     *
     * @param  UserEvent  $event
     * @return void
     */
    public function doAction($event, $type)
    {
        $data['user_id'] = (\Session::has('session_id'))?\Session::get('session_id'):0;
        $data['restaurant_id'] = (\Session::has('session_restaurant_id'))?\Session::get('session_restaurant_id'):0;
        $data['type'] = (isset($type))?$type:'';
        $data['text'] = json_encode($event);
        $ob = new Eventlog();
        $ob->populate($data);
        $ob->save();
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
