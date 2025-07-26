<div>
    <div
        class="max-w-screen-xl mx-auto"
        x-data
        x-init="
            new Masonry($refs.grid, {
                itemSelector: '.grid-item',
                columnWidth: '.grid-sizer',
                percentPosition: true
            })
        "
        x-ref="grid"
    >
        <div class="w-full grid-sizer sm:w-1/2 md:w-1/3 lg:w-1/4"></div>

        @foreach ($posts as $post)
            <x-posts.post-card :post="$post" class="px-1 mb-4 grid-item shadow-custom" />
        @endforeach
    </div>

    @if ($posts->hasMorePages())
        <div class="mt-6 text-center">
            <button
                wire:click="nextPage"
                wire:loading.attr="disabled"
                class="px-4 py-2 text-white bg-gray-700 rounded hover:bg-gray-800"
            >
                {{ __('home.more_posts') }}
            </button>
        </div>
    @endif
</div>
