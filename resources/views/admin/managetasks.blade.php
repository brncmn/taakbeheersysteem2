<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-white">
            {{ __('Beheer taken') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold mb-4">Alle taken</h3>
                        <!-- Button for adding new task -->
                        <button id="openModalBtn" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                            + Nieuwe taak toevoegen
                        </button>
                        <!-- Modal -->
                        <div id="taskModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
                                <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Nieuwe taak maken</h2>

                                <!-- Task Form -->
                                <form action="{{ route('tasks.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300">Taak</label>
                                        <input type="text" name="name" required 
                                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300">Toegewezen aan:</label>
                                        <select name="participants" required 
                                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500">
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300">Taakbeschrijving</label>
                                        <textarea name="description" rows="3"
                                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500"></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300">Extra informatie</label>
                                        <textarea name="description" rows="3"
                                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500"></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300">Einddatum</label>
                                        <input type="date" name="due_date"
                                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500">
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="button" id="closeModalBtn"
                                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg mr-2">
                                            Annuleer
                                        </button>
                                        <button type="submit" 
                                            class="bg-blue-600 text-black px-4 py-2 rounded-lg">
                                            Toevoegen
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- Task Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse border border-gray-300 dark:border-gray-700 shadow-sm rounded-lg">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Taak</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Toegewezen aan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Verloopdatum</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($tasks as $task)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $task->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            @foreach($task->participants as $participant)
                                                <span class="inline-block bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-white px-2 py-1 text-xs rounded-md">
                                                    {{ $participant->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @php
                                                $statusColors = [
                                                    'To Do' => 'bg-gray-300 text-gray-900',
                                                    'In Progress' => 'bg-yellow-400 text-white',
                                                    'Completed' => 'bg-green-500 text-white',
                                                    'On Hold' => 'bg-red-500 text-white',
                                                ];
                                            @endphp
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColors[$task->status] ?? 'bg-gray-300 text-gray-900' }}">
                                                {{ $task->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') : 'No Due Date' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>                                                           
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const openModalBtn = document.getElementById("openModalBtn");
        const closeModalBtn = document.getElementById("closeModalBtn");
        const taskModal = document.getElementById("taskModal");

        openModalBtn.addEventListener("click", function () {
            taskModal.classList.remove("hidden");
        });

        closeModalBtn.addEventListener("click", function () {
            taskModal.classList.add("hidden");
        });

        // Close modal when clicking outside the modal box
        window.addEventListener("click", function (event) {
            if (event.target === taskModal) {
                taskModal.classList.add("hidden");
            }
        });
    });
    </script>
</x-app-layout>
