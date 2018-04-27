<?php

namespace Mysql;
use Our\Common;

/**
 * 用户表连接类
 */
class MbUserTokenModel extends \Mysql\AbstractModel {

    /**
     * 表名
     *
     * @var string
     */
    protected $_tableName = 'han_mb_user_token';

    /**
     * 主键
     *
     * @var string
     */
    protected $_primaryKey = 'token_id';

    /**
     * 类实例

     * @var \Mysql\Slave\UserModel
     */
    private static $_instance = null;


    public function selectByWhere($whereSelect){

    }
    public function mysqlUpdate($data, $where)
    {
        return parent::update($data, $where);
    }
    public function mysqlBassExcute($data){

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
