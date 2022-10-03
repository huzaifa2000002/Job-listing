<?php
namespace App\Http\Controllers;

use auth;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //
    public function create(Request $req){
            return view('users.register');
    }
    public function store(Request $req){
        $formFields= $req->validate([
            'name'=>['required','min:3'],
            'email'=>['required','email',Rule::unique('users','email')],
            'password'=>'required|confirmed|min:6'
            // 'password'=>'required',
            // 'password_confirmation'=>'required'
            // we use password_confirmation because we can use password confirmed method as it use that particular naming convention
        ]);
        $formFields['password'] = bcrypt($formFields['password']);
        // works like HASH:: for encryption
        $user = User::create($formFields);
        auth()->login($user);
        return redirect('/')->with('message', 'User Registered Successfully');
    }
    public function logout(Request $req) {
        auth()->logout();

        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/')->with('message', 'User have succesully logged out');
      }
    public function login(Request $req){
        return view('users.login');

    }
    public function authenticate(Request $req){
        $formFields= $req->validate([
            'email'=>['required','email'],
            'password'=>'required'

        ]);

        if(auth()->attempt($formFields)){
            $req->session()->regenerate();

            return redirect('/')->with('message','User Successfully Logged In');
        }
        return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email');
    }
}
