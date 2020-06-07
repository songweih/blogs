<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use \think\Route;

//公共
//测试
Route::get('web/user/test', "home/v1.User/test");
//数据库创建
Route::get("web/db/table","admin/v1.Create/create");
//登陆页面
Route::get("web/user/login","home/v1.User/login");
//检测用户名是否已经被注册
Route::get('web/user/checkUser', "home/v1.User/checkUser");
//管理员主页
Route::rule('web/admin/main', "admin/v1.User/main");
//用户入口
Route::rule('web/user/main', "home/v1.User/main");

//管理员

//用户

//游客