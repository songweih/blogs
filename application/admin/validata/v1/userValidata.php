<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/3
 * Time: 23:40
 */

namespace app\admin\validata\v1;


use think\Validate;

class userValidata extends Validate
{
    protected $rule=[
        "email"=>[
            "require",
            "regex"=>"/^[a-z0-9A-Z]+[- | a-z0-9A-Z . _]+@([a-z0-9A-Z]+(-[a-z0-9A-Z]+)?\\.)+[a-z]{2,}$/"
        ],
        "uname"=>[
            "require"
        ]
    ];
    protected $message=[
        "email.require"=>0,
        "email.regex"=>1,
        "uname.require"=>0
    ];
}