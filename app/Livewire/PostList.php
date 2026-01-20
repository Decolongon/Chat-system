<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;

use function Pest\Laravel\session;
use Illuminate\Support\Facades\Auth;

class PostList extends Component
{
   
    //  public function getListeners()
    //  {
    //     return [
    //         "echo-private:posts.{$this->author_id},PostEvent" => 'refreshPosts',
    //     ];
    //  }

 
   
    /**
     * When the event is received, refresh the posts by unsetting the computed property.
     *
     * @return void
     */
   // #[On('echo:posts,PostEvent')]
    public function refreshPosts($event)
    {

        //dd($event);
        unset($this->getPosts);
    }

    /**
     * Return the posts of the authenticated user.
     *
     */

    #[Computed(persist: true, seconds: 120)]
    public function getPosts()
    {
        return Post::query()
            ->where('author_id', Auth::user()->id)
            ->latest()
            ->get();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post-list', [
            // 'posts' => $this->getPosts()
        ]);
    }
}
