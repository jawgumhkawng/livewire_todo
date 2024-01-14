<div>

    @if (session('error'))
        <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif
    @include('livewire.includes.create-todo-box')
    @include('livewire.includes.search-box')

    <div id="todos-list">

        @forelse ($this->todos as $todo)
            @include('livewire.includes.todo-card')
        @empty
            <div
                class="todo mb-5 card px-5 text-center text-red-400 py-6 bg-white col-span-1 border-t-2 border-blue-500 hover:shadow">
                <p>there is no Todo List , Yet!</p>
            </div>
        @endforelse
        <div class="my-2">
            <!-- Pagination goes here -->
            {{ $this->todos->links() }}
        </div>
    </div>
</div>
