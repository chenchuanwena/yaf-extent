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
    public $req;
    /**
     * api控制器直接输出json格式数据，不需要渲染视图
     */
    public function init() {
        $this->req=$this->getRequest()->getPost();
        if(empty($this->req['data']['key'])){
            ErrorModel::throwException(CodeConfigModel::illegalAccess);
        }
        session_id($this->req['data']['key']);
        $sess=\Yaf\Session::getInstance();
        $sess->start();
        $member_id=$sess->get('member_id');
        if(empty($member_id)){
            ErrorModel::throwException(CodeConfigModel::signWrong);
        }
        \Yaf\Dispatcher::getInstance()->disableView();
    }
    public function getAuthKey(){
        $this->key=Common::bulidToken();
        $this->redis->hset($this->key,NameConst::sessionKey,$this->key,ApiConst::tenMin);
    }



    public function loginCheck(){

    }

}
