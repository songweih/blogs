<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/1
 * Time: 18:08
 */

namespace app\admin\controller\v1;

use app\admin\model\v1\createModel;
use app\admin\model\v1\userModel;
use app\admin\validata\v1\createValidata;
use app\common\controller\v1\Utils;

class Create
{
    public function create()
    {
        $validata = new createValidata();
        $checkData = [
            "uname" => request()->param("uname"),
            "pwd" => request()->param("pwd")
        ];
        if (!$validata->check($checkData)) {
            return $validata->getError();
        }
        $connect = config("database");
        $conn = mysqli_init();
        if ($conn == null) {
            return "数据库连接初始化失败";
        }
        mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 5);
        if (!mysqli_real_connect($conn, $connect["hostname"], $connect["username"], $connect["password"], "", intval($connect["hostport"]))) {
            mysqli_close($conn);
            return "数据库连接失败";
        }
        if (mysqli_select_db($conn, $connect["database"])) {
            $info = $this->createAll($connect["prefix"], $connect["table"]);
        } else {
            $sql = "CREATE DATABASE " . $connect["database"];
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                mysqli_close($conn);
                return "数据库创建失败";
            }
            mysqli_select_db($conn, $connect["database"]);
            $info = $this->createAll($connect["prefix"], $connect["table"]);
        };
        if ($info) {
            return $info;
        }
        if ($this->addAdmin()){
            return "所有表创建成功";
        }
        return "所有表创建失败";
    }

    private function createAll($prefix, $data)
    {
        foreach ($data as $k => $vo) {
            $name = $prefix . $vo;
            if (!$this->checkTable($name)) {
                switch ($k) {
                    case "user":
                        if (!$this->userTable($name)) {
                            return $name . " 表创建失败";
                        }
                        break;
                    case "auth":
                        if (!$this->authTable($name)) {
                            return $name . " 表创建失败";
                        }
                        break;
                    default:
                        return $name . " 表不在创建范围内";
                        break;
                }
            }
        }
        return false;
    }

    private function checkTable($name)
    {
        $model = new createModel();
        return $model->query("SHOW TABLES LIKE '" . $name . "'");

    }

    private function userTable($tableName)
    {
        $sql = "CREATE TABLE ` . $tableName .` (
`uid`  varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '代码生成的32位随机字符' ,
`email`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL COMMENT '唯一邮箱' ,
`pwd`  varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '登陆密码，长度大于6小于100，非纯数字和字母' ,
`uname`  varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`rule`  int(4) NOT NULL DEFAULT NULL COMMENT '用户权限',
`reg_time`  datetime NOT NULL COMMENT '注册时间' ,
`login_time`  datetime NOT NULL COMMENT '登陆时间' ,
PRIMARY KEY (`uid`),
UNIQUE INDEX `email` (`email`) USING BTREE 
)
ENGINE=MyISAM
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
CHECKSUM=0
ROW_FORMAT=DYNAMIC
DELAY_KEY_WRITE=0
;";
        $model = new createModel();
        return $model->query($sql);
    }

    private function authTable($tableName)
    {
        $sql = "CREATE TABLE `.$tableName.` (
`rid`  int NOT NULL AUTO_INCREMENT COMMENT '自增长主键' ,
`url`  varchar(255) NOT NULL COMMENT '方法地址' ,
`rule`  int NOT NULL DEFAULT 8 COMMENT '用户权限' ,
PRIMARY KEY (`rid`),
UNIQUE INDEX (`url`) 
)
;";
        $model = new createModel();
        return $model->query($sql);
    }
//添加个超级管理员用户
    private function addAdmin(){
        $utils=new Utils();
        $name=$utils->tables("user");
        $model=new userModel();
        if ($model->table($name)->where("uname","admin")->find()){
            return true;
        }
        $data=[
           "uid"=>$utils->getRandStr(32,7),
            "pwd"=>$utils->encode3DES("123456","admin"),
            "uname"=>"admin",
            "rule"=>1,
            "reg_time"=>date("y-m-d h:i:s",time()),
            "login_time"=>date("y-m-d h:i:s",time())
        ];
        return $model->insert($data);
    }
}