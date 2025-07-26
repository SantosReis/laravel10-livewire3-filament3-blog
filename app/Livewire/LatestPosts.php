<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class LatestPosts extends Component
{
    use WithPagination;

    public $perPage = 9;

    protected $paginationTheme = 'tailwind';

    public function loadMore()
    {
        $this->perPage += 9;
    }

    public function render()
    {
        return view('livewire.latest-posts', [
            'posts' => Post::published()
                ->with('categories')
                ->latest('published_at')
                ->paginate($this->perPage),
        ]);
    }
}
