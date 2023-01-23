<?php

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/add-todo', function (Request $request) {
    $validated = validator($request->all(), [
        'description' => ['required']
    ]);

    if ($validated->fails()) {
        return response("Invalid fields", 400);
    }

    $insert = Todo::create([
        'description' => $request->description
    ]);

    if (!$insert) {
        return response('Server error.', 503);
    }

    return response(Todo::all());
});

Route::put('/update-todo', function (Request $request) {
    $validated = validator($request->all(), [
        'id' => ["required", "exists:todos,id"],
        'done' => ['required', 'boolean']
    ]);

    if ($validated->fails()) {
        return response("Invalid fields", 400);
    }

    $todo = Todo::find($request->id);
    $todo->done = $request->done;
    $saved = $todo->save();

    if (!$saved) {
        return response('Server error.', 503);
    }

    return response(true, 200);
});

Route::delete('/delete-todo', function (Request $request) {
    $validated = validator($request->all(), [
        'id' => ["required", "exists:todos,id"]
    ]);

    if ($validated->fails()) {
        return response("Invalid fields", 400);
    }

    $deleted = Todo::find($request->id)->delete();

    if (!$deleted) {
        return response('Server error.', 503);
    }

    return response(true, 200);
});
