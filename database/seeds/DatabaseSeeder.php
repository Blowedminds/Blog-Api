<?php

require('LanguageTable.php');
require('CategoryTable.php');
require('MenuTable.php');
require('RoleTable.php');
require('UserTable.php');

use Illuminate\Database\Seeder;
use App\UserData;
use App\MenuRole;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new UserTable();
        $user->run();

        $menu = new MenuTable();
        $menu->run();

        $role = new RoleTable();
        $role->run();

        $category = new CategoryTable();
        $category->run();

        $language = new LanguageTable();
        $language->run();

        $this->saveAll([$user, $menu, $role, $category, $language]);

        $this->createUserData($user->entries['user']->user_id, $role->entries['admin']->id);

        $this->createMenuRole($menu->entries['dashboard']->id, $role->entries['admin']->id);
        $this->createMenuRole($menu->entries['dashboard']->id, $role->entries['author']->id);
        $this->createMenuRole($menu->entries['articles']->id, $role->entries['admin']->id);
        $this->createMenuRole($menu->entries['articles']->id, $role->entries['author']->id);
        $this->createMenuRole($menu->entries['home']->id, $role->entries['guest']->id);
        $this->createMenuRole($menu->entries['about_us']->id, $role->entries['guest']->id);
        $this->createMenuRole($menu->entries['albums']->id, $role->entries['admin']->id);
        $this->createMenuRole($menu->entries['albums']->id, $role->entries['author']->id);
        $this->createMenuRole($menu->entries['admin']->id, $role->entries['admin']->id);

    }

    private function saveAll($to_save)
    {
      foreach ($to_save as $key => $save_one) {
        foreach ($save_one->entries as $key => $save) {
          $save->save();
        }
      }
    }

    private function createUserData($user_id, $role_id)
    {
      return (new UserData([
        'user_id' => $user_id,
        'role_id' => $role_id
      ]))->save();
    }

    private function createMenuRole($menu_id, $role_id)
    {
      return (new MenuRole([
        'menu_id' => $menu_id,
        'role_id' => $role_id
      ]))->save();
    }
}
