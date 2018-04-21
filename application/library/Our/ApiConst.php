<?php
namespace Our;
class ApiConst
{
    //传输加密方式
    const aesEncode = 1;//1:AES
    const md5Encode = 2;//2.MD5
    const plainEncode = 3;//3.明文

    //生成随机数的长度
    const randLengh=8;

    //10天数秒
    const tenDaySecond=864000;
    //一个小时
    const oneHour=3600;


    //成功状态码
    const returnSuccess=1;

    //设备类型
    const pcType=1;
    const iphoneType=2;
    const adroidType=3;
    const ipadType=4;
   //每天每个设备可获得的最多token次数
    const maxAccess=100;


    //数字
    const zero=0;
    const one=1;




}