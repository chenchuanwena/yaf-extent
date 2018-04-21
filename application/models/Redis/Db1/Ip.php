<?php

namespace Redis\Db1;

/**
 * 用户信息缓存
 */
class IpModel extends \Redis\Db1\AbstractModel {

    /**
     * 表名
     *
     * @var string
     */
    protected $_tableName = 'ip';

    /**
     * 计算key
     *
     * @param int $id
     * @return string
     */
    public function calcKey($id) {
        return $this->_tableName . self::DELIMITER . $id;
    }

    /**
     * 根据id查找用户信息
     *
     * @param int $id
     * @return array
     */
    public function find($id) {
        $result = $this->get($this->calcKey($id));

        if ($result) {
            return json_decode($result, true);
        }
        return null;
    }


    public function tableHSet($h,$key,$val,$experio=0){
        return $this->hset($this->calcKey($h),$key,$val,$experio);
    }

    public function tableHGet($h,$key){
        return $this->hget($this->calcKey($h),$key);
    }

    public function tableHMSet($h,$keysvalue,$experio=0){
        return $this->hmset($this->calcKey($h),$keysvalue,$experio);
    }

    public function tableHMGet($h,$keyvalues){
        return $this->hmget($this->calcKey($h),$keyvalues);
    }
    /**
     * 更新数据
     *
     * @param int $id
     * @param array $data
     */
    public function update($id, $data) {
        if(is_array($data)){
            $res=$this->set($this->calcKey($id), json_encode($data));
            return $res;
        }else{
            $res=$this->set($this->calcKey($id), $data);
            return $res;
        }

    }

    /**
     * 类实例
     *
     * @var \Redis\Db0\UserModel
     */
    private static $_instance = null;

    /**
     * 获取类实例
     *
     * @return \Redis\Db0\UserModel
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}
