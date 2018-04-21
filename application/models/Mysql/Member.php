<?php

namespace Mysql;

/**
 * 用户表连接类
 */
class MemberModel extends \Mysql\AbstractModel {

    /**
     * 表名
     *
     * @var string
     */
    protected $_tableName = 'han_member';

    /**
     * 主键
     *
     * @var string
     */
    protected $_primaryKey = 'member_id';

    /**
     * 类实例

     * @var \Mysql\Slave\UserModel
     */
    private static $_instance = null;


    public function selectByWhere($whereSelect){

    }
    /**
     * 获取类实例
     *
     * @return \Mysql\Slave\UserModel
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}
