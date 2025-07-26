@props(['post'])

<div {{ $attributes }}>
    <a wire:navigate href="{{ route('posts.show', $post->slug) }}">
        <div>
            <img class="w-full" src="{{ $post->getThumbnailUrl() }}">
        </div>
    </a>

    {{-- <div class="flex items-center mb-2 gap-x-2">
        @if ($category = $post->categories->first())
            <x-posts.category-badge :category="$category" />
        @endif
    </div> --}}

    <div class="absolute -mt-7">
        @if ($category = $post->categories->first())
            <x-posts.category-badge :category="$category" />
        @endif
    </div>

    <div class="px-6 py-2 text-left bg-white">
        <a  wire:navigate href="{{ route('posts.show', $post->slug) }}" class="text-2xl font-medium text-gray-900">{{ $post->title }}</a>
        <p class="pb-2 pt-1 text-[11px] text-gray-500 border-b border-gray-300 border-dotted">{{ $post->published_at->format('F j, Y') }}</p>
        <div class="py-3 text-[13px] font-medium prose text-gray-950 article-content">
            {{ \Illuminate\Support\Str::words(strip_tags($post->body), 50, ' […]') }}
        </div>
    </div>
</div>
