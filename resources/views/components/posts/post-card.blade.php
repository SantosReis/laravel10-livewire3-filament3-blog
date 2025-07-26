@props(['post'])

<div {{ $attributes }}>
    <a  wire:navigate href="{{ route('posts.show', $post->slug) }}">
        <div>
            <img class="w-full" src="{{ $post->getThumbnailUrl() }}">
        </div>
    </a>
    <div class="p-3 bg-white">
        <div class="flex items-center mb-2 gap-x-2">
            @if ($category = $post->categories->first())
                <x-posts.category-badge :category="$category" />
            @endif
            <p class="text-sm text-gray-500">{{ $post->published_at->format('d/m/Y') }}</p>
        </div>
        <a  wire:navigate href="{{ route('posts.show', $post->slug) }}" class="text-xl font-bold text-gray-900">{{ $post->title }}</a>
        <div class="py-3 text-base prose text-justify text-gray-800 article-content">
            {!! $post->body !!}
        </div>
    </div>
</div>
