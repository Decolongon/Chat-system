<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Post;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class PostForm extends Form
{

    public ?Post $post;

    public $title;

    public $body;


    public function setPost(Post $post)
    {
        $this->post = $post;

        $this->title = $post->title;
    }

    protected function rules(): array
    {
        return [
            'title' => [
                'required',
                'min:3',
                'max:255',
                Rule::unique('posts')->where('author_id', Auth::user()->id),
            ],
            
            'body' => [
                'required',
                'min:3',
                'max:255',
            ],
        ];
    }
}
