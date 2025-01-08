<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class PostList extends Component
{
    use WithPagination;

    #[Url()]
    public $sort = 'desc';

    #[Url()]
    public $search = '';

    #[Url()]
    public $category = '';

    public function setSort($sort)
    {
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
    }

    #[On('search')]
    public function updateSearch($search)
    {
        $this->search = $search;
        // $this->resetPage();
    }

    #[Computed()]
    public function posts(){
        return Post::published()
            // ->with('author', 'categories')
            ->when(Category::where('slug', $this->category)->first(), function ($query) {
                $query->withCategory($this->category);
            })
            ->orderBy('published_at', $this->sort)
            ->where('title', 'like', "%{$this->search}%")
            // ->search($this->search)
            ->paginate(3);
        // return Post::published()->orderBy('published_at', 'desc')->simplePaginate(3);
    }

    public function render()
    {
        return view('livewire.post-list');
    }
}
