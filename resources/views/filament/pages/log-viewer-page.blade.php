<x-filament::page>

    <div class="mb-4">
        <x-filament::button
            tag="a"
            href="{{ url(config('log-viewer.route_path', 'log-viewer')) }}"
            target="_blank"
            color="primary"
        >
            Open Log Viewer in New Tab
        </x-filament::button>
    </div>

    <iframe
        src="{{ url(config('log-viewer.route_path', 'log-viewer')) }}"
        style="width:100%; height:80vh; border:none;"
    ></iframe>
</x-filament::page>
