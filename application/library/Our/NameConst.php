<?php
namespace Our;
/**
 * 这个是路由定义  。
 *
 * @author Administrator
 *
 */
class NameConst {

    /**
     * 登录session_key
     * @var string
     */
    const sessionKey = 'key';
    const data='data';
    const mobile='mobile';
    const password='password';

    //member表字段名
    const memberMobile='member_mobile';
    const memberPasswd='member_passwd';
    const memberName='member_name';
    //member表方法
    const saveMember='saveMember';

    //返回字段
    const shortMessage='shortMessage';
    const longMessage='longMessage';
    const responseContent='responseContent';
    const resultCode='resultCode';

    //配置名字
    const configName='config';
    const redisPre='qm_-';

    //授权参数名称
    const nonce='nonce';
    const timestamp='timestamp';
    const deviceType='deviceType';
    const sign='sign';
    const maxAccessTime='maxAccessTime';


}

?>