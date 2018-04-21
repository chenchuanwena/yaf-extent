<?php

/**
 * 当有未捕获的异常, 则控制流会流到这里
 */
class ErrorController extends \Our\Controller_Abstract {
    const notFound=404;
    const numberLimit=100000;
    public function init() {
        \Yaf\Dispatcher::getInstance()->disableView();
    }
    private static function createRequsetId()
    {
        $arr = array('2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'X', 'Y', 'Z');
        $arrString = Array($arr[rand(0, 27)], $arr[rand(0, 27)], $arr[rand(0, 27)], $arr[rand(0, 27)], $arr[rand(0, 27)], $arr[rand(0, 27)], $arr[rand(0, 27)], $arr[rand(0, 27)], $arr[rand(0, 27)], $arr[rand(0, 27)], $arr[rand(0, 27)], $arr[rand(0, 27)], $arr[rand(0, 27)]);
        $time = date('ymd', time());
        //查看结果
        $requestId = $time . implode('', $arrString);
        return $requestId;
    }
    public static function returnMessage($returnMessage)
    {
        $data['status']='fail';
        $data['resultCode']=$returnMessage['resultCode'];
        $data['longMessage']=$returnMessage['longMessage'];
        $data['shortMessage']=$returnMessage['shortMessage'];
        $data['encryptType'] = \Our\ApiConst::plainEncode;
        $data['requestId'] = self::createRequsetId();
        $data['requestTime']=\Our\Common::$requestTime;
        $data['responseTime'] = time();
        $data['responseContent']=array();
        $data['Data'] = $_POST;
        $log = \Our\Log::getInstance();
        $log->write(print_r($data, true));
        // unset($data['requestData']);
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Method: *');
        header('Access-Control-Allow-Headers: x-requested-with,content-type');
        header('Content-type: application/json');
        echo json_encode($data);
        exit;
    }
    public function errorAction($exception) {
        if ($exception->getCode() > self::numberLimit) {
            //这里可以捕获到应用内抛出的异常
            $res['resultCode']= $exception->getCode();
            $res['shortMessage']= $exception->getMessage();
            $res['longMessage']= $exception->getMessage();
            self::returnMessage($res);
        }
        switch ($exception->getCode()) {

            case 404://404
            case 515:
            case 516:
            case 517:
                //输出404
                header(\Our\Common::getHttpStatusCode(404));
                echo self::notFound;
                exit();
                break;
            default :
                break;
        }
        throw $exception;
    }

}
