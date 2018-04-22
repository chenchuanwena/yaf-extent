<?php
use Business\User\LoginV2Model;
class IndexController extends \Our\Controller_AbstractApi {

    public function indexAction() {
        //异常使用
        throw new Exception('hello ',404);

    }
    public function testAction(){
        //业务逻辑类的使用
        $login=LoginV2Model::getInstance();
       // echo $login->login();
        $selo=new \Zend\Authentication\AuthenticationService();
        $selo->setStorage('abc');
        echo $selo->getStorage();exit;
    }

}
