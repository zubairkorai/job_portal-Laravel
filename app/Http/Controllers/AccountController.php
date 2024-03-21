<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;

class AccountController extends Controller
{
    public function registration() {
        return view("front.account.registration");
    }

    public function processRegistration(Request $request) {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email"=> "required|email|unique:users,email",
            "password"=> "required|min:5|same:confirm_password",
            'confirm_password' => "required",
        ]);
        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            
            $user->save();

            session()->flash("success","You have been registered successfully.");

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);

        }
    }

    public function login() {
        return view('front.account.login');
    }

    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {

            if(Auth::attempt(['email' => $request->email,'password'=> $request->password])) {
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('account.login')->with('error',' Either email or password is incorrect');
            }

        } else {
            return redirect()
            ->route('account.login')
            ->withErrors('$validator')
            ->withInput($request->only('email'));
        }
    }

    public function profile() {
        return view('front.account.profile');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('account.login');
    }

}
