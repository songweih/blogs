<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/6
 * Time: 22:40
 */

namespace app\admin\controller\v1;


class User extends Base
{
    public function main(){
       return view("user/v1/admin");
    }
}