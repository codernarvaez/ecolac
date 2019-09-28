<?php

// Site 
Route::get('/', function () {
    return view('welcome');
});

// Authentication
Route::get('/login', 'Auth\LoginController@showLogin');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Products
Route::get('/products', 'App\ProductController@showPageList')->name('products');
Route::get('/products/view/{external}', 'App\ProductController@showPageDetail');

Route::post('/products/add', 'App\ProductController@addProduct')->name('add-product');
Route::post('/products/add/detail', 'App\ProductController@addProductDetail')->name('add-product-detail');
Route::post('/products/add/lot', 'App\ProductController@addProductLot')->name('add-product-lot');

Route::put('/products/edit', 'App\ProductController@editProduct')->name('edit-product');

// Users
Route::get('/users', 'App\UserController@showPageList')->name('users');

Route::post('/users/add', 'App\UserController@addUser')->name('add-user');

// Orders
Route::get('/orders', 'App\OrderController@showPageList')->name('orders');

// Sales 
Route::get('/sales', 'App\SaleController@showPageList')->name('sales');

// Reports
Route::get('/reports', 'App\ReportController@showPageList')->name('reports');

// Config
Route::get('/config', 'App\ConfigController@showMainPage')->name('config');

// Data Generation
Route::get('/generate', function () {
    $role = App\Role::first();
    if(!$role){
        $admin = App\Role::firstOrCreate(['name' => 'Superadmin']);
        $administrator = App\Role::firstOrCreate(['name' => 'Administrador']);
        $seller = App\Role::firstOrCreate(['name' => 'Vendedor']);
        $seller = App\Role::firstOrCreate(['name' => 'Repartidor']);
        $auditor = App\Role::firstOrCreate(['name' => 'Auditor']);
        $customer = App\Role::firstOrCreate(['name' => 'Cliente']);

        $person = new App\Person;
        $person->fill(['dni' => '0000000000', 'firstname' => 'Admin', 'lastname' => 'Admin', 'phone' => '0000000000', 'email' => 'admin@example.com']);
        $person->id_role = $admin->id_role;
        $person->save();

        $account = new App\Account;
        $account->username = 'admin';
        $account->password = Illuminate\Support\Facades\Hash::make("admin");
        $account->id_person = $person->id_person;
        $account->save();

        return response()->json([
            'msg' => 'The data has been generated correctly.',
            'roles' => [
                'admin' => $admin,
                'administrator' => $administrator,
                'seller' => $seller,
                'auditor' => $auditor,
                'customer' => $customer
            ],
            'admin' => [
                'person' => $person,
                'account' => $account
            ]
        ]);
    }

    return response()->json(['msg' => 'The data has already been generated.']);
});