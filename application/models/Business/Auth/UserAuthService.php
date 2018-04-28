<?php

namespace Business\Auth;
use DAO\MemberModel;
use Error\CodeConfigModel;
use Error\ErrorModel;
use Our\ApiConst;
use Our\Common;
use Our\NameConst;

/**
 * 用户登录业务
 */
class UserAuthServiceModel extends \Business\AbstractModel {

    private $memberDao;
    private $redisDb1;
    private $phpRedisSession;
    public function init(){
        $this->redisDb1=\Redis\Db1\IpModel::getInstance();
        $this->phpRedisSession=\Redis\Db0\PhpRedisSessionModel::getInstance();
    }

    public function getAuthKey($nonce,$timestamp,$drivertype,$sign) {
        $ip=\Our\Common::getClientIp();
        $driverType=\Our\Common::getDriverType();
        $identify=$ip.'-'.$driverType;

        if($drivertype!=\Our\Common::getDriverType()){
            ErrorModel::throwException(\Error\CodeConfigModel::illegalAccess);
        }
        $gorwKey=md5(\Our\SecretKeys::authKey.$nonce.$timestamp.$drivertype);
        if($gorwKey!=$sign){
            ErrorModel::throwException(\Error\CodeConfigModel::signWrong);
        }
        if($identify){
            $res=$this->redisDb1->tableHMGet($identify,array(\Our\NameConst::maxAccessTime,\Our\NameConst::sessionKey));
            $returnKey=Common::bulidToken('','','',$driverType);
            $member['key']=$returnKey;
            session_id($returnKey);
            $sess=\Yaf\Session::getInstance();
            $sess->start();
            if($res){
                if($res[\Our\NameConst::maxAccessTime]>=\Our\ApiConst::maxAccess){
                    ErrorModel::throwException(\Error\CodeConfigModel::maxGetAccess);
                }else{
                    if($sess['member_name']){
                        ErrorModel::throwException(\Error\CodeConfigModel::isLogin);
                    }else{
                        $this->phpRedisSession->delSessionKey($res[NameConst::sessionKey]);
                    }
                    $sess['key']=$returnKey;
                    $msetArray=array(
                        NameConst::maxAccessTime=>$res[\Our\NameConst::maxAccessTime]+ApiConst::one,
                        NameConst::sessionKey=>$returnKey
                    );
                    $this->redisDb1->tableHMSet($identify,$msetArray,ApiConst::oneHour);

                }
            }else{
                $sess['key']=$returnKey;
                $msetArray=array(
                    NameConst::maxAccessTime=>ApiConst::one,
                    NameConst::sessionKey=>$returnKey
                );
                $this->redisDb1->tableHMSet($identify,$msetArray,ApiConst::oneHour);
            }
        }
        return $returnKey;

    }
    /**
     * 登录业务
     *
     * @param array $params
     * @return
     */
//    public function getAuthKey($nonce,$timestamp,$drivertype,$sign) {
//        $ip=\Our\Common::getClientIp();
//        $driverType=\Our\Common::getDriverType();
//        $identify=$ip.'-'.$driverType;
//
//        if($drivertype!=\Our\Common::getDriverType()){
//            ErrorModel::throwException(\Error\CodeConfigModel::illegalAccess);
//        }
//        $gorwKey=md5(\Our\SecretKeys::authKey.$nonce.$timestamp.$drivertype);
//        if($gorwKey!=$sign){
//            ErrorModel::throwException(\Error\CodeConfigModel::signWrong);
//        }
//        if($identify){
//            $res=$this->redisDb1->tableHMGet($identify,array(\Our\NameConst::maxAccessTime,\Our\NameConst::sessionKey));
//            $returnKey=Common::bulidToken('','','',$driverType);
//            if($res){
//                if($res[\Our\NameConst::maxAccessTime]>=\Our\ApiConst::maxAccess){
//                    ErrorModel::throwException(\Error\CodeConfigModel::maxGetAccess);
//                }else{
//                    if(!empty($this->redisDb0->tableHGet($res[NameConst::sessionKey],NameConst::memberName))){
//                        ErrorModel::throwException(\Error\CodeConfigModel::isLogin);
//                    }else{
//                        $this->redisDb0->tableDel($res[NameConst::sessionKey]);
//                    }
//                    $this->redisDb0->tableHSet($returnKey,NameConst::sessionKey,$returnKey,ApiConst::oneHour);
//                    $msetArray=array(
//                        NameConst::maxAccessTime=>$res[\Our\NameConst::maxAccessTime]+ApiConst::one,
//                        NameConst::sessionKey=>$returnKey
//                    );
//                    $this->redisDb1->tableHMSet($identify,$msetArray,ApiConst::oneHour);
//
//                }
//            }else{
//                $this->redisDb0->tableHSet($returnKey,NameConst::sessionKey,$returnKey,ApiConst::oneHour);
//                $msetArray=array(
//                    NameConst::maxAccessTime=>ApiConst::one,
//                    NameConst::sessionKey=>$returnKey
//                );
//                $this->redisDb1->tableHMSet($identify,$msetArray,ApiConst::oneHour);
//            }
//        }
//        return $returnKey;
//
//    }
    public function checkUserNamePassWord($mobile,$password){
        if(empty($mobile)||empty($password)){
            if(empty($mobile)){
                ErrorModel::throwException(CodeConfigModel::emptyUsername);
            }
            if(empty($password)){
                ErrorModel::throwException(CodeConfigModel::emptyPassword);
            }
        }
        if(!Common::checkMobilePhone($mobile)){
            ErrorModel::throwException(CodeConfigModel::wrongTelnumber);
        }
        return true;

    }
    public function getOneByMobileAndPassword($mobile,$password){
        $password=md5($password);
        $res=$this->memberDao->getOneByMobileAndPassword($mobile,$password);
        return $res?$res[0]:false;
    }
    /**
     * 登录业务
     *
     * @var \Business\User\LoginV2Model
     */
    private static $_instance = null;

    /**
     * 单例模式获取类实例
     *
     * @return \Business\User\LoginV2Model
     */
    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}
