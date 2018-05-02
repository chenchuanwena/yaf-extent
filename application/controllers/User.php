<?php
use Business\User\LoginV2Model;
class UserController extends \Our\Controller_AbstractIndex {
    public $phpRedisSession;
    public $memberRedis;
    public $memberService;
    private $memberData;
    public function init(){
        parent::init();
        $this->phpRedisSession=\Redis\Db0\PhpRedisSessionModel::getInstance();
        $this->memberRedis=\Redis\Db0\MemberModel::getInstance();
        $this->memberService=\Business\User\MemberServiceModel::getInstance();

    }
    public function indexAction() {
        echo 234;exit;

        $name=$this->req->getQuery('name');
        echo $name;exit;
        throw new Exception('hello ',404);
    }
    public function testAction(){
        var_dump($this->config);exit;
        $login=LoginV2Model::getInstance();
        echo $login->login();

    }

    public function isLogin(){
       $member_id =$this->sess->get('member_id');
        if(!empty($member_id )){
            return true;
        }else{
            return false;
        }
    }
    public function saveMember(){
        $this->memberRedis->tableHMSet($this->key,$this->memberData,\Our\ApiConst::tenDaySecond);
       // $this->memberService->addOrUpdateMbUserToken($this->memberData);
    }


    public function clearKey($key){
        $this->phpRedisSession->delSessionKey($key);
        $this->memberRedis->tableDel($key);
    }
    public function loginAction(){

        if($this->isLogin()){
            Error\ErrorModel::throwException(\Error\CodeConfigModel::isLogin);
        }else{
            $data=$this->req['data'];
            $mobile=$data[\Our\NameConst::mobile];
            $password=$data[\Our\NameConst::password];
            if($this->memberService->checkUserNamePassWord($mobile,$password)){
                $user= $this->memberService->getOneByMobileAndPassword($mobile,$password);
                if($user){
                    $this->clearKey($this->key);
                    $this->key=\Our\Common::bulidToken($mobile,$password);
                    session_id($this->key);
                    $this->sess->start();
                    $this->sess['member_id']=$user['member_id'];
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
