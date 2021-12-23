<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class ShowPost extends Component
{
    use WithFileUploads;
    public $search = '', $sort = '', $direction = 'desc';

    public $post;
    public $open_edit = false;

    public $image, $identifier = null;

    public function mount()
    {
        $this->identifier = uniqid();
        $this->post = new Post;
    }

    protected $rules = [
        'post.title' => 'required|min:5',
        'post.content' => 'required|min:10',
        
    ];

    
    public function render()
    {
        if($this->sort == '' && $this->search == '') {
            // Get only the next columns from posts: 'id', 'title', 'content', 'image'.
            $posts = Post::select(['id', 'title', 'content', 'image'])->orderBy('id', 'desc')->get();

        }else if($this->sort != ''){
            $posts = Post::where('title', 'like', "%{$this->search}%")
            ->orWhere('content', 'like', "%{$this->search}%")
            ->orderBy($this->sort, $this->direction)
            ->get();
        }else{
            $posts = Post::where('title', 'like', "%{$this->search}%")
            ->orWhere('content', 'like', "%{$this->search}%")
            ->get();
        }

        return view('livewire.show-post', compact('posts'));
    }

    public function order($sort){
        $this->sort = $sort;
        $this->direction = $this->direction == 'asc' ? 'desc' : 'asc';
    }

    public function edit(Post $post)
    {
        $this->post = $post; 
        $this->open_edit = true;
    }

    public function update(){
        $this->validate();

        if($this->image) {
            Storage::delete([$this->post->image]);
            $this->post->image = $this->image->store('posts');
        }
        $this->post->save();

        $this->reset([
            'image',
            'open_edit',
        ]);

        $this->identifier = uniqid();
        $this->emit('alert', 'success', 'Post actualizado', 'El post se ha actualizado correctamente');
    }

}
