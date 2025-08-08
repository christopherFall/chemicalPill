<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-8 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Chemical Pill') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 lg:p-8">
                <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    <div class="mb-4">
                        <a href="{{ route('medicines.create') }}" class="bg-cyan-500 dark:bg-cyan-700 hover:bg-cyan-600 dark:hover:bg-cyan-800 text-white font-bold py-2 px-4 rounded">Create Medicine</a>
                    </div>

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">ID</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">NAME</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">TYPE</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">SUBTYPE</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">SIDE EFFECTS</th>
                                <th class="px-4 py-2 text-gray-900 dark:text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicines as $medicine)
                            <tr>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $medicine->id }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $medicine->name }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $medicine->type }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $medicine->subtype }}</td>
                                <td class="border px-4 py-2 text-gray-900 dark:text-white text-center">{{ $medicine->side_effects }}</td>

                                <td class="border px-4 py-2 text-center">
                                    <div class="flex justify-center">
                                        <a href="{{ route('medicines.edit', $medicine->id) }}" class="bg-violet-500 dark:bg-violet-700 hover:bg-violet-600 dark:hover:bg-violet-800 text-white font-bold py-2 px-4 rounded mr-2">Edit</a>
                                        <button type="button" class="bg-pink-400 dark:bg-pink-600 hover:bg-pink-500 dark:hover:bg-pink-700 text-white font-bold py-2 px-4 rounded" onclick="confirmDelete('{{ $medicine->id }}')">Delete</button>

                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>


<script>
    function confirmDelete(id) {
        alertify.confirm("Confirm delete record?",
        function(){
            let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/medicines/' + id;
                    form.innerHTML = '@csrf @method("DELETE")';
                    document.body.appendChild(form);
                    form.submit();
            alertify.success('Ok');
        },
        function(){
            alertify.error('Cancel');
        });
    }
</script>
