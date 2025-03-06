<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-white leading-tight">
            {{ __('Mijn taken') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <h3 class="text-xl font-semibold mb-4">Mijn taken</h3>
                    </div>

                    <!-- Task Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse border border-gray-300 dark:border-gray-700 shadow-sm rounded-lg">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Taak</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Toegewezen aan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Beschrijving</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Informatie</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Einddatum</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 uppercase">Status</th>
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            {{ $task->description }}
                                        </td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            {{ $task->comments }}
                                        </td>                                                                             
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="text-xs bg-gray-100 text-gray-900 dark:bg-gray-600 dark:text-white rounded-lg px-4 py-3 w-full" onchange="this.form.submit()">
                                                    <option value="To Do" {{ $task->status === 'To Do' ? 'selected' : '' }}>To Do</option>
                                                    <option value="In Progress" {{ $task->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="On Hold" {{ $task->status === 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                                </select>

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
        // Confirm delete function for each task
        function confirmDelete(taskId) {
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
                    // If confirmed, submit the corresponding form
                    document.getElementById('deleteForm' + taskId).submit();
                }
            });
        }

        function editTask(taskId, taskName, taskStatus, taskDueDate) {
            // Handle task editing logic here (e.g., open a modal with pre-filled values)
            console.log('Edit Task:', taskId, taskName, taskStatus, taskDueDate);
        }
    </script>
</x-app-layout>
