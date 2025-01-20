<div id="recommended-topics-box">
    <h3 class="mb-3 text-lg font-semibold text-gray-900">{{ __('blog.recommended_topics') }}</h3>
    <div class="flex flex-wrap justify-start gap-2 topics">
        @foreach ($categories as $category)
            {{-- <x-badge textColor="red" bgColor="red">{{ $category->title }}</x-badge> --}}
            <x-posts.category-badge :category="$category" />
        @endforeach
    </div>
</div>
