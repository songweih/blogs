<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/6
 * Time: 21:46
 */

namespace app\user\controller\v1;


use app\admin\controller\v1\Base;

class User extends Base
{
    public function main(){
      return  view("user/v1/index");
    }
}