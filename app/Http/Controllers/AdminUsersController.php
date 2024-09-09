<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUsersController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = new User();
    }
    public function index()
    {
        return view('admin.home');
    }

    public function login()
    {
        return view('admin.login');
    }
    public function loginProcess(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $user = $this->model::query()->where('email', '=', $email)->first();
        if ($user) {
            if (Hash::check($password, $user->password)) {
                Auth::login($user);
                return redirect()->route('admin.home');
            }
        }
        return back()->with('message', 'Email or password was invalid!');
    }
    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $this->model::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);
        return redirect()->route('admin.home');
    }

    public function edit($user)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user)
    {
        $object = $this->model::query()->find($user);
        $object->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);
        return redirect()->route('admin.index')->with('success', 'ádasdasd');
    }

    public function destroy($id)
    {
        $this->model->destroy($id);
        return redirect()->route('admin.index');
    }
}