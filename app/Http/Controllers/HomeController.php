<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return view('account')->with('user', $user);
    }
    public function edit_account(){
        $user = User::find(Auth::user()->id);
        return view('account-edit')->with('user', $user);
    }
    public function edit_password(){
        return view('account-password');
    }
    public function update_password(Request $request){
        $validator = Validator::make($request->all(),[
            'password' => ['required', 'string', 'max:255', 'min:6']
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }else{
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return redirect('/account')->with('success_message', 'Password successfully changed!');
        }
    }
    public function update_account(Request $request){
        $validator = null;
        $user = User::find(Auth::user()->id);
        if($request->input('username') == $user->username && $request->input('email') == $user->email){
            $data = ['name' => $request->input('name')];
            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255']
            ]);
            $user->name = $data['user'];
        }else if($request->input('username') == $user->username){
            $data = ['email' => $request->input('email'), 'name' => $request->input('name')];
            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
            ]);
            $user->name = $data['name'];
            $user->email = $data['email'];
        }else if($request->input('email') == $user->email){
            $data = ['username' => $request->input('username'), 'name' => $request->input('name')];
            $validator = Validator::make($data, [
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'name' => ['required', 'string', 'max:255']
            ]);
            $user->name = $data['name'];
            $user->username = $data['username'];
        }else{
            $validator = Validator::make($request->all(), [
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
            ]);
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->name = $request->input('name');
        }
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }else{
            $user->save();
            return redirect('/account')->with('success_message', 'Account updated!');
        }
    }
}
