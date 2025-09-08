<div class="w-full text-center">
    <div
        x-data
        x-init="
            const masonry = new Masonry($refs.grid, {
                itemSelector: '.grid-item',
                columnWidth: '.grid-sizer',
                percentPosition: true
            });

            Livewire.hook('message.processed', () => {
                masonry.reloadItems();
                masonry.layout();
            });
        "
        x-ref="grid"
        class="max-w-screen-xl mx-auto"
    >
        <!-- Grid sizer (used by Masonry to define column width) -->
        <div class="w-full grid-sizer sm:w-1/2 md:w-1/3 lg:w-1/4"></div>

        @foreach ($posts as $post)
            <x-posts.post-card :post="$post" class="px-1 mb-4 grid-item shadow-custom" />
        @endforeach
    </div>

    <!-- Load More button -->
    {{-- @if ($posts->hasMorePages())
        <div class="mt-6 text-center">
            <button
                wire:click="loadMore"
                wire:loading.attr="disabled"
                class="px-4 py-2 text-white bg-gray-700 rounded hover:bg-gray-800"
            >
                {{ __('home.more_posts') }}
            </button>
        </div>
    @endif --}}

    {{-- <div class="mt-6 text-center">
        {{ $posts->links('pagination::tailwind') }}
    </div> --}}

<div class="flex justify-between mt-6">
    {{-- Previous Page Link --}}
    @if ($posts->onFirstPage())
        <span class="px-4 py-2 text-gray-600 bg-gray-300 rounded cursor-not-allowed">Previous</span>
    @else
        <a href="{{ $posts->previousPageUrl() }}"
           class="px-4 py-2 text-white bg-gray-700 rounded hover:bg-gray-800">
           Previous
        </a>
    @endif

    {{-- Next Page Link --}}
    @if ($posts->hasMorePages())
        <a href="{{ $posts->nextPageUrl() }}"
           class="px-4 py-2 text-white bg-gray-700 rounded hover:bg-gray-800">
           Next
        </a>
    @else
        <span class="px-4 py-2 text-gray-600 bg-gray-300 rounded cursor-not-allowed">Next</span>
    @endif
</div>

</div>
