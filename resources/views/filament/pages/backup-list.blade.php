<div class="space-y-4">
    @if(empty($backups))
        <div class="py-8 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
            </svg>
            <h3 class="mt-2 text-sm font-medium">No backups available</h3>
            <p class="mt-1 text-sm text-gray-400">Create your first backup using the actions above.</p>
        </div>
    @else
        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-lg">
            <table class="w-full min-w-full divide-y divide-gray-200 table-fixed">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase">
                            Backup File
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase">
                            Size
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold tracking-wider text-left text-gray-500 uppercase">
                            Date Created
                        </th>
                        <th class="px-6 py-3 text-xs font-semibold tracking-wider text-right text-gray-500 uppercase">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($backups as $backup)
                        <tr class="w-full transition-colors duration-150 bg-white hover:bg-gray-200">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                {{ $backup['name'] }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $backup['size'] }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                {{ $backup['date'] }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('filament.admin.pages.manage-backup.download', ['filename' => $backup['name']]) }}"
                                class="inline-flex items-center px-3 py-1 text-sm font-medium text-white transition rounded-md bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Download
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                No backups available. Use the actions above to create one.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
