<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/1
 * Time: 18:35
 */
return [
    // 数据库类型
    'type'            => 'mysql',
    // 服务器地址
    'hostname'        => '127.0.0.1',
    // 数据库名
    'database'        => 'blogs',
    // 用户名
    'username'        => 'root',
    // 密码
    'password'        => '123456',
    // 端口
    'hostport'        => '3306',
    // 连接dsn
    'dsn'             => '',
    // 数据库连接参数
    'params'          => [],
    // 数据库编码默认采用utf8
    'charset'         => 'utf8',
    // 数据库表前缀
    'prefix'          => 'blog_',
    //数据库表名
    'table'=>[
        //用户表
        'user'=>"user",
        //权限验证表
        "auth"=>"auth"
    ]
];