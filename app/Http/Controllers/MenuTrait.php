<?php


namespace App\Http\Controllers;


use App\Modules\Core\Language;
use App\Modules\Core\Menu;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

trait MenuTrait
{
    public function getMenus()
    {
        $language_slug = LaravelLocalization::getCurrentLocale();

        $menus = Menu::whereHas('menuRoles', function($q){
                    $q->where('role_id', 3);
                })->orderBy('weight', 'ASC')->get()->map( function ($menu) use ($language_slug)  {

                    $name = $this->fillEmptyLocalizedMenu($menu->name)[$language_slug];

                    $tooltip = $this->fillEmptyLocalizedMenu($menu->tooltip)[$language_slug];

                    return (object) [
                        'name' => $name,
                        'parent' => $menu->parent,
                        'tooltip' => $tooltip,
                        'url' => $menu->url,
                        'weight' => $menu->weight,
                    ];
                });
        return $menus;
    }

    private function fillEmptyLocalizedMenu($localized_menu_name)
    {
        $filled_menus = [];

        foreach (Language::all() as $language) {
            if(!array_key_exists($language->slug, $localized_menu_name) || !$localized_menu_name[$language->slug])
                $filled_menus[$language->slug] = '';
            else
                $filled_menus[$language->slug] = $localized_menu_name[$language->slug];
        }

        return $filled_menus;
    }
}