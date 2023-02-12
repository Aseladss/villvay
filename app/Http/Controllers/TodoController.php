<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Todo;
use App\Userhastodo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        
        $user_id = $this->getUserId($request);
        
        $todo = Todo::join('userhastodos', 'userhastodos.todo_id', '=', 'todos.id')
             ->select('todos.*')
             ->where('userhastodos.user_id', $user_id);       
             
        
        if ($request->wantsJson()) {

            $response = [
                'todo' => $todo->get()
            ];
            return response($response, 200);
        }
        
        $todo = $todo->get();
        return view('pages.todo')->with('todos', $todo);
    }
    
    private function getUserId($request) {
        
        $userId = null;
        
        if ($request->wantsJson()) {
            $user = Auth::user();
            $userId = $user->id;
        }else{
            $user = Session::get('user_info');
            $userId = $user->id;
        }
        
        return $userId;
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500']
        ]);
        
        $user_id = $this->getUserId($request);
        
        $todo = Todo::create([
                        'name' => $validatedData['name'],
                        'description' => $validatedData['description'],
                        'status' => '0'
            ]);

            Userhastodo::create([
                'user_id' => $user_id,
                'todo_id' => $todo->id,
            ]);

        if ($request->wantsJson()) {

            $response = [
                'todo' => $todo
            ];
            return response($response, 201);
        }
        
        return redirect()->route('todo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        try{
        $user_id = $this->getUserId($request);
        
        $todo = Todo::join('userhastodos', 'userhastodos.todo_id', '=', 'todos.id')
             ->select('todos.*')
             ->where('userhastodos.user_id', $user_id)
             ->where('todos.id', $id)
             ->update(['todos.status' => '1']);
        
        if ($todo) {
            
            if ($request->wantsJson()) {
            return response()->json([
            'message' => 'Record updated successfully'
            ], 200);
            }
        
            $list = $this->gettheList($user_id);
        
            return view('includes.todolist')->with('todos', $list);
            
        }
        
        } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollBack();
                echo $ex->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request) {
        try{
        $user_id = $this->getUserId($request);
        
        $todo = Todo::join('userhastodos', 'userhastodos.todo_id', '=', 'todos.id')
             ->select('todos.*')
             ->where('userhastodos.user_id', $user_id)
             ->where('todos.id', $id)
             ->get();
        
        if ($todo) {
         Userhastodo::where('todo_id', $id)->delete();
         Todo::where('id', $id)->delete();
        }
        
        if ($request->wantsJson()) {
            return response()->noContent();
        }
        
        $left = $this->gettheList($user_id);
        
        return view('includes.todolist')->with('todos', $left);
        
        } catch (\Illuminate\Database\QueryException $ex) {
                DB::rollBack();
                echo $ex->getMessage();
            }
    }

    private function gettheList($user_id) {
        
        $todo = Todo::join('userhastodos', 'userhastodos.todo_id', '=', 'todos.id')
             ->select('todos.*')
             ->where('userhastodos.user_id', $user_id)
             ->get();
        
        return $todo;
    }

}
