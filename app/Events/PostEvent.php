<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class PostEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

  

    /**
     * Create a new event instance.
    //  */
    public function __construct(protected Post $post)
    {
       
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            //new PrivateChannel('channel-name'),
            //new Channel('posts'),
            new PrivateChannel('posts.'.$this->post->author_id),
           
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->post->id,
            'author_id'=> $this->post->author_id,
            'title' => $this->post->title,
            'body' => $this->post->body
        ];
    }
}
