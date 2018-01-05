<?php

use Illuminate\Database\Seeder;
use App\Menu;

class MenuTable extends Seeder
{
    public $entries;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->entries['dashboard'] = new Menu([
        'name' => 'Yönetim Paneli',
        'url' => '/dashboard',
        'tooltip' => 'Sitenin Genel Yönetimi',
        'weight' => 1,
        'parent' => 0
      ]);

      $this->entries['articles'] = new Menu([
        'name' => 'Makaleler',
        'url' => '/articles',
        'tooltip' => 'Makaleleri Yönetiniz',
        'weight' => 3,
        'parent' => 0
      ]);

      $this->entries['home'] = new Menu([
        'name' => 'Ana Sayfa',
        'url' => '/',
        'tooltip' => '',
        'weight' => 1,
        'parent' => 0
      ]);

      $this->entries['about_us'] = new Menu([
        'name' => 'Hakkımızda',
        'url' => '/about-us',
        'tooltip' => '',
        'weight' => 2,
        'parent' => 0
      ]);

      $this->entries['albums'] = new Menu([
        'name' => 'Albümler',
        'url' => '/albums',
        'tooltip' => 'Albümlerinizi Yönetin',
        'weight' => 5,
        'parent' => 0
      ]);

      $this->entries['admin'] = new Menu([
        'name' => 'Admin Panel',
        'url' => '/admin',
        'tooltip' => 'Sitenin genel ayarlarını yönetin',
        'weight' => 2,
        'parent' => 0
      ]);
    }
}
