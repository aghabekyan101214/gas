<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Page;
use Illuminate\Support\Facades\DB;

class CheckRole
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
        if(Auth::user()->role != 1) {
            $answer = $this->get_url();
            return $answer == 0 ? redirect("/admin") : $next($request);
        } else {
            return $next($request);
        }
    }

    private function get_url()
    {
        $arr = explode("/", url()->current());
        return $this->check($arr);
    }

    private function check($arr)
    {
        if(isset($arr[4])){
            $arr[4] = $arr[4] != "users" ?? "admins";
            $page = Page::where("name", $arr[4])->first();
            $data = DB::table("admins_pages")->where(["page_id" => $page->id, "user_id" => Auth::user()->id])->first();
            if(null != $data) {
                return 1;
            }
            return 0;
        }
        return 0;
    }
}
