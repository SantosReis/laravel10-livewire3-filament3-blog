<x-app-layout>
    <article class="w-full col-span-4 py-5 mx-auto mt-10 md:col-span-3" style="max-width:700px">
        <img class="w-full my-2 rounded-lg" src="" alt="">
        <h1 class="text-4xl font-bold text-left text-gray-800">
            Post Title
        </h1>
        <div class="flex items-center justify-between mt-2">
            <div class="flex items-center py-5 text-base">
                <img class="w-10 h-10 mr-3 rounded-full" src=""
                    alt="avatar">
                <span class="mr-1">MN</span>
                <span class="text-sm text-gray-500">| 3 min read</span>
            </div>
            <div class="flex items-center">
                <span class="mr-2 text-gray-500">2 days ago</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.3"
                    stroke="currentColor" class="w-5 h-5 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <div
            class="flex items-center justify-between px-2 py-4 my-6 text-sm border-t border-b border-gray-100 article-actions-bar">
            <div class="flex items-center">
                <a class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 text-gray-600 hover:text-gray-900">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                    <span class="ml-2 text-gray-600">
                        1
                    </span>
                </a>
            </div>
            <div>
                <div class="flex items-center">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="w-5 h-5 text-gray-500 hover:text-gray-800">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                    </button>

                </div>
            </div>
        </div>

        <div class="py-3 text-lg text-justify text-gray-800 article-content">
            Post content
        </div>

        <div class="flex items-center mt-10 space-x-4">
            <a href="#" class="px-3 py-1 text-base text-white bg-blue-400 rounded-xl">
                Tailwind</a>
            <a href="#" class="px-3 py-1 text-base text-white bg-red-400 rounded-xl">
                Laravel</a>
        </div>

        <div class="pt-10 mt-10 border-t border-gray-100 comments-box">
            <h2 class="mb-5 text-2xl font-semibold text-gray-900">Discussions</h2>
            <textarea
                class="w-full p-4 text-sm text-gray-700 border-gray-200 rounded-lg bg-gray-50 focus:outline-none placeholder:text-gray-400"
                cols="30" rows="7"></textarea>
            <button
                class="inline-flex items-center justify-center h-10 px-4 mt-3 font-medium tracking-wide text-white transition duration-200 bg-gray-900 rounded-lg hover:bg-gray-800 focus:shadow-outline focus:outline-none">
                Post Comment
            </button>

            <!-- <a class="py-1 text-yellow-500 underline" href=""> Login to Post Comments</a> -->

            <div class="px-3 py-2 mt-5 user-comments">
                <div class="comment [&:not(:last-child)]:border-b border-gray-100 py-5">
                    <div class="flex items-center mb-4 text-sm user-meta">
                        <img class="mr-3 rounded-full w-7 h-7" src="" alt="mn">
                        <span class="mr-1">user name</span>
                        <span class="text-gray-500">. 15 days ago</span>
                    </div>
                    <div class="text-sm text-justify text-gray-700">
                        comment content
                    </div>
                </div>
                <!-- <div class="text-center text-gray-500">
                    <span> No Comments Posted</span>
                </div> -->
            </div>
        </div>


    </article>
</x-app-layout>
