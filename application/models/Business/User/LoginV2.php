<?php

namespace Business\User;
use DAO\MemberModel;
use DAO\UserModel;

/**
 * 用户登录业务
 */
class LoginV2Model extends \Business\AbstractModel {

    /**
     * 登录业务
     * 
     * @param array $params
     * @return
     */
    public function login() {
        $userM=MemberModel::getInstance();

        //系统封装好的方法
       $one=$userM->find(1);
      //系统自带走从库方法
       return $one;
        $user= $userM->query();

        //系统原生走主库
        $user  =$userM->update("UPDATE Member SET member_name='abc' WHERE member_id=1");
        return $user;


    }

    /**
     * 登录业务
     * 
     * @var \Business\User\LoginV2Model
     */
    private static $_instance = null;

    /**
     * 单例模式获取类实例
     * 
     * @return \Business\User\LoginV2Model
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}
