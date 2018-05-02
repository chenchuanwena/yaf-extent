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
        return $this->getRequest()->getModuleName();
    }
    public function getControllerName(){
        return $this->getRequest()->getControllerName();
    }
    public  function getActionName(){
        return $this->getRequest()->getActionName();
    }
    public function getRoute(){
        $moduleName=$this->getModuleName();
        $cName=$this->getControllerName();
        $aName=$this->getActionName();
        if($moduleName=='Index'){
            return $cName.'/'.$aName;
        }else{
            return $moduleName.'/'.$cName.'/'.$aName;
        }
        
    }
}
