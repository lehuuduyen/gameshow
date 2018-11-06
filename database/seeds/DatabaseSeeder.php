<?php
	use Illuminate\Database\Seeder;
	class DatabaseSeeder extends Seeder{
		/**
		 * Run the database seeds.
		 *
		 * @return void
		 */
		public function run(){
		    $this->call(\Modules\Employee\Database\Seeders\EmployeeDatabaseSeeder::class);

		    //Roles
			DB::table( 'roles' )->insert( [
				'name'        => 'superadmin',
				'guard_name'  => 'web',
				'description' => 'full roles',
			] );
			DB::table( 'roles' )->insert( [
				'name'        => 'admin',
				'guard_name'  => 'web',
				'description' => 'admins',
			] );
			DB::table( 'roles' )->insert( [
				'name'        => 'customer',
				'guard_name'  => 'web',
				'description' => 'customer',
			] );
			//Permission
			DB::table( 'permissions' )->insert( [
				'name'        => 'create-user',
				'guard_name'  => 'web',
				'description' => 'create-user',
			] );
			DB::table( 'permissions' )->insert( [
				'name'        => 'edit-user',
				'guard_name'  => 'web',
				'description' => 'edit-user',
			] );
			DB::table( 'permissions' )->insert( [
				'name'        => 'delete-user',
				'guard_name'  => 'web',
				'description' => 'delete-user',
			] );
			DB::table( 'permissions' )->insert( [
				'name'        => 'role',
				'guard_name'  => 'web',
				'description' => 'role',
			] );
			DB::table( 'permissions' )->insert( [
				'name'        => 'permission',
				'guard_name'  => 'web',
				'description' => 'permission',
			] );
			//Create user
			DB::table( 'users' )->insert( [
				'name'     => 'superadmin',
				'email'    => 'superadmin@gmail.com',
				'password' => '$2y$10$zXM0SKF7ZHd5pOhl12RH..k2x0J/S9dqtIXGaxXi7QLgOrZa1kgX.',
			] );
			//Add role to user
			DB::table( 'model_has_roles' )->insert( [
				'role_id'    => 1,
				'model_id'   => 1,
				'model_type' => 'App\User',
			] );
		}
	}
