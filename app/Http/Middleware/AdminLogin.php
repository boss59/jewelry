<?php

namespace App\Http\Middleware;

use Closure;
use  App\Models\UserModel;
use  App\Models\RoleModel;
use  App\Models\RightModel;
use  App\Models\Role_RightModel;
use  App\Models\Admin_RoleModel;
class AdminLogin
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
        if(empty($request->session()->get('user_info'))) {
            return redirect("/admin/login");
        }else{
            $user = $request->session()->get('user_info');
            $user_id=$user['user_id'];
//        var_dump($user_id);die;
            $url = "/" . $request->path();
            $info = RoleModel::join('admin_role','admin_role.role_id','=','role.role_id')->where('user_id',$user_id)
                ->join('role_right','role_right.role_id','=','role.role_id')
                ->join('right','right.right_id','=','role_right.right_id')
                ->get()
                ->toArray();
            $var = [];

            foreach($info as $k=>$v){
                $var[] = $v['rig_name'];
            }

            if(!in_array($url,$var)){
                echo ('<script>alert("滚，你没有此权限!!!"); location.href="/admin/index"</script>');
            }else{
                return $next($request);
            }
        }
    }
}
