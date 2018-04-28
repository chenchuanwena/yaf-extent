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
        $this->memberService->addOrUpdateMbUserToken($this->memberData);
        $this->redis->tableHMSet($this->key,$this->memberData,\Our\ApiConst::tenDaySecond);
    }


    public function clearKey($key){
        $this->redis->tableDel($key);
    }
    /**
     * 获取会员基本信息
     *
     * @var member/getMemberInfo
     */
    public function getMemberInfoAction(){
        $key=$this->req['data']['key'];
        $result=$this->memberService->getMemberInfo($key);
        $this->success($result);
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
                    $member=$this->memberService->findMbUserTokenByMemberId($user['member_id']);
                    if($member){
                        $this->clearKey($member['token']);
                    }
                    $this->clearKey($this->key);
                    $this->key=\Our\Common::bulidToken($mobile,$password);
                    $user[\Our\NameConst::sessionKey]=$this->key;
                    foreach($user as $key=>$value){
                        if(empty($user[$key])){
                            $user[$key]=\Our\ApiConst::zero;
                        }
                    }
                    $this->memberData=$user;
                    $this->saveMember();
                    $this->success(array(),\Our\DescribeConst::loginSuccess);
                }else{
                    \Error\ErrorModel::throwException(\Error\CodeConfigModel::errorUsernameOrPassword);
                }
            }
        }

    }

}
