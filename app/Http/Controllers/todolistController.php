<?php

namespace App\Http\Controllers;

use App\Models\todolist;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
// use Illuminate\Http\RedirectResponse;
// use App\Http\Requests\ProductUpdateRequest;

class todolistController extends Controller
{
    public function index()
    {
        $todolists = todolist::all();
        return view('home', compact('todolists'));
    }
    
    public function store(Request $request)
    {
        $data = $request -> validate(
            [
                'content' => 'required'
            ]);
    
            todolist::create($data);
            return back();
    }

    // public function edit(todolist $todolist)
    // {
    //     return view('todolists.edit', compact('todolist'));
    // }

    public function update(Request $request, $todolist)
    {
        $validated = $request->validate([
            'content' => 'required|max:255',
        ]);

        $todo = todolist::where("id", $todolist)->firstOrFail();
    
    
        $todo->update($validated);
        

        return redirect()->route('home')
            ->with('success', 'Todo updated successfully');
    }



    public function destroy(todolist $todolist)
    {
        $todolist -> delete();
        return back();
    }

    public function toggleStatus($todolist)
    {

    $todo = todolist::where("id", $todolist)->firstOrFail();
    
    

    $wasCompleted = $todo->is_completed;

    $todo->update([
        'is_completed'=> !$wasCompleted]);
    
    return back();
    }
}

