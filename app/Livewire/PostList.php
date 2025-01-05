<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    #[Computed()]
    public function posts(){
        return Post::published()->orderBy('published_at', 'desc')->paginate(3);
        // return Post::published()->orderBy('published_at', 'desc')->simplePaginate(3);
    }

    public function render()
    {
        return view('livewire.post-list');
    }
}
