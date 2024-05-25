<?php

use Livewire\Volt\Component;
use App\Models\Todo;

new class extends Component {
    public Todo $todo;
    public string $todoName = "";

    public function createTodo()
    {
        $this->validate([
            'todoName' => 'required|min:3'
        ]);


        Auth::user()->todos()->create([
            'name' => $this->pull('todoName')
        ]);
    }

    public function deleteTodo(int $id)
    {
        $todo = Auth::user()->todos()->find($id);
        $this->authorize('delete', $todo);
        $todo->delete();
    }

    public function with()
    {
        return [
            'todos' => Auth::user()->todos()->get()
        ];
    }

}; ?>

<div>
    <form wire:submit='createTodo'>
        <x-text-input wire:model='todoName'></x-text-input>
        <x-primary-button type='submit'>Create</x-primary-button>
        <x-input-error :messages="$errors->get('todoName')" />
    </form>

    @foreach ($todos as $todo )

    <div wire:key='{{ $todo->name }}'>
        <div>
            {{ $todo->name }}
            <button wire:click='deleteTodo({{ $todo-> id}})' class="">Delete</button>
        </div>

    </div>
    @endforeach
</div>
