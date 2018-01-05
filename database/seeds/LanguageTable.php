<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguageTable extends Seeder
{
    public $entries;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $this->entries['en'] = new Language([
        'name' => 'English',
        'slug' => 'en'
      ]);

      $this->entries['tr'] = new Language([
        'name' => 'Türkçe',
        'slug' => 'tr'
      ]);
    }
}
