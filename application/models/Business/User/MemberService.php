<?php

namespace Business\User;

use DAO\MbUserTokenModel;
use DAO\MemberModel;
use Error\CodeConfigModel;
use Error\ErrorModel;
use Our\Common;

/**
 * 用户登录业务
 */
class MemberServiceModel extends \Business\AbstractModel
{

    private $memberDao;

    public function init()
    {
        $this->memberDao = MemberModel::getInstance();
    }

    /**
     * 登录业务
     *
     * @param array $params
     * @return
     */
    public function login()
    {
        $userM = MemberModel::getInstance();
        //系统封装好的方法
        $one = $userM->find(1);
        //系统自带走从库方法
        return $one;
        $user = $userM->query();
        //系统原生走主库
        $user = $userM->update("UPDATE Member SET member_name='abc' WHERE member_id=1");
        return $user;
    }

    public function checkUserNamePassWord($mobile, $password)
    {
        if (empty($mobile) || empty($password)) {
            if (empty($mobile)) {
                ErrorModel::throwException(CodeConfigModel::emptyUsername);
            }
            if (empty($password)) {
                ErrorModel::throwException(CodeConfigModel::emptyPassword);
            }
        }
        if (!Common::checkMobilePhone($mobile)) {
            ErrorModel::throwException(CodeConfigModel::wrongTelnumber);
        }
        return true;

    }

    public function getOneByMobileAndPassword($mobile, $password)
    {
        $password = md5($password);
        $res = $this->memberDao->getOneByMobileAndPassword($mobile, $password);
        return $res ? $res[0] : false;
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
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function addOrUpdateMbUserToken($data)
    {
        $mbUserToken = MbUserTokenModel::getInstance();
        $inserData = [
            'member_id' => $data['member_id'],
            'member_name' => $data['member_name'],
            'token' => $data['key'],
            'login_time' => time(),
            'client_type' => Common::getDriverType(true),
        ];
        return $mbUserToken->insertOrUpdate($inserData);
    }

    public function findMbUserTokenByMemberId($memberId)
    {
        if ($memberId != (int)$memberId) {
            return false;
        }
        $mbUserTokenModel = MbUserTokenModel::getInstance();
        return $mbUserTokenModel->findByMemberId($memberId);
    }

    public function getMemberInfo($key)
    {
        $redis = \Redis\Db0\MemberModel::getInstance();
        $member = $redis->tableHGAll($key);
        if (!empty($member)) {
            return array(
                'memberId' => $member['member_id'],
                'memberName' => $member['member_name'],
                'memberTrueName' => $member['member_truename'],
                'memberAvatar' => $member['member_avatar'],
                'memberSex' => $member['member_sex'],
                'memberBirthday' => $member['member_birthday'],
                'memberEmail' => isset($member['member_email']) ? $member['member_email'] : '',
                'memberEmailBind' => isset($member['member_email_bind']) ? $member['member_email_bind'] : 0,
                'memberMobile' => $member['member_mobile'],
                'memberMobileBind' => $member['member_mobile_bind'],
                'memberWxinfo' => unserialize($member['member_wxinfo']),
                'memberWxopenid' => $member['member_wxopenid'],
                'sellerId' => $member['seller_id'],
                'diliverymanId' => $member['diliveryman_id'],
                'isTeacher' => $member['is_teacher'],
            );
        } else {
            return array();
        }
    }
}
