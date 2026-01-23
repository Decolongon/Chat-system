<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Events\MessageEvent;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    #[Locked]
    public $selectedUser;

    public $message = '';

    public $selectedUserName = '';

    public $selectedUserEmail = '';

    #[Locked]
    public $deleteConvoId;

    /**
     * Send a message to the selected user.
     * Validates the message is not empty, creates a new message record,
     * resets the message input, and broadcasts the message event.
     */
    public function sendMessage()
    {
        if (empty($this->message)) return;

        $message = Message::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $this->selectedUser,
            'message' => $this->message
        ]);

        $this->reset(['message']);
        broadcast(new MessageEvent($message));
    }

    /**
     * Select a user for the chat.
     * Sets the selected user ID, name, and email for the current chat session.
     *
     * @param User $user The user to select for chatting
     */
    public function selectUser(User $user)
    {
        $this->selectedUser = $user->id;
        $this->selectedUserName = $user->name;
        $this->selectedUserEmail = $user->email;
    }


    /**
     * Clear the selected user from the chat.
     * Resets the selected user ID, name, and email to null/empty.
     */
    public function clearSelectedUser()
    {
        $this->reset(['selectedUser', 'selectedUserName', 'selectedUserEmail']);
    }

    /**
     * Get list of users available for chatting (excluding the current user).
     * Results are cached/persisted for 120 seconds to improve performance.
     *
     * @return \Illuminate\Database\Eloquent\Collection Users excluding the authenticated user
     */
    #[Computed(persist: true, seconds: 120)]
    public function getUsers()
    {
        return User::query()
            ->exceptYourself()
            ->get(['id', 'name', 'email']);
    }


    /**
     * Get messages exchanged between the current user and selected user.
     * Retrieves messages where current user is sender or receiver with selected user.
     * Results are ordered chronologically by creation date.
     *
     * @return \Illuminate\Database\Eloquent\Collection Messages ordered by creation date
     */
    #[Computed()]
    public function getMessages()
    {
        return Message::query()
            ->messageReceiver($this->selectedUser)
            ->messageSender($this->selectedUser)
            ->orderBy('created_at', 'asc')
            ->get();
    }



    /**
     * Refresh the messages by triggering a new query for the selected user.
     * Clears the cached message list to fetch the latest messages.
     */


    public function refreshMessages()
    {
        unset($this->getMessages);
    }

    /**
     * Render the chat component view.
     * Uses the main app layout and returns the livewire.chat view.
     *
     * @return \Illuminate\View\View The rendered chat view
     */
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.chat');
    }
}
