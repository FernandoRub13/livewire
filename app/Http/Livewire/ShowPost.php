<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class ShowPost extends Component
{
    public $search = '';
    public $sort = '';
    public $direction = 'desc';

    protected $listeners = [
        'postSaved' => 'render',
    ];
    
    public function render()
    {
        if($this->sort == '' && $this->search == '') {
            $posts = Post::all()->sortByDesc('id');
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
}
