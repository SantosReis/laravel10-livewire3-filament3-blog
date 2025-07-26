<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class LatestPosts extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        return view('livewire.latest-posts', [
            'posts' => Post::published()
                ->with('categories')
                ->latest('published_at')
                ->paginate(2)
        ]);
    }
}
