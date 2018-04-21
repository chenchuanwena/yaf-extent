<?php
use Business\User\LoginV2Model;
class IndexController extends \Our\Controller_AbstractApi {

    public function indexAction() {
        throw new Exception('hello ',404);
    }
    public function testAction(){
       // \Error\ErrorModel::throwException(100110);(主动抛出异常)
        $login=LoginV2Model::getInstance();
        $res= $login->login();
        echo json_encode($res);exit;

    }

}
