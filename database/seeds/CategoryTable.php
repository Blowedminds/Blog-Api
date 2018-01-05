<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTable extends Seeder
{

    public $entries;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->entries['bilgisayar'] = new Category([
          'name' => 'Bilgisayar',
          'slug' => 'bilgisayar',
          'description' => 'Bilgisayar Parçaları'
        ]);

        $this->entries['kitap'] = new Category([
          'name' => 'Kitap',
          'slug' => 'kitap',
          'description' => 'Kitap Kurdu'
        ]);

        $this->entries['elektronik'] = new Category([
          'name' => 'Elektronik',
          'slug' => 'elektronik',
          'description' => 'Elektronik devreler'
        ]);

        $this->entries['seyahat'] = new Category([
          'name' => 'Seyahat',
          'slug' => 'seyahat',
          'description' => 'İstanbul Hayat'
        ]);

        $this->entries['muzik'] = new Category([
          'name' => 'Müzik',
          'slug' => 'muzik',
          'description' => 'Tekno'
        ]);
    }
}
