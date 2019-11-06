<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use App\Role;
use App\Person;
use App\Location;
use App\Account;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function showRegister(){
        return view('auth.register');
    }

    public function registerUser(Request $request){
        if($request->password != $request->c_password){
            return redirect('/register')->with('error', 'Las contraseñas ingresadas no coinciden');
        }

        $role = Role::where('name', $request->role)->first();

        $person = new Person;
        $person->fill(['dni' => $request->dni, 'firstname' => $request->firstname, 'lastname' => $request->lastname, 'phone' => $request->phone, 'email' => $request->email]);
        $person->id_role = $role->id_role;
        $person->save();

        $account = new Account;
        $account->username = $request->username;
        $account->password = Hash::make($request->password);
        $account->id_person = $person->id_person;
        $account->save();
        
        $location = new Location;
        $location->fill($request->only(['city', 'address', 'latitude', 'longitude']));
        $location->id_person = $person->id_person;
        $location->save();      

        return redirect('/login')->with('success', 'El usuario ha sido registrado correctamente');
    }
}
