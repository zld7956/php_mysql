<?php

/**
 * 自动初始化
 * Created by PhpStorm.
 * User: zld
 * Date: 2017/4/20
 * Time: 12:01
 */

/**
 * Class cls自动引用、初始化类
 */
class cls
{
    static $class = array();

    function __get($name)
    {
        if(!isset(self::$class[$name])){
            $file = ROOT_INCLUDES . $name . ".php";
            if(file_exists($file)){
                require $file;
                self::$class[$name] = new $name;
            }else{
                die($file .'不存在！');
            }
        }

        return self::$class[$name];
        // TODO: Implement __get() method.
    }
}