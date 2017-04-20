<?php
/**
 * Created by PhpStorm.
 * User: zld
 * Date: 2017/4/20
 * Time: 10:52
 */

    /* 取得当前程序所在根目录 */
    define('ROOT_PATH', str_replace('includes/init.php', '', str_replace('\\', '/', __FILE__)));
    /* 定义includes 文件夹位置 */
    define('ROOT_INCLUDES', ROOT_PATH . "includes/");

    require ROOT_INCLUDES. "cls.php";
    require ROOT_INCLUDES. "config.php";
    require ROOT_INCLUDES. "db.php";

    $cls = new cls();
    $db_cache = $cls->db_cache->init(CACHE_FILE, CACHE_DIR);
    $db_slv =  $cls->db_slave->init($_config);
    $db_mst = $cls->db_master->init($_config);