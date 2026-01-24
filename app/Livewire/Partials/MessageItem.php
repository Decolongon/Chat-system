<?php

namespace App\Livewire\Partials;

use App\Events\MessageDeleteForEveryone;
use App\Events\MessageDeleteForMe;
use App\Livewire\Chat;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;

class MessageItem extends Component
{
    #[Reactive]
    public Message $msg;

    public function deleteForMe(Message $message): void
    {
        $updateData = [];

        if ($message->sender_id === auth()->id()) {
            $updateData['sender_deleted_at'] = now();
        } else {
            $updateData['receiver_deleted_at'] = now();
        }
        //dd($updateData);
        $message->update($updateData);


        broadcast(new MessageDeleteForMe($message->fresh()));

    }

    public function deleteForEveryone(Message $message): void
    {
        abort_if($message->sender_id != auth()->id(), 403);

        $message->update([
            'deleted_for_everyone_at' => now(),
        ]);



        broadcast(new MessageDeleteForEveryone($message->fresh()));

    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.partials.message-item');
    }
}
