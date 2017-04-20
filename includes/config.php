<?php
/**
 * Created by PhpStorm.
 * User: zld
 * Date: 2017/4/20
 * Time: 10:50
 */

    define('CACHE_DIR', "cache/");
    define('CACHE_FILE',"%s.cache");

    //数据库主服务器设置( master, 读写 ), 支持多组服务器设置, 当设置多组服务器时, 系统每次随机使用
    $_config['master'][] = array(
        'dbhost'=>'192.168.0.114:3306',
        'dbname'=>'test',
        'dbuser'=>'root',
        'dbpw'=>'123456',
        'charset'=>'utf8'
    );

    //数据库从服务器设置( slave, 只读 ), 支持多组服务器设置, 当设置多组服务器时, 系统每次随机使用
    $_config['slave'][] = array(
        'dbhost'=>'192.168.0.114:3306',
        'dbname'=>'test',
        'dbuser'=>'root',
        'dbpw'=>'123456',
        'charset'=>'utf8'
    );