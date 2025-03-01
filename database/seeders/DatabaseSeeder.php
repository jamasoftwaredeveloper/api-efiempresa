<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            ProductSeeder::class,
            UserSeeder::class
        ]);


        Permission::create(['name' => 'crear-producto']);
        Permission::create(['name' => 'editar-producto']);
        Permission::create(['name' => 'eliminar-producto']);
        Permission::create(['name' => 'listar-producto']);
        // Crear roles y asignar permisos
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(['crear-producto', 'editar-producto', 'eliminar-producto', 'listar-producto']);

        $editor = Role::create(['name' => 'customer']);
        // $editor->givePermissionTo([]);

        // Asignar rol a un usuario
        $user = User::find(1);
        $user->assignRole('admin');
        $user1 = User::find(2);
        $user1->assignRole('customer');
    }
}
