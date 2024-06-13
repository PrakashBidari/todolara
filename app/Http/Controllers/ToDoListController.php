<?php

namespace App\Http\Controllers;

use App\Http\Requests\ToDoAddRequest;
use App\Models\ToDoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoListController extends Controller
{

    public function index()
    {
        $userId = Auth::user()->id;
        $toDoLists = ToDoList::query()
            ->where('user_id', $userId)->get();

        return view('dashboard', compact('toDoLists'));
    }

    public function store(ToDoAddRequest $request)
    {
        // dd($request);
        try {
            $validated_data =  $request->validated();
            $toDoList = ToDoList::create($validated_data);

            return back()->with('success', 'List Added');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    // ToDoListController.php
    public function update(ToDoAddRequest $request, $id)
    {
        try {
            $toDoList = ToDoList::findOrFail($id);
            $toDoList->title = $request->title;
            $toDoList->save();

            return redirect()->back()->with('success', 'ToDo item updated successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $toDoList = ToDoList::findOrFail($id);
            $toDoList->delete();

            return redirect()->back()->with('success', 'ToDo item deleted successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
