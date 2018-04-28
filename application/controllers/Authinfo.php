<?php

use Business\User\LoginV2Model;

class AuthinfoController extends \Our\Controller_Abstract
{
    public $req;
    private $userAuth;

    public function init()
    {
        $this->req = $this->getRequest()->getPost();
        $this->userAuth = \Business\Auth\UserAuthServiceModel::getInstance();

    }

    public function indexAction()
    {
        session_id('b63spmehh43ao0d6kot5ulj7n7');
        // ini_set('session.gc_maxlifetime', 5000);
        $sesObject=\Yaf\Session::getInstance();
        $sesObject->start();
        exit;
//        echo $sesObject->get('test');
//       exit;
        $name = $this->req->getQuery('name');
        throw new Exception('hello ', 404);
    }

    public function testAction()
    {
        $login = LoginV2Model::getInstance();
        echo $login->login();
    }

    public function saveMember()
    {
        if ($this->memberData && $this->key) {
            foreach ($this->memberData as $key => $value) {
                if (empty($this->memberData[$key])) {
                    $this->memberData[$key] = 0;
                }
            }
            $this->redis->tableHMSet($this->key, $this->memberData, \Our\ApiConst::tenDaySecond);
        }

    }

    public function takeAccessAction()
    {
        $data=$this->req[\Our\NameConst::data];
        if (!$data[\Our\NameConst::nonce] || !$data[\Our\NameConst::timestamp] || !$data[\Our\NameConst::deviceType] || !$this->req[\Our\NameConst::sign]) {
            Error\ErrorModel::throwException(\Error\CodeConfigModel::illegalAccess);
        }
        $authKey = $this->userAuth->getAuthKey($data[\Our\NameConst::nonce], $data[\Our\NameConst::timestamp], $data[\Our\NameConst::deviceType], $this->req[\Our\NameConst::sign]);
        $this->success(array(\Our\NameConst::sessionKey => $authKey));
    }


}
