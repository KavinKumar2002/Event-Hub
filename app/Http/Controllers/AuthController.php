<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function UserRegister(Request $req)
{
    $validator = Validator::make($req->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:user_credentials,email',
        'password' => 'required|string|min:8',
        'role' => 'required|in:Admin,Supervisor',
        'college' => 'required|string|max:255',
        'collegecode' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    DB::table('user_credentials')->insert([
        'name' => $req->input('name'),
        'email' => $req->input('email'),
        'password' => bcrypt($req->input('password')),
        'role' => $req->input('role'),
        'college' => $req->input('college'),
        'collegecode' => $req->input('collegecode'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect('UserLogin')->with('success', 'User created successfully.');
}

public function UserLogin(Request $req)
{
    $req->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $email = $req->input('email');
    $password = $req->input('password');

    $user = DB::table('user_credentials')->where('email', $email)->first();

    if ($user) {
        // Check password
        if (Hash::check($password, $user->password)) {
            Session::put('role', $user->role);
            Session::put('collegecode', $user->collegecode);
            Session::put('name1', $user->name);
            return redirect('AssignedFest')->with('success', 'Login successful. Welcome, ' . session('name1') . '!');
        } else {
            return redirect('userLogin')->with('error', 'Invalid credentials. Please try again.');
        }
    } else {
        return redirect('userLogin')->with('error', 'User not found. Please try again.');
    }
}


}
