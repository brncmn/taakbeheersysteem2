<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mijn taken') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold">{{ __("Welcome to your Dashboard!") }}</h3>
                        <p>{{ __("You're logged in.") }}</p>
                    </div>

                    <!-- Display the tasks for the logged-in user -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($tasks as $task)
                            <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm">
                                <h5 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $task->name }}</h5>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $task->description }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Due: {{ \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Status: {{ $task->status }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
