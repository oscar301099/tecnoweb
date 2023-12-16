<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Crear el rol administrador
        $role1 = Role::create(['name' => 'Admin']);
        //Crear el rol cliente
        $role2 = Role::create(['name' => 'Cliente']);
        //Crear el rol Empleado
        $role3 = Role::create(['name' => 'Empleado']);

        //Crear permisos
        Permission::create(['name' => 'admin'])->syncRoles([$role1]);
/*
        Permission::create(['name' => 'admin.users.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.show'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.store'])->syncRoles([$role1]);


        Permission::create(['name' => 'admin.productos.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.productos.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.productos.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.productos.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.productos.create'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.categorias.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categorias.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categorias.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categorias.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categorias.create'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.categorias.indexCliente'])->syncRoles([$role2]);

        Permission::create(['name' => 'admin.perfil.index'])->syncRoles([$role1]);
*/
        Permission::create(['name' => 'empleado.admin'])->syncRoles([$role3],[$role1]);


    }
}
