<?php

// ************** Site **************
Route::get('/', function () {
    return view('welcome');
});

// ************** Authentication **************
Route::get('/login', 'Auth\LoginController@showLogin');
Route::get('/register', 'Auth\RegisterController@showRegister');
Route::post('/register', 'Auth\RegisterController@registerUser')->name('register-user');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// ************** Products **************
Route::get('/products/search/{p?}', 'App\ProductController@searchProducts')->name('search-products');
Route::get('/products/{p?}', 'App\ProductController@showPageList')->name('products');
Route::get('/products/ajax/list/{p?}', 'App\ProductController@getProductList')->name('product-list');
Route::get('/products/ajax/get/{external}', 'App\ProductController@getProduct')->name('get-product');
Route::get('/products/view/{external}', 'App\ProductController@showPageDetail');
Route::post('/products/add', 'App\ProductController@addProduct')->name('add-product');
Route::post('/products/delete', 'App\ProductController@deleteProduct')->name('delete-product');
Route::post('/products/add/detail', 'App\ProductController@addProductDetail')->name('add-product-detail');
Route::post('/products/add/lot', 'App\ProductController@addProductLot')->name('add-product-lot');
Route::post('/products/add/image', 'App\ProductController@addImage')->name('add-product-image');
Route::put('/products/edit', 'App\ProductController@editProduct')->name('edit-product');
Route::delete('/products/delete/image', 'App\ProductController@deleteImage')->name('delete-image');

// ************** Users **************
Route::get('/users/search/{p?}', 'App\UserController@searchUsers')->name('search-users');
Route::get('/users/{p?}', 'App\UserController@showPageList')->name('users');
Route::post('/users/add', 'App\UserController@addUser')->name('add-user');
Route::post('/users/enable', 'App\UserController@enableAccount')->name('enable-user');
Route::post('/users/disable', 'App\UserController@disableAccount')->name('disable-user');
Route::post('/users/restore', 'App\UserController@resetPassword')->name('restore-user');
Route::post('/users/auth/edit', 'App\UserController@editUserInfo')->name('edit-auth-user');
Route::post('/users/auth/password', 'App\UserController@editUserPass')->name('edit-pass-user');
Route::post('/users/auth/location', 'App\UserController@editUserLocation')->name('edit-location-user');
Route::get('/users/ajax/customers', 'App\UserController@getCustomers')->name('list-customers');
Route::put('/users/edit', 'App\UserController@editUser')->name('edit-user');

// ************** Orders **************
Route::get('/orders/search/{p?}', 'App\OrderController@searchOrders')->name('search-orders');
Route::get('/orders/new', 'App\OrderController@showAddOrder')->name('new-order');
Route::get('/orders/{p?}', 'App\OrderController@showPageList')->name('orders');
Route::get('/orders/view/{external}', 'App\OrderController@viewOrder')->name('view-order');
Route::post('/orders/add', 'App\OrderController@addOrder')->name('add-order');
Route::post('/orders/cancel', 'App\OrderController@cancelOrder')->name('cancel-order');

// ************** Sales **************
Route::get('/sales/search/{p?}', 'App\SaleController@searchSales')->name('search-sales');
Route::get('/sales/{p?}', 'App\SaleController@showPageList')->name('sales');
Route::post('/sales/add', 'App\SaleController@addSale')->name('add-sale');
Route::post('/sales/paid', 'App\SaleController@setPaid')->name('paid-sale');

// ************** Reports **************
Route::get('/reports', 'App\ReportController@showPageList')->name('reports');

// ************** Config **************
Route::get('/config', 'App\ConfigController@showMainPage')->name('config');
Route::get('/config/account', 'App\ConfigController@showAccountConfig')->name('config-account');
Route::get('/config/system', 'App\ConfigController@showSystemConfig')->name('config-system');
Route::post('/config/system/email', 'App\ConfigController@setConfigEmail')->name('set-config-email');

// ************** Mailing and PDF Generation **************
Route::get('/mails/order/status', function () {
    $order = App\Order::all()->first();
    return new App\Mail\OrderStatus($order);
});

Route::name('print')->get('/print/{external}', function($external){
    $sale = App\Sale::where('external_id', $external)->first();
    $pdf = \PDF::loadView('app.pdf.bill', compact('sale'));
    return $pdf->download('FACTURA_'.$sale->code.'_'.date('d/m/Y', strtotime($sale->code)).'.pdf');
});

// ************** Data Generation **************
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