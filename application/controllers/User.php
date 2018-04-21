<?php
use Business\User\LoginV2Model;
class UserController extends \Our\Controller_Abstract {

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
    public function memberAction(){

    }

}
