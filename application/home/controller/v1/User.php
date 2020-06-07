<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/2
 * Time: 11:51
 */

namespace app\home\controller\v1;

use app\admin\model\v1\userModel;

use app\admin\validata\v1\userValidata;
use app\common\controller\v1\Utils;
use think\captcha\Captcha;
use think\Controller;


class User extends Controller
{
    //登陆首页
    public function login()
    {
        return view("user/v1/login");
    }

    public function test()
    {
        return view("user/v1/test");
    }

    //用户登陆验证
    public function checkUser()
    {
        if (!request()->isAjax()) {
            $this->success("请求无效", "web/user/login");
        }
        $uname = request()->param("uname");
        $pwd = request()->param("password");
        $code = request()->param("code");
        $data = [
            "pwd" => $pwd,
            "code" => $code
        ];
        $model = new userModel();
        $captcha = new Captcha();
        $utils = new Utils();
        if (strstr($uname, "@")) {
            $data["email"] = $uname;
            $info = $this->checkParam($data);
            if (is_array($info)) {
                return $info;
            }
            if (!$captcha->check($code)) {
                return $utils->backData(captchaError, "验证码错误");
            }
            $info = $model->where("email", $uname)->find();
            if (!$info) {
                return $utils->backData(emailNotRegister, "邮箱未注册，请注册");
            }
            $sqlpwd = $utils->decode3DES($info["pwd"], $info["email"]);
            if ($sqlpwd != $pwd) {
                return $utils->backData(passwordError, "密码错误");
            }
            cookie("user", $info["uname"]);
            cache($info["uname"], $info);
            return $utils->backData(commonSuccess, "/web/user/main");
        }
        $data["uname"] = $uname;
        $info = $this->checkParam($data);
        if (is_array($info)) {
            return $info;
        }
        if (!$captcha->check($code)) {
            return $utils->backData(captchaError, "验证码错误");
        }
        $info = $model->where("uname", $uname)->find();
        if (!$info) {
            return $utils->backData(unameNotHad, "用户名未注册");
        }
        $sqlpwd = $utils->decode3DES($info["pwd"], $info["uname"]);
        if ($sqlpwd != $pwd) {
            return $utils->backData(passwordError, "密码错误");
        }
        cookie("user", $info["uname"]);
        cache($info["uname"], $info);
        return $utils->backData(commonSuccess, "/web/admin/main");
    }

    //参数验证
    private function checkParam($data)
    {
        $rule = [];
        $util = new Utils();
        $validata = new userValidata();
        if (array_key_exists("email", $data)) {
            $rule["email"] = [
                "require",
                "regex" => "/^[a-z0-9A-Z]+[- | a-z0-9A-Z . _]+@([a-z0-9A-Z]+(-[a-z0-9A-Z]+)?\\.)+[a-z]{2,}$/"
            ];
        }
        if (array_key_exists("uname", $data)) {
            $rule["uname"] = ["require"];
        }
        if (!$rule) {
            return $util->backData(paramError, "参数缺失");
        }
        if ($validata->check($data, $rule)) {
            return true;
        }
        switch ($validata->getError()) {
            case 0:
                $code = paramError;
                $msg = "参数缺失";
                break;
            case 1:
                $code = emailFormat;
                $msg = "邮箱格式错误";
                break;
            default:
                $code = paramError;
                $msg = "参数缺失";
                break;
        }
        return $util->backData($code, $msg);
    }

    //主页
    public function main(){
        return view("user/v1/index");
    }
}