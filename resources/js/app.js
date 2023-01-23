import './bootstrap';


$('#todo-list').on('change', '.todo-list-item > input[type=checkbox]', function (e) {
    let todoId = $(this.parentElement).attr('data-todo-id')
    let checkbox = this

    fetch('api/update-todo', {
        method: "PUT",
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            id: todoId,
            done: this.checked
        })
    })
        .then(response => {
            if (response.status !== 200) {
                console.error('Error:', response.statusText);
                alert(response.statusText)
                checkbox.checkbox !== checkbox.checkbox
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Faild to delete to-do item.')
        })
})


$('#todo-list').on('click', '.todo-list-item > button', function () {
    let todoListItem = $(this.parentElement)
    let todoId = todoListItem.attr('data-todo-id')

    fetch('api/delete-todo', {
        method: "DELETE",
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            id: todoId
        })
    })
        .then(response => {
            if (response.status === 200) {
                todoListItem.remove()
            } else {
                console.error('Error:', response.statusText);
                alert(response.statusText)
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Faild to delete to-do item.')
        });

})

$('#add-todo-form').on('submit', function (e) {
    e.preventDefault()

    let textarea = this.querySelector('textarea')

    let body = new FormData()
    body.append('description', textarea.value)

    fetch('api/add-todo', {
        method: 'POST',
        body: body
    })
        .then(response => {
            if (response.status !== 200) {
                console.error('Error:', response.text);
                alert(response.statusText)
                return false;
            }
            return response.text()
        })
        .then(raw => {
            if (raw) {
                const data = JSON.parse(raw);
                data.forEach(todo => {
                    console.dir(todo)
                    let todoListItem = $(`.todo-list-item[data-todo-id=${todo.id}]`)
                    if (!todoListItem.length) {
                        $('#todo-list').append(`
                            <li class="todo-list-item" data-todo-id="${todo.id}">
                                <input type="checkbox" ${todo.done ? "checked" : ""} />
                                <span>${todo.description}</span>
                                <button type="button"> &times;</button>
                            </li>
                        `)
                    }
                });
            }

            textarea.value = ''
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Faild to submit data.')
        });

})

