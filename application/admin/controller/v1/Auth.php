<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/1
 * Time: 20:44
 */

namespace app\admin\controller\v1;


use app\common\controller\v1\Utils;
use think\Collection;

class Auth extends Collection
{
    public function authMethod($method){
        $utils=new Utils();
        $table=$utils->tables("auth");
        $model=new authModel(["table"=>$table]);
        return $model->where("url",$method)->value("rule");
    }
}