<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/1
 * Time: 21:19
 */

namespace app\admin\controller\v1;


use app\admin\model\v1\authModel;
use app\common\controller\v1\Utils;
use think\Controller;

class Base extends Controller
{
    public function _initialize()
    {
        $uname=cookie("user");
        if (!$uname){
            $this->error("请先登陆","/web/user/login");
        }
        $info=cache($uname);
        if (!$info){
            $this->error("请先登陆","/web/user/login");
        }
        /*if ($info["rule"]!=1){
            $moudle=request()->module();
            $con=request()->controller();
            $action=request()->action();
            $method=$moudle."/".$con."/".$action;
            $model=new authModel();
            $rule=$model->where("url",$method)->value("rule");
            if (!$rule){
                
            }
        }*/
    }
}