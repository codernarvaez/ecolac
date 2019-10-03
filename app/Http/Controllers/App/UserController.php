<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Role;
use App\Person;
use App\Location;
use App\Account;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function showPageList(){
        $auth_user = auth()->user()->person;
        $people = Person::where('id_person', '!=', $auth_user->id_person)->get();
        return view('app.users.list', ['users' => $people]);
    }

    public function addUser(Request $request){
        $role = Role::where('name', $request->role)->first();

        $person = new Person;
        $person->fill(['dni' => $request->dni, 'firstname' => $request->firstname, 'lastname' => $request->lastname, 'phone' => $request->phone, 'email' => $request->email]);
        $person->id_role = $role->id_role;
        $person->save();

        $account = new Account;
        $account->username = $request->username;
        $account->password = Hash::make($request->username);
        $account->id_person = $person->id_person;
        $account->save();

        if($request->role == "Cliente" || $request->role == "Repartidor" || $request->role == "Vendedor"){
            $location = new Location;
            $location->fill($request->only(['city', 'address', 'latitude', 'longitude']));
            $location->id_person = $person->id_person;
            $location->save();
        }        

        return redirect('/users')->with('success', 'El usuario ha sido añadido correctamente.');
    }
}
