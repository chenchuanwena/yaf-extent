<?php

namespace DAO;
use Our\NameConst;


/**
 * 用户数据层
 */
class MemberModel extends \DAO\AbstractModel {
    private $memberMysql;
    public function init(){
        $this->memberMysql=\Mysql\MemberModel::getInstance();
    }
    /**
     * 根据用户编号查找数据
     *
     * @param int $userId
     * @return array
     */
    public function find($userId) {

        $redis = \Redis\Db0\MemberModel::getInstance();
        $user  = $redis->find($userId);
        if (!$user) {
            $mysql = \Mysql\MemberModel::getInstance();
            $user  = $mysql->find($userId);
            if ($user) {
                $redis->update($userId, $user);
            }
        }
        return $user;
    }
    //原生方法
    public function query(){
        $mysql=\Mysql\Slave\MemberModel::getInstance();
        $res=$mysql->query("select * from han_member");
        echo json_encode($res);
        exit;
    }
    //对主库进行操作
    public function update($sql){
        $mysql=\Mysql\UserModel::getInstance();
        $res=$mysql->excute($sql);
        return $res;
    }
    public function getOneByMobileAndPassword($mobile,$password){
        $where[NameConst::memberMobile]=$mobile;
        $where[NameConst::memberPasswd]=$password;
        $column=array('member_id','member_name','member_truename','member_avatar','member_sex','member_birthday','member_mobile','member_mobile_bind','member_qq','member_qqopenid','member_qqinfo','member_wxinfo','member_wxopenid','member_sinaopenid','member_sinainfo','member_points','member_state','member_quicklink','member_exppoints','store_id','iswx','agree_flag','seller_id','diliveryman_id','member_tag_ids','member_group_ids','is_teacher');
        $result=$this->memberMysql->selectByWhereWithColumns($where,$column);
        return $result;
    }
    /**
     * 类实例
     *
     * @var \DAO\UserModel
     */
    private static $_instance = null;

    /**
     * 获取类实例
     *
     * @return \DAO\UserModel
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }


}
