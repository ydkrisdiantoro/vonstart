<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuGroup;
use App\Models\Role;
use App\Models\RoleMenu;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VcontrolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // MENU GROUP
        $menuGroupList = [
            ['db0447b8-0342-42e1-a3a5-ec8342dbaf26', 'Main', '1'],
            ['76f349b9-ac75-4efe-bca5-323087ff84bf', 'References', '2'],
            ['194bd16f-1468-459e-870e-abffcadebc47', 'Settings', '3'],
        ];
        foreach($menuGroupList as $m){
            $menuGroup = [
                'id' => $m[0],
                'name' => $m[1],
                'order' => $m[2],
                'created_at' => now(),
            ];
            MenuGroup::updateOrInsert([
                'id' => $m[0]
            ], $menuGroup);
        }

        // MENU
        $menuList = [
            // MAIN

            // SETTINGS
            ['819c913f-dc4f-4a43-9b58-10e7abd99412', '194bd16f-1468-459e-870e-abffcadebc47', 'User', 'person', 'user', 1, null, 1],
            ['829c913f-dc4f-4a43-9b58-10e7abd99412', '194bd16f-1468-459e-870e-abffcadebc47', 'Role', 'eye', 'role', 1, null, 2],
            ['839c913f-dc4f-4a43-9b58-10e7abd99412', '194bd16f-1468-459e-870e-abffcadebc47', 'Menu Group', 'layers', 'menu-group', 1, null, 3],
            ['849c913f-dc4f-4a43-9b58-10e7abd99412', '194bd16f-1468-459e-870e-abffcadebc47', 'Menu', 'grid', 'menu', 0, null, 4],
            ['859c913f-dc4f-4a43-9b58-10e7abd99412', '194bd16f-1468-459e-870e-abffcadebc47', 'Role Menu', 'person-gear', 'role-menu', 0, null, 5],
            ['869c913f-dc4f-4a43-9b58-10e7abd99412', '194bd16f-1468-459e-870e-abffcadebc47', 'User Role', 'person-check', 'user-role', 0, null, 6],
            ['879c913f-dc4f-4a43-9b58-10e7abd99412', '194bd16f-1468-459e-870e-abffcadebc47', 'Pretend', 'bug', 'pretend', 1, null, 7],
        ];
        foreach($menuList as $m){
            $menu = [
                'id' => $m[0],
                'menu_group_id' => $m[1],
                'name' => $m[2],
                'icon' => $m[3],
                'route' => $m[4],
                'is_show' => $m[5],
                'cluster' => $m[6],
                'order' => $m[7],
                'created_at' => now(),
            ];
            Menu::updateOrInsert([
                'id' => $m[0]
            ], $menu);
        }

        // ROLES
        $roleList = [
            ['861b1583-bb92-4c6a-8c18-7a4ad828b68d', 'super', 'Superuser', 'shield-lock-fill', 1],
            ['862b1583-bb92-4c6a-8c18-7a4ad828b68d', 'user', 'User', 'shield-lock-fill', 2],
        ];
        foreach($roleList as $m){
            $role = [
                'id' => $m[0],
                'code' => $m[1],
                'name' => $m[2],
                'icon' => $m[3],
                'order' => $m[4],
                'created_at' => now(),
            ];
            Role::updateOrInsert([
                'id' => $m[0]
            ], $role);
        }

        // ROLE MENU
        $roleMenuList = [
            // MAIN - SUPERUSER

            // SETTINGS - SUPERUSER
            ['cde165af-826f-4e54-bddd-e2639e252db5','819c913f-dc4f-4a43-9b58-10e7abd99412', '861b1583-bb92-4c6a-8c18-7a4ad828b68d', 1, 1, 1, 1, 1],
            ['cde265af-826f-4e54-bddd-e2639e252db5','829c913f-dc4f-4a43-9b58-10e7abd99412', '861b1583-bb92-4c6a-8c18-7a4ad828b68d', 1, 1, 1, 1, 1],
            ['cde365af-826f-4e54-bddd-e2639e252db5','839c913f-dc4f-4a43-9b58-10e7abd99412', '861b1583-bb92-4c6a-8c18-7a4ad828b68d', 1, 1, 1, 1, 1],
            ['cde465af-826f-4e54-bddd-e2639e252db5','849c913f-dc4f-4a43-9b58-10e7abd99412', '861b1583-bb92-4c6a-8c18-7a4ad828b68d', 1, 1, 1, 1, 1],
            ['cde565af-826f-4e54-bddd-e2639e252db5','859c913f-dc4f-4a43-9b58-10e7abd99412', '861b1583-bb92-4c6a-8c18-7a4ad828b68d', 1, 1, 1, 1, 1],
            ['cde665af-826f-4e54-bddd-e2639e252db5','869c913f-dc4f-4a43-9b58-10e7abd99412', '861b1583-bb92-4c6a-8c18-7a4ad828b68d', 1, 1, 1, 1, 1],
            ['cde765af-826f-4e54-bddd-e2639e252db5','879c913f-dc4f-4a43-9b58-10e7abd99412', '861b1583-bb92-4c6a-8c18-7a4ad828b68d', 1, 1, 1, 1, 1],
        ];
        foreach($roleMenuList as $m){
            $roleMenu = [
                'id' => $m[0],
                'menu_id' => $m[1],
                'role_id' => $m[2],
                'is_create' => $m[3],
                'is_read' => $m[4],
                'is_update' => $m[5],
                'is_delete' => $m[6],
                'is_validate' => $m[7],
                'created_at' => now(),
            ];
            RoleMenu::updateOrInsert([
                'id' => $m[0]
            ], $roleMenu);
        }

        // USER
        $userList = [
            ['997a3d89-b0f6-4cc2-98c4-90ecaaae1649', 'Superuser', 'su@admin.dev', null, null, '$2y$12$1gWawy7aUthKwPFeop1IvebvcyH8bqiRfd1aK2NqHg8hqdEvbvLaS', null],
        ];
        foreach($userList as $m){
            $user = [
                'id' => $m[0],
                'name' => $m[1],
                'email' => $m[2],
                'photo' => $m[3],
                'phone' => $m[4],
                'password' => $m[5],
                'email_verified_at' => $m[6],
                'created_at' => now(),
            ];
            User::updateOrInsert([
                'id' => $m[0]
            ], $user);
        }

        // USER ROLE
        $userRoleList = [
            ['04a109c7-8e5e-4520-bc96-7431e3aefee1', '997a3d89-b0f6-4cc2-98c4-90ecaaae1649', '861b1583-bb92-4c6a-8c18-7a4ad828b68d'],
        ];
        foreach($userRoleList as $m){
            $user = [
                'id' => $m[0],
                'user_id' => $m[1],
                'role_id' => $m[2],
                'created_at' => now(),
            ];
            UserRole::updateOrInsert([
                'id' => $m[0]
            ], $user);
        }
    }
}
