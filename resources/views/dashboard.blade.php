<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm">
                            <h5 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ __("Manage Profile") }}</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __("Update your personal information.") }}</p>
                        </div>

                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm">
                            <h5 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ __("Settings") }}</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __("Adjust your preferences.") }}</p>
                        </div>

                        <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-sm">
                            <h5 class="text-xl font-semibold text-gray-900 dark:text-gray-100">{{ __("Logout") }}</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __("Sign out of your account.") }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
