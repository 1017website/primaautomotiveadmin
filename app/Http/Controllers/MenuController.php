<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MenuController extends Controller
{
    public function getUserMenus(): array
    {
        $user = User::where('id', auth()->id())->with([
            'menus' => function ($query) {
                $query->orderBy('order', 'asc');
            }
        ])->first();

        if (!$user) {
            return [];
        }

        return $this->buildMenuTree($user->menus->toArray());
    }

    private function buildMenuTree($menus, $parentId = 0)
    {
        $menuTree = [];

        foreach ($menus as $menu) {
            if ($menu->parent == $parentId) {
                $children = $this->buildMenuTree($menus, $menu->id);

                $menuItem = [
                    'id' => $menu->id,
                    'name' => $menu->name,
                    'url' => $menu->url,
                    'children' => $children
                ];

                $menuTree[] = $menuItem;
            }
        }

        return $menuTree;
    }
}
