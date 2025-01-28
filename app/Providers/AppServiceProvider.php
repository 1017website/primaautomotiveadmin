<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('price', function ($money) {
            return "<?php echo number_format($money,0,',','.'); ?>";
        });

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                if ($user->is_owner == 1) {
                    $menus = Menu::orderBy('level', 'asc')
                        ->orderBy('order', 'asc')
                        ->get();
                } else {
                    $menus = Menu::join('user_roles', 'menu.id', '=', 'user_roles.id_menu')
                        ->where('user_roles.id_user', Auth::id())
                        ->orderBy('menu.level', 'asc')
                        ->orderBy('menu.order', 'asc')
                        ->select('menu.*')
                        ->get();
                }
                
                $menuArray = $menus->mapWithKeys(function ($menu) {
                    return [
                        $menu->id => [
                            'id' => $menu->id,
                            'name' => $menu->name,
                            'url' => $menu->url,
                            'parent' => $menu->parent,
                            'level' => $menu->level,
                            'order' => $menu->order,
                            'icon' => $menu->icon,
                        ]
                    ];
                })->toArray();

                $allMenus = Menu::select('id', 'name', 'url', 'parent', 'level', 'order', 'icon')->get()->keyBy('id')->toArray();

                foreach ($menuArray as $menu) {
                    $this->addParent($menuArray, $menu, $allMenus);
                }

                usort($menuArray, function ($a, $b) {
                    return $a['level'] === $b['level'] ? $a['order'] <=> $b['order'] : $a['level'] <=> $b['level'];
                });

                $view->with('userMenus', $menuArray);
            }
        });
    }

    /**
     * Recursively adds missing parent menus.
     *
     * @param array $menuArray The reference array of menus.
     * @param array $menu The child menu being checked.
     * @param array $allMenus All available menus for lookup.
     */
    private function addParent(&$menuArray, $menu, $allMenus)
    {
        if ($menu['parent'] !== 0 && !isset($menuArray[$menu['parent']])) {
            if (isset($allMenus[$menu['parent']])) {
                $parentMenu = $allMenus[$menu['parent']];
                $menuArray[$parentMenu['id']] = $parentMenu;
                $this->addParent($menuArray, $parentMenu, $allMenus);
            }
        }
    }
}
