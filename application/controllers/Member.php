<?php
use Business\User\LoginV2Model;
class MemberController extends \Our\Controller_AbstractApi {
    private $memberService;
    private $memberData;
    public function init(){
        parent::init();
        $this->memberService=\Business\User\MemberServiceModel::getInstance();

    }
    public function indexAction() {
        $name=$this->req->getQuery('name');
        throw new Exception('hello ',404);
    }
    public function testAction(){
        $login=LoginV2Model::getInstance();
        echo $login->login();
    }
    public function saveMember(){
        $this->redis->tableHMSet($this->key,$this->memberData,\Our\ApiConst::tenDaySecond);
    }


    public function clearKey($key){
        $this->redis->tableDel($key);
    }
    public function loginAction(){
        if($this->isLogin()){
            Error\ErrorModel::throwException(\Error\CodeConfigModel::isLogin);
        }else{
            $data=$this->getRequest()->getPost(\Our\NameConst::data,'');
            $mobile=$data[\Our\NameConst::mobile];
            $password=$data[\Our\NameConst::password];
            if($this->memberService->checkUserNamePassWord($mobile,$password)){
                $user= $this->memberService->getOneByMobileAndPassword($mobile,$password);
                if($user){
                    $this->clearKey($this->key);
                    $this->key=\Our\Common::bulidToken($mobile,$password);
                    $user[\Our\NameConst::sessionKey]=$this->key;
                    foreach($user as $key=>$value){
                        if(empty($user[$key])){
                            $user[$key]=\Our\ApiConst::zero;
                        }
                    }
                    $this->memberData=$user;
                     register_shutdown_function(array($this,\Our\NameConst::saveMember));
                    $this->success($this->memberData);
                }else{
                    \Error\ErrorModel::throwException(\Error\CodeConfigModel::errorUsernameOrPassword);
                }
            }
        }

    }

}
