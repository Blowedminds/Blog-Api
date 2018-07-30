<?php


namespace App\Http\Controllers;


use App\Modules\Core\Language;
use App\Modules\Core\Role;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

trait MenuTrait
{
    public function getMenus()
    {
        $language_slug = LaravelLocalization::getCurrentLocale();

        $menus = Role::slug('guest')
            ->with('permissions.menus')
            ->first()
            ->permissions
            ->reduce(function ($menus, $reduce) use ($language_slug) {

                foreach ($reduce->menus as $key => $value) {

                    $exist = false;

                    foreach ($menus as $menu) {
                        if($menu->id === $value->id) {
                            $exist = true;
                            break;
                        }
                    }

                    if(!$exist) {
                        $reduce->menus[$key]->name = $this->fillEmptyLocalizedMenu($value->name)[$language_slug];

                        $reduce->menus[$key]->tooltip = $this->fillEmptyLocalizedMenu($value->tooltip)[$language_slug];

                        $menus[] = $reduce->menus[$key];
                    }
                }

                return $menus;
            }, []);


//        whereIn('id', Role::slug('guest')->menus()->pluck('permission_id'))->menus()->map(function ($menu) use ($language_slug) {
//
//            $name = $this->fillEmptyLocalizedMenu($menu->name)[$language_slug];
//
//            $tooltip = $this->fillEmptyLocalizedMenu($menu->tooltip)[$language_slug];
//
//            return (object)[
//                'name' => $name,
//                'parent' => $menu->parent,
//                'tooltip' => $tooltip,
//                'url' => $menu->url,
//                'weight' => $menu->weight,
//            ];
//        });

        return $menus;
    }

    private function fillEmptyLocalizedMenu($localized_menu_name)
    {
        $filled_menus = [];

        foreach (Language::all() as $language) {
            if (!array_key_exists($language->slug, $localized_menu_name) || !$localized_menu_name[$language->slug])
                $filled_menus[$language->slug] = '';
            else
                $filled_menus[$language->slug] = $localized_menu_name[$language->slug];
        }

        return $filled_menus;
    }
}