<?php

namespace Our;

class Common
{
   public static $requestTime;
    /**
     * 获取http状态码
     *
     * @param int $num
     * @return string
     */
    public static function getHttpStatusCode($num)
    {
        $httpStatusCodes = array(
            100 => "HTTP/1.1 100 Continue",
            101 => "HTTP/1.1 101 Switching Protocols",
            200 => "HTTP/1.1 200 OK",
            201 => "HTTP/1.1 201 Created",
            202 => "HTTP/1.1 202 Accepted",
            203 => "HTTP/1.1 203 Non-Authoritative Information",
            204 => "HTTP/1.1 204 No Content",
            205 => "HTTP/1.1 205 Reset Content",
            206 => "HTTP/1.1 206 Partial Content",
            300 => "HTTP/1.1 300 Multiple Choices",
            301 => "HTTP/1.1 301 Moved Permanently",
            302 => "HTTP/1.1 302 Found",
            303 => "HTTP/1.1 303 See Other",
            304 => "HTTP/1.1 304 Not Modified",
            305 => "HTTP/1.1 305 Use Proxy",
            307 => "HTTP/1.1 307 Temporary Redirect",
            400 => "HTTP/1.1 400 Bad Request",
            401 => "HTTP/1.1 401 Unauthorized",
            402 => "HTTP/1.1 402 Payment Required",
            403 => "HTTP/1.1 403 Forbidden",
            404 => "HTTP/1.1 404 Not Found",
            405 => "HTTP/1.1 405 Method Not Allowed",
            406 => "HTTP/1.1 406 Not Acceptable",
            407 => "HTTP/1.1 407 Proxy Authentication Required",
            408 => "HTTP/1.1 408 Request Time-out",
            409 => "HTTP/1.1 409 Conflict",
            410 => "HTTP/1.1 410 Gone",
            411 => "HTTP/1.1 411 Length Required",
            412 => "HTTP/1.1 412 Precondition Failed",
            413 => "HTTP/1.1 413 Request Entity Too Large",
            414 => "HTTP/1.1 414 Request-URI Too Large",
            415 => "HTTP/1.1 415 Unsupported Media Type",
            416 => "HTTP/1.1 416 Requested range not satisfiable",
            417 => "HTTP/1.1 417 Expectation Failed",
            500 => "HTTP/1.1 500 Internal Server Error",
            501 => "HTTP/1.1 501 Not Implemented",
            502 => "HTTP/1.1 502 Bad Gateway",
            503 => "HTTP/1.1 503 Service Unavailable",
            504 => "HTTP/1.1 504 Gateway Time-out"
        );

        return isset($httpStatusCodes[$num]) ? $httpStatusCodes[$num] : '';
    }

    /**
     * 获取客户端IP
     *
     * @param  boolean $checkProxy
     * @return string
     */
    public static function getClientIp($checkProxy = true)
    {
        if ($checkProxy && isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] != null) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if ($checkProxy && isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != null) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    /**
     * 获取当前访问的url地址
     *
     * @return string
     */
    public static function getRequestUrl()
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    public static function getConfig($key){
        $config=\Yaf\Registry::get('config');
        $configValue=$config->get($key);
        return $configValue;
    }
    /**
     * 获取静态资源文件
     *
     * @param unknown_type $filename
     */
    public static function getStaticFile($filename)
    {
        $files = array();
        $static = array();
        if (is_array($filename)) {
            $files = $filename;
        } elseif (is_string($filename)) {
            $files [] = $filename;
        }
        if (!empty ($files)) {
            foreach ($files as $file) {
                $timemap = '';
                if (strpos($file, '?') !== false) {
                    list ($file, $timemap) = explode('?', $file);
                    $timemap = empty($timemap) ? '' : '?' . $timemap;
                }
                $ext = strrchr($file, '.');
                $base = substr($file, 0, strlen($ext));
                $static [$ext] [] = $file . $timemap;
            }
        }

        //静态支援url
        $staticUrl = \Bootstrap::getUrlIniConfig('resourcesHost');///($request_type == 'SSL') ? HTTPS_SERVER : ( G_IS_CN_IP ? G_HTTP_HOST_TMART : G_STATIC_IMAGE_TMART_COM);
        if (!empty ($static)) {
            $output = '';
            foreach ($static as $ext => $files) {
                switch (strtolower($ext)) {
                    case '.css' :
                        foreach ($files as $f) {
                            $output .= $staticUrl . '/' . 'css/' . $f;
                        }
                        break;
                    case '.js' :
                        foreach ($files as $f) {
                            $output .= $staticUrl . '/' . 'jscript/' . $f;
                        }
                        break;
                    case '.jpg' :
                    case '.gif' :
                    case '.png' :
                        foreach ($files as $f) {
                            $output = $staticUrl . '/' . 'image/' . $f;
                        }
                        break;
                }
            }
        }
        return $output;
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
        $data['status']='success';
        $data['resultCode']=ApiConst::returnSuccess;
        $data['longMessage']=$returnMessage['longMessage'];
        $data['shortMessage']=$returnMessage['shortMessage'];
        $data['encryptType'] = \Our\ApiConst::plainEncode;
        $data['requestId'] = self::createRequsetId();
        $data['requestTime']=\Our\Common::$requestTime;
        $data['responseTime'] = time();
        $data['responseContent']=$returnMessage['responseContent'];
        $data['Data']=array();
        $data['Data'] =$_POST;
//        $log = \Our\Log::getInstance();
//        $log->write(print_r($data, true));
        // unset($data['requestData']);
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Method: *');
        header('Access-Control-Allow-Headers: x-requested-with,content-type');
        header('Content-type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function generate_password($length = 8)
    {
        // 密码字符集，可任意添加你需要的字符
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            // 这里提供两种字符获取方式
            // 第一种是使用 substr 截取$chars中的任意一位字符；
            // 第二种是取字符数组 $chars 的任意元素
            // $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
            $password .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $password;
    }

    /**
     * bulid AppToken
     */
    public static function bulidToken($mobilePhone = null, $password = null, $zenid = null, $iso = null)
    {
        $bassStr=self::getClientIp();
        if($zenid){
            $bassStr.=$zenid;
        }
        if($iso){
            $bassStr.=$zenid;
        }
        if (empty($mobilePhone) || empty($password)) {
            $md5Key=md5($bassStr.time());
        }else{
            $md5Key=md5($bassStr.self::generate_password(ApiConst::randLengh).time());
        }
        return $md5Key;
    }

    /**
     * 手机号码验证
     * @param unknown $phone
     * @return boolean
     */
    public static function checkMobilePhone($phone){
        if( empty($phone) ){
            return false;
        }

        if( !preg_match('/^1[34578]\d{9}$/', $phone) ){
            return false;
        }

        return true;
    }

    /**
     * sql字符串格式化
     * @param unknown $phone
     * @return boolean
     */
    public static function format() {
        $args = func_get_args();
        if (count($args) == 0) {
            return;
        }
        if (count($args) == 1) {
            return $args[0];
        }
        $str = array_shift($args);
        $str = preg_replace_callback('/\\{(0|[1-9]\\d*)\\}/', create_function('$match', '$args = ' . var_export($args, true) . '; return isset($args[$match[1]]) ? $args[$match[1]] : $match[0];'), $str);
        return $str;
    }
//
    public static function getDriverType($isstring=false){
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
//分析数据
        $is_pc = (strpos($agent, 'windows nt')) ? true : false;
        $is_iphone = (strpos($agent, 'iphone')) ? true : false;
        $is_ipad = (strpos($agent, 'ipad')) ? true : false;
        //$is_android = (strpos($agent, 'android')) ? true : false;
//输出数据
        $driverType=ApiConst::adroidType;
        if($is_pc){
           $driverType=ApiConst::pcType;
        }
        if($is_iphone){
            $driverType=ApiConst::iphoneType;
        }
        if($is_ipad){
             $driverType=ApiConst::ipadType;
        }
        if($isstring){
            switch($driverType){
                case ApiConst::pcType:$driverType=NameConst::pc;break;
                case ApiConst::iphoneType:$driverType=NameConst::iphone;break;
                case ApiConst::adroidType:$driverType=NameConst::android;break;
                case ApiConst::ipadType:$driverType=NameConst::ipad;break;
                default:ApiConst::zero;break;
            }
        }
        return $driverType;
    }


    public static function getIdentify(){
        return self::getClientIp().'-'.self::getDriverType();
    }



}
