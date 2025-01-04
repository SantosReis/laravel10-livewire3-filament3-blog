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

    <div class="mb-10">
        <div class="mb-16">
            <h2 class="mt-16 mb-5 text-3xl font-bold text-yellow-500">Featured Posts</h2>
            <div class="w-full">
                <div class="grid w-full grid-cols-3 gap-10">
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
                    <div class="col-span-3 md:col-span-1">
                        <a href="http://127.0.0.1:8000/blog/fil3tutorial">
                            <div>
                                <img class="w-full rounded-xl"
                                    src="http://127.0.0.1:8000/storage/4sEsCDleYEXT4GC7AdU8BP7TBab3cx-metaZmlsYW1lbnQgY291cnNlICg0KS5wbmc=-.png">
                            </div>
                        </a>
                        <div class="mt-3">
                            <div class="flex items-center mb-2">
                                <a href="http://127.0.0.1:8000/categories/PHP" class="px-3 py-1 mr-3 text-sm text-white bg-blue-400 rounded-xl">
                                    PHP</a>
                                <p class="text-sm text-gray-500">2023-09-04</p>
                            </div>
                            <a class="text-xl font-bold text-gray-900">Filament 3 relationship manager tutorial
                            </a>
                        </div>

                    </div>
                    <div class="col-span-3 md:col-span-1">

                            <div>
                                <img class="w-full rounded-xl"
                                    src="https://via.placeholder.com/640x480.png/0000ee?text=corrupti">
                            </div>
                            <div class="mt-3">
                                <div class="flex items-center mb-2">
                                    <p class="text-sm text-gray-500">2023-08-29</p>
                                </div>
                                <a class="text-xl font-bold text-gray-900">Mary Berge</a>
                            </div>
                    </div>
                </div>
            </div>
            <a class="block mt-10 text-lg font-semibold text-center text-yellow-500"
                href="http://127.0.0.1:8000/blog">More
                Posts</a>
        </div>
        <hr>

        <h2 class="mt-16 mb-5 text-3xl font-bold text-yellow-500">Latest Posts</h2>
        <div class="w-full mb-5">
            <div class="grid w-full grid-cols-3 gap-10 gap-y-32">
                <div class="col-span-3 md:col-span-1">
                    <a href="http://127.0.0.1:8000/blog/laravel-34">
                        <div>
                            <img class="w-full rounded-xl"
                                src="http://127.0.0.1:8000/storage/3i5uKG05UnvhbORZ3ieDkvtAOL8ss5-metaZXAxNSAoMjIpLnBuZw==-.png">
                        </div>
                    </a>
                    <div class="mt-3"><a href="http://127.0.0.1:8000/blog/laravel-34">
                        </a>
                        <div class="flex items-center mb-2"><a href="http://127.0.0.1:8000/blog/laravel-34">
                            </a><a href="http://127.0.0.1:8000/categories/laravel" class="px-3 py-1 mr-3 text-sm text-white bg-red-600 rounded-xl">
                                Laravel</a>
                            <p class="text-sm text-gray-500">2023-09-05</p>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Laravel 10 tutorial feed page #34</h3>
                    </div>

                </div>
                <div class="col-span-3 md:col-span-1">
                    <a href="http://127.0.0.1:8000/blog/fil3tutorial">
                        <div>
                            <img class="w-full rounded-xl"
                                src="http://127.0.0.1:8000/storage/4sEsCDleYEXT4GC7AdU8BP7TBab3cx-metaZmlsYW1lbnQgY291cnNlICg0KS5wbmc=-.png">
                        </div>
                    </a>
                    <div class="mt-3"><a href="http://127.0.0.1:8000/blog/fil3tutorial">
                        </a>
                        <div class="flex items-center mb-2"><a href="http://127.0.0.1:8000/blog/fil3tutorial">
                            </a><a href="http://127.0.0.1:8000/categories/PHP" class="px-3 py-1 mr-3 text-sm text-white bg-blue-400 rounded-xl">
                                PHP</a>
                            <p class="text-sm text-gray-500">2023-09-04</p>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Filament 3 relationship manager tutorial</h3>
                    </div>

                </div>
                <div class="col-span-3 md:col-span-1">
                    <a
                        href="http://127.0.0.1:8000/blog/in-exercitationem-quis-dolor-consequatur-eligendi-esse-rerum">
                        <div>
                            <img class="w-full rounded-xl"
                                src="https://via.placeholder.com/640x480.png/0000ee?text=corrupti">
                        </div>
                        <div class="mt-3">
                            <div class="flex items-center mb-2">
                                <p class="text-sm text-gray-500">2023-08-29</p>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Mary Berge</h3>
                        </div>
                    </a>
                </div>
                <div class="col-span-3 md:col-span-1">
                    <a href="http://127.0.0.1:8000/blog/autem-nesciunt-architecto-doloribus-ut-id">
                        <div>
                            <img class="w-full rounded-xl"
                                src="https://via.placeholder.com/640x480.png/00ee33?text=nihil">
                        </div>
                        <div class="mt-3">
                            <div class="flex items-center mb-2">
                                <p class="text-sm text-gray-500">2023-08-29</p>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Dr. Reina Yost</h3>
                        </div>
                    </a>
                </div>
                <div class="col-span-3 md:col-span-1">
                    <a href="http://127.0.0.1:8000/blog/voluptas-ipsam-ea-officia-nostrum">
                        <div>
                            <img class="w-full rounded-xl"
                                src="https://via.placeholder.com/640x480.png/00cc33?text=in">
                        </div>
                        <div class="mt-3">
                            <div class="flex items-center mb-2">
                                <p class="text-sm text-gray-500">2023-08-29</p>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Carlie Hermann</h3>
                        </div>
                    </a>
                </div>
                <div class="col-span-3 md:col-span-1">
                    <a href="http://127.0.0.1:8000/blog/ea-officiis-tenetur-aut-voluptatem">
                        <div>
                            <img class="w-full rounded-xl"
                                src="https://via.placeholder.com/640x480.png/00eeaa?text=repudiandae">
                        </div>
                        <div class="mt-3">
                            <div class="flex items-center mb-2">
                                <p class="text-sm text-gray-500">2023-08-29</p>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Tess Kub</h3>
                        </div>
                    </a>
                </div>
                <div class="col-span-3 md:col-span-1">
                    <a
                        href="http://127.0.0.1:8000/blog/non-et-molestiae-repellat-omnis-amet-mollitia-necessitatibus">
                        <div>
                            <img class="w-full rounded-xl"
                                src="https://via.placeholder.com/640x480.png/00bb77?text=et">
                        </div>
                        <div class="mt-3">
                            <div class="flex items-center mb-2">
                                <p class="text-sm text-gray-500">2023-08-29</p>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Lysanne Schmeler</h3>
                        </div>
                    </a>
                </div>
                <div class="col-span-3 md:col-span-1">
                    <a href="http://127.0.0.1:8000/blog/itaque-officiis-accusantium-quis-distinctio">
                        <div>
                            <img class="w-full rounded-xl"
                                src="https://via.placeholder.com/640x480.png/00dd88?text=et">
                        </div>
                        <div class="mt-3">
                            <div class="flex items-center mb-2">
                                <p class="text-sm text-gray-500">2023-08-29</p>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Dr. Kiara Mohr</h3>
                        </div>
                    </a>
                </div>
                <div class="col-span-3 md:col-span-1">
                    <a href="http://127.0.0.1:8000/blog/sed-dolor-id-qui-distinctio-autem-repellat-voluptas">
                        <div>
                            <img class="w-full rounded-xl"
                                src="https://via.placeholder.com/640x480.png/002288?text=aut">
                        </div>
                        <div class="mt-3">
                            <div class="flex items-center mb-2">
                                <p class="text-sm text-gray-500">2023-08-29</p>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Alfreda Hills</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <a class="block mt-10 text-lg font-semibold text-center text-yellow-500"
            href="http://127.0.0.1:8000/blog">More
            Posts</a>
    </div>
</x-app-layout>
