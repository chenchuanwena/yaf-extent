<?php

namespace Our;
use Error\CodeConfigModel;
use Error\ErrorModel;
/**
 * 默认模块控制器抽象类
 *
 * @package Our
 * @author iceup <sjlinyu@qq.com>
 */
abstract class Controller_AbstractIndex extends \Our\Controller_Abstract {
    public $req;
    public $key;
    public $sess;
    public function init(){
        $this->req=$this->getRequest()->getPost();
        $postData=$this->req['data'];
        if(isset($postData[NameConst::sessionKey])&&!empty($postData[NameConst::sessionKey])){
            $this->key=$postData[NameConst::sessionKey];
            session_id($this->key);
            $this->sess=\Yaf\Session::getInstance();
            $this->sess->start();
            if($this->sess['key']!=$this->key){
                ErrorModel::throwException(CodeConfigModel::illegalAccess);
            }
        }else{
            ErrorModel::throwException(CodeConfigModel::illegalAccess);
        }
        \Our\Common::$requestTime=time();
        \Yaf\Dispatcher::getInstance()->disableView();
    }
//      public function init(){
//          $this->req=$this->getRequest()->getPost();
//          $postData=$this->req['data'];
//          if(isset($postData[NameConst::sessionKey])&&!empty($postData[NameConst::sessionKey])){
//              $this->key=$postData[NameConst::sessionKey];
//              $this->redis=\Redis\Db0\MemberModel::getInstance();
//              $redisKeyValue=$this->redis->tableHGet($this->key,NameConst::sessionKey);
//              if($redisKeyValue!=$this->key){
//                  ErrorModel::throwException(CodeConfigModel::illegalAccess);
//              }
//          }else{
//              ErrorModel::throwException(CodeConfigModel::illegalAccess);
//          }
//          \Our\Common::$requestTime=time();
//
//          \Yaf\Dispatcher::getInstance()->disableView();
//      }
}
