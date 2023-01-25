<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    

    public function index()
{
    $todos = Todo::where('user_id', auth()->user()->id)->get();

    if($todos){

        return response()->json(['data' => $todos], 200);

    }

    else {

        return response()->json(['error' => "user not authenticated"]);

    }
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|max:255',
    ]);
    $todo = Todo::create([
        'title' => $validatedData['title'],
        'completed' => false,
        'user_id' => auth()->user()->id
    ]);
    return response()->json(['data' => $todo], 201);
}

public function update(Request $request, Todo $todo)
{
    if($todo->user_id !== auth()->user()->id) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    $validatedData = $request->validate([
        'title' => 'required|max:255',
    ]);
    $todo->update($validatedData);
    return response()->json(['data' => $todo], 200);
}

public function destroy(Todo $todo)
{
    if($todo->user_id !== auth()->user()->id) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    $todo->delete();
    return response()->json(['message' => 'Todo deleted'], 200);
}

}
