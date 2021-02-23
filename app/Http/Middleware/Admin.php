<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

use function PHPSTORM_META\type;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role=='admin') {
            set_admin_panel_variables();
            return $next($request);
        } 
        else {
            $role_id=Auth::user()->role_id;
            $access=DB::table('role_accesses')->where('role_id', $role_id)->first();
            if ($role_id>0 && $access) {
                if ($request->route()->getName()=="error403") {
                    set_author_admin_variables($access->access);
                    View::share('access', $access->access);
                    return $next($request);
                } elseif ($request->route()->getName()=="admin") {
                    return redirect('/admin/panel');
                } elseif ($request->route()->getName()=="author_panel") {
                    set_author_admin_variables($access->access);
                    View::share('access', $access->access);
                    return $next($request);
                } else {
                    $AccessList=User::AccessList();
                    $checkUserAccess=checkUserAccess($access->access, $request->route()->getName(), $AccessList);
                    if ($checkUserAccess) {
                        set_author_admin_variables($access->access);
                        View::share('access', $access->access);
                        return $next($request);
                    } else {
                        return redirect('/admin/403');
                    }
                }
            } else {
                return redirect('/');
            }
        }
    }
}
