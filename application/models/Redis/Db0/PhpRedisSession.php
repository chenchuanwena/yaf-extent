<?php

namespace Redis\Db0;

/**
 * �û���Ϣ����
 */
class PhpRedisSessionModel extends \Redis\Db0\AbstractModel {

    static $prefix = "";
    /**
     * ����
     *
     * @var string
     */
    protected $_tableName = 'PHPREDIS_SESSION';

    /**
     * ����key
     *
     * @param int $id
     * @return string
     */
    public function calcKey($id) {
        return $this->_tableName . self::DELIMITER . $id;
    }

    /**
     * ����id�����û���Ϣ
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

    /**
     * ��������
     *
     * @param int $id
     * @param array $data
     */
    public function update($id, $data) {
        return $this->set($this->calcKey($id), json_encode($data));
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
        return $this->tableHMGet($this->calcKey($h),$keyvalues);
    }


    public function tableDel($h){
        return $this->del($this->calcKey($h));
    }

    public function delSessionKey($key){
        return $this->getRedis()->del($this->calcKey($key));

    }
    public function getSessionKey($key){
        return $this->getRedis()->get($this->calcKey($key));
    }


    /**
     * ��ʵ��
     *
     * @var \Redis\Db0\UserModel
     */
    private static $_instance = null;

    /**
     * ��ȡ��ʵ��
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
