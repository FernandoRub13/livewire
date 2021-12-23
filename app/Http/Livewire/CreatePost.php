<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public $open = false;

    public $title  = "";
    public $content = "";
    public $image = null;
    public $identifier = null;

    public function mount()
    {
        $this->identifier = uniqid();
    }

    protected $rules = [
        'title' => 'required|min:5',
        'content' => 'required|min:10'
    ];


    public function render()
    {
        return view('livewire.create-post');
    }

    public function createPost()
    {
        $validatedData = $this->validate([
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $image = $this->image->store('posts');

        Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image' => $image
        ]);

        $this->reset([
            'title',
            'content',
            'open',
        ]);
        
        $this->identifier = uniqid();

        $this->emitTo('show-post', 'postSaved');
        $this->emit('alert', 'success', 'Post creado', 'El post se ha creado correctamente');
    }

}
