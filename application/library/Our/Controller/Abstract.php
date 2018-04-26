<?php

namespace Our;

/**
 * 控制器抽象类
 */
abstract class Controller_Abstract extends \Yaf\Controller_Abstract {
    public function success($data=array(),$shortMessage = DescribeConst::successMessage,$longMessage=DescribeConst::successMessage,$resultCode=ApiConst::returnSuccess)
    {
        $returnMessage[NameConst::shortMessage] = $shortMessage;
        $returnMessage[NameConst::longMessage] = $longMessage;
        $returnMessage[NameConst::responseContent]=$data;
        $returnMessage[NameConst::resultCode]=$resultCode;
        Common::returnMessage($returnMessage);

    }
    public function getModuleName(){
        return \Yaf\Request_Abstract::getModuleName();
    }
    public function getControllerName(){
        return \Yaf\Request_Abstract::getControllerName();
    }
    public  function getActionName(){
        return \Yaf\Request_Abstract::getActionName();
    }
    public function getRoute(){
        $moduleName=$this->getModuleName();
        $actionName=$this->getControllerName();
        
    }
}
