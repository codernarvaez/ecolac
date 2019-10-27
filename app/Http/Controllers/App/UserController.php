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

    public function showPageList($p = 1){        
        $auth_user = auth()->user()->person;  
        $count = Person::where('id_person', '!=', $auth_user->id_person)->count();

        if($p > 1){
            $skip = ($p - 1) * 20;
            $people = Person::where('id_person', '!=', $auth_user->id_person)
                    ->orderBy('id_person','desc')
                    ->skip($skip)
                    ->take(20)
                    ->get();
        }else{
            $people = Person::where('id_person', '!=', $auth_user->id_person)
                    ->orderBy('id_person','desc')
                    ->take(20)
                    ->get();
        }
        
        return view('app.users.list', ['users' => $people, 'count' => $count, 'p' => $p, 'search' => '']);
    }

    public function searchUsers(Request $request, $p = 1){
        if(strlen($request->text) >= 3){
            $auth_user = auth()->user()->person; 
            $count = Person::whereRaw('(CONCAT(firstname, " ", lastname) regexp "' . $request->text . '" or dni regexp "' . $request->text . '") and id_person != '. $auth_user->id_person)->count();

            if($p > 1){
                $skip = ($p - 1) * 20;
                $people = Person::whereRaw('(CONCAT(firstname, " ", lastname) regexp "' . $request->text . '" or dni regexp "' . $request->text . '") and id_person != '. $auth_user->id_person)
                        ->orderBy('id_person','desc')
                        ->skip($skip)
                        ->take(20)
                        ->get();
            }else{
                $people = Person::whereRaw('(CONCAT(firstname, " ", lastname) regexp "' . $request->text . '" or dni regexp "' . $request->text . '") and id_person != '. $auth_user->id_person)
                        ->orderBy('id_person','desc')
                        ->take(20)
                        ->get();
            }

            return view('app.users.list', ['users' => $people, 'count' => $count, 'p' => $p, 'search' => $request->text]);
        }else{
            return redirect()->route('users');
        }        
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

    public function editUser(Request $request){
        $person = Person::where('dni', $request->dni)->first();

        $person->firstname = $request->firstname;
        $person->lastname = $request->lastname;
        $person->phone = $request->phone;
        $person->email = $request->email;

        if($request->role == "Cliente" || $request->role == "Repartidor" || $request->role == "Vendedor"){
            $person->location()
                   ->update([
                        'city' => $request->city,
                        'address' => $request->address,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude
                   ]);
        }

        $person->save();

        return redirect('/users')->with('success', 'El usuario ha sido editado correctamente.');
    }

    public function disableAccount(Request $request){
        $account = Account::where('id_account', $request->id)->first();

        $account->enabled = false;
        $account->save();

        return redirect('/users')->with('success', 'La cuenta del usuario ha sido deshabilitada.');
    }

    public function enableAccount(Request $request){
        $account = Account::where('id_account', $request->id)->first();

        $account->enabled = true;
        $account->save();

        return redirect('/users')->with('success', 'La cuenta del usuario ha sido habilitada.');
    }

    public function resetPassword(Request $request){
        $account = Account::where('id_account', $request->id)->first();

        $account->password = Hash::make($account->username);
        $account->save();

        return redirect('/users')->with('success', 'La contraseña del usuario ha sido restablecida.');
    }

    public function getCustomers(Request $request){
        $array = [];
        $role = Role::where('name', 'Cliente')->first();
        $customers = $role->people()
                            ->whereRaw('CONCAT(firstname, " ", lastname) regexp "' . $request->searchString . '" or dni regexp "' . $request->searchString . '"')
                            ->take(5)
                            ->get();

        foreach ($customers as $customer) {
            $item = ['value' => ($customer->firstname . ' ' . $customer->lastname), 'data' => $customer->id_person];
            array_push($array, $item);
        }
        
        return ["suggestions" => $array];
    }
}
