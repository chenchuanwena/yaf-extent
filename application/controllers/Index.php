<?php
use Business\User\LoginV2Model;
class IndexController extends \Our\Controller_AbstractApi {

    public function indexAction() {
        //�쳣ʹ��
        throw new Exception('hello ',404);

    }
    public function testAction(){
        //ҵ���߼����ʹ��
        $login=LoginV2Model::getInstance();
       // echo $login->login();
        $selo=new \Zend\Authentication\AuthenticationService();
        $selo->setStorage('abc');
        echo $selo->getStorage();exit;
    }

}
