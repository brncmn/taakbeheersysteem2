<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-white">
            {{ __('Beheer taken') }}
        </h2>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                        <select name="participants[]" multiple required 
                                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500">
                                            <option value="" disabled selected>Selecteer een deelnemer</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300">Taakbeschrijving</label>
                                        <textarea name="taskdescription" rows="3"
                                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500"></textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label class="block text-gray-700 dark:text-gray-300">Extra informatie</label>
                                        <textarea name="information" rows="3"
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
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Acties</th>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <!-- Edit Button -->
                                            <button onclick="editTask({{ $task->id }}, '{{ $task->name }}', '{{ $task->due_date }}', '{{ $task->description }}', '{{ $task->comments }}')" class="text-blue-500 hover:text-blue-700 text-xs font-semibold mr-2">
                                                Edit
                                            </button>
                                            <!-- Edit Task Modal -->
                                            <div id="editTaskModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
                                                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-full max-w-md">
                                                    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Taak bewerken</h2>
                                                    <form action="{{ route('tasks.update', $task->id) }}"  id="editTaskForm" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <input type="hidden" id="editTaskId" name="task_id">

                                                        <div class="mb-4">
                                                            <label class="block text-gray-700 dark:text-gray-300">Taaknaam</label>
                                                            <input type="text" id="editTaskName" name="name" required
                                                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500">
                                                        </div>                                

                                                        <div class="mb-4">
                                                            <label class="block text-gray-700 dark:text-gray-300">Taakbeschrijving</label>
                                                            <textarea name="taskdescription" rows="3" id="editTaskDescription"
                                                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500"></textarea>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="block text-gray-700 dark:text-gray-300">Extra informatie</label>
                                                            <textarea name="comments" rows="3" id="editTaskComment"
                                                                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500"></textarea>
                                                        </div>

                                                        <div class="mb-4">
                                                            <label class="block text-gray-700 dark:text-gray-300">Einddatum</label>
                                                            <input type="date" id="editTaskDueDate" name="due_date"
                                                                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-500">
                                                        </div>

                                                        <div class="flex justify-end">
                                                            <button type="button" id="closeEditModalBtn"
                                                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg mr-2">
                                                                Annuleer
                                                            </button>
                                                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                                                                Opslaan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- Delete Button -->
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" id="deleteForm" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete()"class="text-red-500 hover:text-red-700 text-xs font-semibold">
                                                    Verwijder
                                                </button>
                                            </form>
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
    function confirmDelete() {

            Swal.fire({
                title: 'Weet je het zeker?',
                text: 'Deze actie kan niet ongedaan worden gemaakt!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ja, verwijder het!',
                cancelButtonText: 'Annuleer'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the form
                    document.getElementById('deleteForm').submit();
                }
            });
        }

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

    function editTask(id, name, due_date, description, comments) {
        document.getElementById("editTaskId").value = id;
        document.getElementById("editTaskName").value = name;
        document.getElementById("editTaskDescription").value = description;
        document.getElementById("editTaskComment").value = comments;
        document.getElementById("editTaskDueDate").value = due_date;

        // Open the modal
        document.getElementById("editTaskModal").classList.remove("hidden");

        // Update the form action dynamically
        document.getElementById("editTaskForm").action = `/tasks/${id}`;
    }

    // Close modal
    document.getElementById("closeEditModalBtn").addEventListener("click", function () {
        document.getElementById("editTaskModal").classList.add("hidden");
    });

    // Close modal when clicking outside
    window.addEventListener("click", function (event) {
        const modal = document.getElementById("editTaskModal");
        if (event.target === modal) {
            modal.classList.add("hidden");
        }
    });
    </script>
</x-app-layout>
