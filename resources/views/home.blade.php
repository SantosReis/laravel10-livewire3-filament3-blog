<x-app-layout title="Home Page">
    {{-- @section('hero')
        <div class="w-full py-32 text-center">
            <h1 class="text-2xl font-bold text-center bg-white md:text-3xl lg:text-5xl">
                {{ __('home.hero.title') }}  <span class="text-yellow-500">&lt;Itinerário da História&gt;</span> <span class="text-gray-900"> News</span>
            </h1>
            <p class="mt-1 text-lg text-gray-500 bg-white">{{ __('home.hero.desc') }}</p>
            <a class="inline-block px-3 py-2 mt-5 text-lg text-white bg-gray-600 rounded" href="{{ route('posts.index') }}">{{ __('home.hero.cta') }}</a>
        </div>
    @endsection --}}

    <div class="w-full mb-10">
        {{-- <div class="mb-16 text-center">
            <h2 class="px-5 py-3 mt-16 mb-5 text-3xl font-bold text-gray-700 bg-white">{{ __('home.featured_posts') }}</h2>
            <div class="w-full">
                <div class="grid w-full grid-cols-3 gap-10">
                    @foreach ($featuredPosts as $post)
                        <x-posts.post-card :post="$post" class="col-span-3 md:col-span-1" />
                    @endforeach
                </div>
            </div>
            <a class="inline-block px-3 py-2 mt-5 text-lg text-white bg-gray-600 rounded" href="{{ route('posts.index') }}">{{ __('home.more_posts') }}</a>
        </div>
        <hr> --}}

        {{-- <h2 class="px-5 py-3 mb-5 text-3xl font-bold text-gray-700 bg-white py-3mt-16">{{ __('home.latest_posts') }}</h2> --}}
        <div class="w-full mb-5 text-center">
            <div class="grid w-full grid-cols-3 gap-10">
                @foreach ($latestPosts as $post)
                    <x-posts.post-card :post="$post" class="col-span-3 md:col-span-1" />
                @endforeach
            </div>
            <a class="inline-block px-3 py-2 mt-5 text-lg text-white bg-gray-600 rounded" href="{{ route('posts.index') }}">{{ __('home.more_posts') }}</a>
        </div>
    </div>
</x-app-layout>
