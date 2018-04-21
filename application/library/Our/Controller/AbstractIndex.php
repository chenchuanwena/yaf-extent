<?php

namespace Our;
use Error\CodeConfigModel;
use Error\ErrorModel;
/**
 * 默认模块控制器抽象类
 *
 * @package Our
 * @author iceup <sjlinyu@qq.com>
 */
abstract class Controller_AbstractIndex extends \Our\Controller_Abstract {
      public function init(){
          \Yaf\Dispatcher::getInstance()->disableView();
      }
}
