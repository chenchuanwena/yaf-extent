<?php
use Business\User\LoginV2Model;
class IndexController extends \Our\Controller_AbstractApi {

    public function indexAction() {

        $sess=\Yaf\Session::getInstance();
        $sess->start();

        session_id(123213);
        $sess->start();
        //ini_set('session.gc_maxlifetime', "3600");
       // echo $sess->get('member_name');
        $sess->set('member_name1',123);
        $sess->set('member_name',123);
        echo 'success';
        exit;
        $redis=\Redis\Db0\PhpRedisSessionModel::getInstance();
        $redis->delSessionKey('bigj78hnethnvankkc274cq2k0');
       // $sess->del('member_name');
      //  $sess->set('member_name',123);
        echo 'success';
        exit;
        throw new Exception('hello ',404);
    }
    public function testAction(){

        $login=LoginV2Model::getInstance();
        echo $login->login();

    }

}
