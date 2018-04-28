<?php

namespace Error;

/**
 * 错误码设置类
 */
class CodeConfigModel {
    //用户登录错误
    const emptyUsername=100110;
    const emptyPassword=100111;
    const errorUsernameOrPassword=100112;
    const wrongTelnumber=100201;
    //访问错误
    const illegalAccess=200001;
    const maxGetAccess=200002;
    const isLogin=200003;
    const signWrong=200004;


    /**
     * 获取错误码配置
     */
    public static function getCodeConfig() {
        return array(
            self::emptyUsername => "用户名不能为空",
            self::emptyPassword=>"密码不能为空",
            self::errorUsernameOrPassword=>'用户名或密码错误',
            self::illegalAccess=>"非法访问",
            self::wrongTelnumber=>"请输入正确的手机号码",
            self::maxGetAccess=>'今天授权次数已经用完',
            self::isLogin=>'你已经登录',
            self::signWrong=>'签名有误',
            self::signWrong=>'您还没登录'
        );
    }

}
