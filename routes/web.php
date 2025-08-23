<?php
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Middleware\CheckAdminSession;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\ConfigurationsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Web\IndexController;
use App\Helper\UrlHelper;
use App\Models\Configuration;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$uri = UrlHelper::adminUri();

Route::get("/", [IndexController::class, "index"]);

if(isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])){

    preg_match('/'.$uri.'\/*/', $_SERVER['REQUEST_URI'], $result);

    if($result){
        view()->getFinder()->setPaths([resource_path('views/themes/default/admin')]);
    }
}

view()->addNamespace("web", resource_path('views/themes/default/web'));

Route::get("$uri/", [UserController::class, 'loginPage']);
Route::get("$uri/login", [UserController::class, 'loginPage']);
Route::post("$uri/login", [UserController::class, 'login']);
Route::get("$uri/logout", [UserController::class, 'logout']);

Route::get("/test/", [\App\Http\Controllers\TestController::class, 'execute']);
//admin
Route::group(["middleware"=>[CheckAdminSession::class], "prefix"=>"/".$uri], function(){

    if(!function_exists("setBasicCRUDRoute")){
        function setBasicCRUDRoute($path, $controllerClass, $modelClass){
            // Route::get("/$uri/${path}s",[$controllerClass, 'list'])->middleware("can:read,".$modelClass);
            // Route::get("/$uri/$path",[$controllerClass, 'get'])->middleware("can:create,".$modelClass);
            // Route::post("/$uri/$path",[$controllerClass, 'save'])->middleware("can:create,".$modelClass);
            // Route::get("/$uri/".$path."/{".$path."}",[$controllerClass, 'get'])->middleware("can:update,$path");
            // Route::put("/$uri/".$path."/{".$path."}",[$controllerClass, 'save'])->middleware("can:update,$path");
            // Route::delete("/$uri/".$path."/{".$path."}",[$controllerClass, 'delete'])->middleware("can:delete,$path");
            Route::get("/${path}s",[$controllerClass, 'list'])->middleware("can:read,".$modelClass);
            Route::get("/$path",[$controllerClass, 'get'])->middleware("can:create,".$modelClass);
            Route::post("/$path",[$controllerClass, 'save'])->middleware("can:create,".$modelClass);
            Route::get("/$path/{".$path."}",[$controllerClass, 'get'])->middleware("can:update,$path");
            Route::put("/$path/{".$path."}",[$controllerClass, 'save'])->middleware("can:update,$path");
            Route::delete("/$path/{".$path."}",[$controllerClass, 'delete'])->middleware("can:delete,$path");
        }
    }

    Route::get("/system/configurations", [ConfigurationsController::class, 'get'])->middleware("can:read,".Configuration::class);
    Route::put("/system/configurations", [ConfigurationsController::class, 'save'])->middleware("can:update,".Configuration::class);

    Route::get("/dashboard",[DashboardController::class, 'execute']);


    setBasicCRUDRoute("user", UserController::class, \App\Models\User::class);
    setBasicCRUDRoute("role", RoleController::class, \App\Models\Role::class);
    setBasicCRUDRoute("store", StoreController::class, \App\Models\Store::class);
    setBasicCRUDRoute("timeslot", \App\Http\Controllers\Admin\TimeslotController::class, \App\Models\Timeslot::class);
    setBasicCRUDRoute("product_type", \App\Http\Controllers\Admin\ProductTypeController::class, \App\Models\ProductType::class);
    setBasicCRUDRoute("product", \App\Http\Controllers\Admin\ProductController::class, \App\Models\Product::class);
    setBasicCRUDRoute("option", \App\Http\Controllers\Admin\OptionController::class, \App\Models\Option::class);

});

// Route::middleware([CheckAdminSession::class])->group(["prefix"=>"/".UrlHelper::adminUri(),"as"=>"admin"], function(){

//     // $uri = UrlHelper::adminUri();
//     // Route::get("$uri/dashboard",[DashboardController::class, 'execute']);


//     // Route::get("/test/", [\App\Http\Controllers\TestController::class, 'execute']);
//     // Route::get("/test/{type}/{resolution}/{image}", [\App\Http\Controllers\TestController::class, 'testvar']);


//     // setBasicCRUDRoute("user", UserController::class, User::class);
//     // setBasicCRUDRoute("role", RoleController::class, Role::class);
//     // setBasicCRUDRoute("store", StoreController::class, Store::class);
//     // setBasicCRUDRoute("timeslot", \App\Http\Controllers\Admin\TimeslotController::class, \App\Models\Timeslot::class);
//     // setBasicCRUDRoute("menu", \App\Http\Controllers\Admin\MenuController::class, \App\Models\Menu::class);
//     // setBasicCRUDRoute("product_type", \App\Http\Controllers\Admin\ProductTypeController::class, \App\Models\ProductType::class);
//     // setBasicCRUDRoute("product", \App\Http\Controllers\Admin\ProductController::class, \App\Models\Product::class);
//     // setBasicCRUDRoute("product_attribute", \App\Http\Controllers\Admin\ProductAttributeController::class, \App\Models\ProductAttribute::class);
//     // setBasicCRUDRoute("product_attribute_set", \App\Http\Controllers\Admin\AttributeSetController::class, \App\Models\ProductAttributeSet::class);
//     // setBasicCRUDRoute("option", \App\Http\Controllers\Admin\OptionController::class, \App\Models\Option::class);
// });





