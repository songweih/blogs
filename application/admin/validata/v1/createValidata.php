<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/1
 * Time: 18:56
 */

namespace app\admin\validata\v1;


use think\Validate;

class createValidata extends Validate
{
    protected $rule=[
        "uname"=>"require|eq:blog",
        "pwd"=>"require|eq:blog"
    ];
    protected $message=[
        "uname.require"=>"用户名必填",
        "uname.eq"=>"用户名不匹配",
        "pwd.require"=>"密码必填",
        "pwd.eq"=>"密码不匹配"
    ];
}