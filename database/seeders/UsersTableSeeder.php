<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;
use Str;
use App\Models\Appsetting;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('appsettings')->delete();
        $appSetting = new Appsetting();
        $appSetting->app_name    = 'ADMIN PORTAL';
        $appSetting->app_logo    = 'assets/images/logo.png';
        $appSetting->email       = 'info@nrtsms.com';
        $appSetting->address     = '446, DEMO ADDRESS';
        $appSetting->mobilenum   = '9165895223';
        $appSetting->app_key     = Str::random(35);
        $appSetting->save();


        DB::table('users')->delete();
        $adminUser = new User();
        $adminUser->id      = '1';
        $adminUser->userType      = 'admin';
        $adminUser->name          = 'Admin';
        $adminUser->email         =  'admin@gmail.com';
        $adminUser->email_verified_at = date('Y-m-d H:i:s');
        $adminUser->password      =   \Hash::make(123456);
        $adminUser->address       = 'DEMO';
        $adminUser->mobile        = '26565654555';
        $adminUser->companyName   = 'DEMO COMPANY Pvt. Ltd.';
        $adminUser->status        = 1;
        $adminUser->app_key       = Str::random(35);
        $adminUser->app_secret    = Str::random(15);
        $adminUser->save();


      /*  $adminUser = User::factory()->count(1)->create([
            'email'    => env('TEST_ADMIN_EMAIL'),
            'password' => Hash::make(env('TEST_ADMIN_PASSWORD'))
        ]);*/

        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        Permission::create(['name' => 'edit-profile', 'guard_name' => 'web']);
        Permission::create(['name' => 'users-list', 'guard_name' => 'web']);
        Permission::create(['name' => 'user-view', 'guard_name' => 'web']);
        Permission::create(['name' => 'user-create', 'guard_name' => 'web']);
        Permission::create(['name' => 'user-edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'user-delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'user-action', 'guard_name' => 'web']);
        Permission::create(['name' => 'role-list', 'guard_name' => 'web']);
        Permission::create(['name' => 'role-create', 'guard_name' => 'web']);
        Permission::create(['name' => 'role-edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'role-delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'permission-list', 'guard_name' => 'web']);
        Permission::create(['name' => 'permission-create', 'guard_name' => 'web']);
        Permission::create(['name' => 'permission-edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'permission-delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'app-setting', 'guard_name' => 'web']);
        Permission::create(['name' => 'manage-box', 'guard_name' => 'web']);
        Permission::create(['name' => 'boxes', 'guard_name' => 'web']);
        Permission::create(['name' => 'products', 'guard_name' => 'web']);
        Permission::create(['name' => 'product-create', 'guard_name' => 'web']);
        Permission::create(['name' => 'product-edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'product-delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'box-create', 'guard_name' => 'web']);
        Permission::create(['name' => 'assign-box', 'guard_name' => 'web']);
        Permission::create(['name' => 'box-edit', 'guard_name' => 'web']);



        // create admin roles and assign existing permissions
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        //assign role
        $adminUser->assignRole('admin');
    }
}
