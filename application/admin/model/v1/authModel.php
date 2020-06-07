<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/5/1
 * Time: 20:49
 */

namespace app\admin\model\v1;


use think\Model;

class authModel extends Model
{
    protected $table="auth";
    /*public function __construct($data = [])
    {
        echo $data["table"];
        $this->table=$data["table"];
        parent::__construct($data);
    }*/
}