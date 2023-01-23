<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>To-do list</title>

    {{-- Fonts --}}
    <link href="{{ asset('fonts/Nunito[wght].ttf') }}" rel="stylesheet" type="font/woff2">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <main>
        <h1>To-do list</h1>
        <ul id="todo-list" tabindex="0">
            @foreach ($todos as $todo)
                <li class="todo-list-item" data-todo-id="{{ $todo->id }}">
                    <input type="checkbox" @checked($todo->done) />
                    <span>{{ $todo->description }}</span>
                    <button type="button"> &times;</button>
                </li>
            @endforeach
        </ul>
        <form id="add-todo-form" method="POST">
            @csrf
            <textarea name="description"></textarea>
            <button type="submit">Add todo</button>
        </form>
    </main>
</body>

</html>
