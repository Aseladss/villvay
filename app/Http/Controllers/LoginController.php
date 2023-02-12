<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if ($request->session()->get('user_info')) {
            $request->session()->forget('user_info');
        }
        return view('pages.login');
    }

    public function register() {
        return view('pages.register');
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:3']
        ]);

        $user = User::create([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => Hash::make($validatedData['password']),
        ]);

        if ($request->wantsJson()) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }

        return view('pages.login')->with('success', 'Registration successful, please login');
    }

    public function login(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if ($user && Hash::check($request->password, $user->password)) {
            //            check if the request coming from the api
            if ($request->wantsJson()) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ];
            return response($response, 201);
            }
            $request->session()->put('user_info', $user);
            return redirect()->route('todo.index');
        }else{
            if ($request->wantsJson()) {
                abort(404);
            }
            return back()->withErrors(['error' => 'User not found']);
        }
        

        
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
