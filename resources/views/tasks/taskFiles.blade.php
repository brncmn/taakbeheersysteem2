<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-white leading-tight">
            {{ __('Mijn Bestanden') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">Bestanden van Mijn Taken</h3>

                    @if ($files->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400">Er zijn geen bestanden voor jouw taken.</p>
                    @else
                        <!-- Files Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse border border-gray-300 dark:border-gray-700 shadow-sm rounded-lg">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Bestand</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Taak</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Download</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($files as $file)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                {{ Str::limit($file->file_name, 30) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                {{ $file->task->name ?? 'Geen taak' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="text-blue-500 hover:underline">
                                                    Download
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
