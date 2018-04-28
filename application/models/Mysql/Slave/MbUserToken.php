<?php

namespace Mysql\Slave;
use Our\Common;

/**
 * 用户表连接类
 */
class MbUserTokenModel extends \Mysql\Slave\AbstractModel {

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
    public function insertOrUpdate($data){
        $keys=array_values($data);
        $fields='';
        foreach($keys as $val){
            $fields.="'{$val}',";
        }
        if(!empty($fields)){
            $fieldValues=trim($fields,',');
            $excultSql= Common::format("INSERT INTO {0}({1}) VALUES ({2}) ON DUPLICATE KEY UPDATE member_name='{3}',token='{4}',login_time={5},client_type='{6}'",$this->_tableName,implode(',',array_keys($data)),$fieldValues,$data['member_name'],$data['token'],$data['login_time'],$data['client_type']);
            return $this->excute($excultSql);
        }else{
            return false;
        }

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
