<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditPost extends Component
{
    use WithFileUploads;

    public $post;

    public $open = false;
    public $image = null;
    public $identifier = null;

    protected $rules = [
        'post.title' => 'required|min:5',
        'post.content' => 'required|min:10',
        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ];

    public function mount(Post $post)
    {
        $this->post = $post;
        $this->identifier = uniqid();
    }

    public function render()
    {
        return view('livewire.edit-post');
    }

    public function editPost()
    {


        $this->validate();

        if($this->image) {
            Storage::delete([$this->post->image]);
            $this->post->image = $this->image->store('posts');
        }
        $this->post->save();

        $this->reset([
            'image',
            'open',
        ]);

        $this->identifier = uniqid();
        
        $this->emitTo('show-post', 'postSaved');
        $this->emit('alert', 'success', 'Post actualizado', 'El post se ha actualizado correctamente');

    }
}
