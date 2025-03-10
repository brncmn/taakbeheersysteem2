<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-white leading-tight">
            {{ __('Mijn taken deze week') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @php
                            $statuses = ['To Do', 'In Progress', 'Completed', 'On Hold'];
                        @endphp

                        @foreach($statuses as $status)
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ $status }}</h3>
                                <ul>
                                    @forelse($tasks[$status] ?? [] as $task)
                                        <li class="mb-2 p-3 bg-white dark:bg-gray-800 rounded-md shadow-sm">
                                            <div class="font-medium text-gray-900 dark:text-white">
                                                {{ $task->name }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                {{ $task->description }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                Einddatum: {{ \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') }}
                                            </div>

                                            <!-- Task Status Update Form -->
                                            <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="mt-2 block w-full p-2 bg-gray-200 dark:bg-gray-600 text-gray-900 dark:text-white rounded-md" onchange="this.form.submit()">
                                                    @foreach($statuses as $option)
                                                        <option value="{{ $option }}" {{ $task->status === $option ? 'selected' : '' }}>
                                                            {{ $option }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </li>
                                    @empty
                                        <p class="text-sm text-gray-500 dark:text-gray-300">Geen taken</p>
                                    @endforelse
                                </ul>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
