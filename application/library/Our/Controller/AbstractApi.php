<?php

namespace Our;
use Error\CodeConfigModel;
use Error\ErrorModel;

/**
 * api模块控制器抽象类
 *
 * @package Our
 * @author iceup <sjlinyu@qq.com>
 */
abstract class Controller_AbstractApi extends \Our\Controller_Abstract {

    public $config;
    public $redis;
    public $key;
    /**
     * api控制器直接输出json格式数据，不需要渲染视图
     */
    public function init() {
        $postData=$this->getRequest()->getPost(NameConst::data);
        if(isset($postData[NameConst::sessionKey])&&!empty($postData[NameConst::sessionKey])){
            $this->key=$postData[NameConst::sessionKey];
            $this->redis=\Redis\Db0\MemberModel::getInstance();
            $redisKeyValue=$this->redis->tableHGet($this->key,NameConst::sessionKey);
            if(!empty($redisKeyValue)){
                if($redisKeyValue!=$this->key){
                    ErrorModel::throwException(CodeConfigModel::illegalAccess);
                }
            }
        }else{
            $this->key=Common::bulidToken();
            $this->redis->tableHSet($this->key,NameConst::sessionKey,$this->key,ApiConst::tenMin);
        }
        \Our\Common::$requestTime=time();
        \Yaf\Dispatcher::getInstance()->disableView();
    }
    public function getAuthKey(){
        $this->key=Common::bulidToken();
        $this->redis->hset($this->key,NameConst::sessionKey,$this->key,ApiConst::tenMin);
    }

    public function isLogin(){
        $redisKeyValue=$this->redis->tableHGet($this->key,NameConst::memberName);
        if($redisKeyValue){
            return true;
        }else{
            return false;
        }
    }

    public function loginCheck(){

    }

}
