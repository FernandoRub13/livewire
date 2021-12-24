<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowPost extends Component
{
    use WithFileUploads, WithPagination;
    
    public $search = '', $sort = 'id', $direction = 'desc';

    public $post;
    public $open_edit = false;

    public $image, $identifier = null;
    public $quantity = '10';

    protected $queryString = [
        'search' => ['except' => ''], 
        'sort' => ['except' => 'id'],
        'direction' => ['except' => 'desc'],
        'page' => ['except' => 1],
        'quantity' => ['except' => '10'],
    ];



    public function mount()
    {
        $this->identifier = uniqid();
        $this->post = new Post;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected $rules = [
        'post.title' => 'required|min:5',
        'post.content' => 'required|min:10',
        
    ];

    
    public function render()
    {
        if($this->sort == '' && $this->search == '') {
            // Get only the next columns from posts: 'id', 'title', 'content', 'image'.
            $posts = Post::select(['id', 'title', 'content', 'image'])->orderBy('id', 'desc')->paginate($this->quantity);

        }else if($this->sort != ''){
            $posts = Post::where('title', 'like', "%{$this->search}%")
            ->orWhere('content', 'like', "%{$this->search}%")
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->quantity);
        }else{
            $posts = Post::where('title', 'like', "%{$this->search}%")
            ->orWhere('content', 'like', "%{$this->search}%")
            ->paginate($this->quantity);
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
