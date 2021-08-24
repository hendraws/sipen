<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DeployPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('permissions')->truncate();
    	DB::table('model_has_roles')->truncate();
    	DB::table('roles')->truncate();
    	DB::statement('SET FOREIGN_KEY_CHECKS=1;');
         // Reset cached roles and permissions
    	app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    	Permission::create(['name' => 'dashboard']);
    	Permission::create(['name' => 'data-master']);
    	Permission::create(['name' => 'perkembangan']);
    	Permission::create(['name' => 'input-data']);
    	Permission::create(['name' => 'management-user']);

    	Role::create(['name' => 'admin'])->givePermissionTo(['dashboard', 'data-master','perkembangan','management-user']);
    	Role::create(['name' => 'user'])->givePermissionTo(['dashboard', 'perkembangan','input-data']);
    	
    	$user = User::first();
    	$user->assignRole('admin');
    }
}
