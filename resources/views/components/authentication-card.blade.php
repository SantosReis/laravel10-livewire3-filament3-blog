<div class="flex flex-col items-center w-full min-h-screen pt-6 bg-white sm:justify-center sm:pt-0 dark:bg-gray-900">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md dark:bg-gray-800 sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
