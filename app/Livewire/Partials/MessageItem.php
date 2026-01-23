<?php

namespace App\Livewire\Partials;

use App\Livewire\Chat;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Reactive;

class MessageItem extends Component
{
    #[Reactive]
    #[Locked]
    public Message $msg;

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.partials.message-item');
    }
}
