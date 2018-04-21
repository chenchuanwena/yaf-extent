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
}
