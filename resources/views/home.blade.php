<x-app-layout>
    @section('hero')
        <div class="w-full py-32 text-center">
            <h1 class="text-2xl font-bold text-center text-gray-700 md:text-3xl lg:text-5xl">
                Welcome to <span class="text-yellow-500">&lt;YELO&gt;</span> <span class="text-gray-900"> News</span>
            </h1>
            <p class="mt-1 text-lg text-gray-500">Best Blog in the universe</p>
            <a class="inline-block px-3 py-2 mt-5 text-lg text-white bg-gray-800 rounded"
                href="http://127.0.0.1:8000/blog">Start
                Reading</a>
        </div>
    @endsection

    <div class="w-full mb-10">
        <div class="mb-16">
            <h2 class="mt-16 mb-5 text-3xl font-bold text-yellow-500">Featured Posts</h2>
            <div class="w-full">
                <div class="grid w-full grid-cols-3 gap-10">
                    @foreach ($featuredPosts as $post)
                        <div class="col-span-3 md:col-span-1">
                            <a href="http://127.0.0.1:8000/blog/laravel-34">
                                <div>
                                    <img class="w-full rounded-xl"
                                        src="http://127.0.0.1:8000/storage/3i5uKG05UnvhbORZ3ieDkvtAOL8ss5-metaZXAxNSAoMjIpLnBuZw==-.png">
                                </div>
                            </a>
                            <div class="mt-3">
                                <div class="flex items-center mb-2">
                                    <a href="http://127.0.0.1:8000/categories/laravel" class="px-3 py-1 mr-3 text-sm text-white bg-red-600 rounded-xl">
                                        Laravel
                                    </a>
                                    <p class="text-sm text-gray-500">2023-09-05</p>
                                </div>
                                <a class="text-xl font-bold text-gray-900">Laravel 10 tutorial feed page #34</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <a class="block mt-10 text-lg font-semibold text-center text-yellow-500"
                href="http://127.0.0.1:8000/blog">More
                Posts</a>
        </div>
        <hr>

        <h2 class="mt-16 mb-5 text-3xl font-bold text-yellow-500">Latest Posts</h2>
        <div class="w-full mb-5">

        </div>
        <a class="block mt-10 text-lg font-semibold text-center text-yellow-500"
            href="http://127.0.0.1:8000/blog">More
            Posts</a>
    </div>
</x-app-layout>
