<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;

class UserRolesController extends Controller
{
    public function index()
    {
        $users = User::with('userRoles')->get();
        $menus = Menu::all();

        return view('user.user_roles.index', compact('users', 'menus'));
    }

    public function getMenu(Request $request)
    {
        $user = User::with('menus')->findOrFail($request->id_user);
        $assignedMenus = $user->menus->pluck('id')->toArray();

        $parentMenus = [];
        foreach ($assignedMenus as $menuId) {
            $this->getParentMenus($menuId, $parentMenus);
        }

        $allMenus = array_unique(array_merge($assignedMenus, $parentMenus));

        return response()->json(['assignedMenus' => $allMenus]);
    }

    private function getParentMenus($menuId, &$parentMenus)
    {
        $menu = Menu::find($menuId);

        if ($menu && $menu->parent != 0) {
            $parentMenus[] = $menu->parent;
            $this->getParentMenus($menu->parent, $parentMenus);
        }
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'menus' => 'nullable|array',
            'menus.*' => 'exists:menu,id',
        ]);

        $userId = $validated['id_user'];
        $menuIds = $validated['menus'] ?? [];

        DB::transaction(function () use ($userId, $menuIds) {
            DB::table('user_roles')->where('id_user', $userId)->delete();

            foreach ($menuIds as $menuId) {
                DB::table('user_roles')->insert([
                    'id_user' => $userId,
                    'id_menu' => $menuId,
                    'created_by' => auth()->id(),
                    'created_at' => now(),
                ]);
            }
        });

        return redirect()->back()->with('success', 'User roles updated successfully.');
    }
}
