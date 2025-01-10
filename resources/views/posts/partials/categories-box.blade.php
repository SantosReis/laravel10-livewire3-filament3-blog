<div id="recommended-topics-box">
    <h3 class="mb-3 text-lg font-semibold text-gray-900">Recommended Topics</h3>
    <div class="flex flex-wrap justify-start gap-2 topics">
        @foreach ($categories as $category)
            {{-- <x-badge textColor="red" bgColor="red">{{ $category->title }}</x-badge> --}}
            <x-badge wire:navigate href="{{ route('posts.index', ['category' => $category->slug ]) }}" :textColor="$category->text_color" :bgColor="$category->bg_color">{{ $category->title }}</x-badge>
        @endforeach
    </div>
</div>
