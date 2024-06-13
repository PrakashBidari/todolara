<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('My To Do List') }}
        </h2>
    </x-slot>

    <div class="" style="display: grid;place-content:center;width:100%;height:auto; margin-top:20px;">
        <form action="{{ route('todo.store') }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input class="min-w-[300px]" type="text" name="title">
            <button class="bg-blue-600 h-full px-5 text-white hover:bg-blue-500" type="submit">Add</button>
        </form>
    </div>

    <div style="display: grid;place-content:center;width:100%;height:auto; margin-top:50px;">
        @if ($toDoLists->count())
            @foreach ($toDoLists as $toDoList)
                <div class="mt-2">
                    <input type="hidden" name="user_id" data-id="{{ $toDoList->user_id }}"
                        value="{{ $toDoList->user_id }}">
                    <input title="{{ $toDoList->title }}" class="min-w-[300px]" type="text" name="title" value="{{ $toDoList->title }}" readonly>
                    <a href="#" class="bg-blue-600 py-3 px-5 text-white hover:bg-blue-500 edit-btn"
                        data-id="{{ $toDoList->id }}" data-title="{{ $toDoList->title }}">Edit</a>
                    <form action="{{ route('toDoLists.destroy', $toDoList->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white hover:bg-red-500" style="padding: 9.5px 20px">Delete</button>
                    </form>
                </div>
            @endforeach
        @else
            <h2>No Data Found</h2>
        @endif

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-btn').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    var toDoId = this.dataset.id;
                    var toDoTitle = this.dataset.title;
                    var toDoUserId = this.closest('div').querySelector('input[name="user_id"]')
                        .value;

                    var newTitle = prompt("Edit ToDo Title:", toDoTitle);

                    if (newTitle !== null && newTitle !== toDoTitle) {
                        var form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '/toDoLists/' + toDoId;

                        var token = document.createElement('input');
                        token.type = 'hidden';
                        token.name = '_token';
                        token.value = '{{ csrf_token() }}';
                        form.appendChild(token);

                        var method = document.createElement('input');
                        method.type = 'hidden';
                        method.name = '_method';
                        method.value = 'PUT';
                        form.appendChild(method);

                        var titleInput = document.createElement('input');
                        titleInput.type = 'hidden';
                        titleInput.name = 'title';
                        titleInput.value = newTitle;
                        form.appendChild(titleInput);

                        var userIdInput = document.createElement('input');
                        userIdInput.type = 'hidden';
                        userIdInput.name = 'user_id';
                        userIdInput.value = toDoUserId;
                        form.appendChild(userIdInput);

                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
</x-app-layout>
