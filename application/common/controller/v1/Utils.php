<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/1
 * Time: 20:54
 */

namespace app\common\controller\v1;


class Utils
{
    //获取表名
    public function tables($index){
        $info=config("database");
        return $info["prefix"].$info["table"][$index];
    }

    //获取随机数
    public function  getRandStr($length,$type){
        switch ($type){
            case 1:
                $dataStr="0123456789";
                break;
            case 2:
                $dataStr="abcdefghijklmnopqrstuvwxyz";
                break;
            case 3:
                $dataStr="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                break;
            case 4:
                $dataStr="0123456789abcdefghijklmnopqrstuvwxyz";
                break;
            case 5:
                $dataStr="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                break;
            case 6:
                $dataStr="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                break;
            case 7:
                $dataStr="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                break;
            case 8:
                $dataStr="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|";
                break;
            default:
                $dataStr="0123456789";
                break;
        }

        if (!is_int($length) || $length<0){
            return false;
        }
        $backStr="";
        for ($i=0;$i<$length;$i++){
            $backStr.=$dataStr[mt_rand(0,strlen($dataStr)-1)];
        }
        return $backStr;
    }

    //3DES解密
    public function encode3DES($string,$key){
        $res=openssl_encrypt($string,"DES-ECB",$key,OPENSSL_RAW_DATA);
        $info=base64_encode($res);
        $data=str_replace(array("+","/","="),array("-","_"),$info);
        return $data;
    }

    //3DES加密
    public function decode3DES($string,$key){
        $data=str_replace(array("-","_"),array("+","/"),$string);
        $mod4=strlen($data)%4;
        if ($mod4){
            $string=$data.substr("====",$mod4);
        }
        $info=base64_decode($string);
        $res=openssl_decrypt($info,"DES-ECB",$key,OPENSSL_RAW_DATA);
        return $res;
    }

    //公共返回方法
    public function backData($code,$msg,$data=[]){
        $info=[
            "code"=>$code,
            "msg"=>$msg,
        ];
        if ($data){
            $info["body"]=$data;
        }
        return $info;
    }
}