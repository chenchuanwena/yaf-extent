<?php
use Business\User\LoginV2Model;
class IndexController extends \Our\Controller_AbstractApi {

    public function indexAction() {

        echo \Our\RouteConst::userLogin;exit;
        throw new Exception('hello ',404);
    }
    public function testAction(){

        $login=LoginV2Model::getInstance();
        echo $login->login();

    }

}
