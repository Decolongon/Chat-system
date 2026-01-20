<?php

namespace App\Livewire;

use Livewire\Component;
use App\Events\PostEvent;
use App\Livewire\PostList;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use App\Livewire\Forms\PostForm;
use Illuminate\Support\Facades\Auth;

class Post extends Component
{

    public PostForm $form;

    public function submit()
    {
        $data = $this->validate();

        $data['slug'] = $data['title'];

       $post= Auth::user()->posts()->create($data);

       broadcast(new PostEvent($post));

        $this->form->reset();
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.post',[
          
        ]);
    }
}
