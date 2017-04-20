<?php
/**
 * Created by PhpStorm.
 * User: zld
 * Date: 2017/4/18
 * Time: 18:56
 */

require "includes/init.php";


var_dump($db_slv->getCol('select goods_id,goods_name from jan_goods limit 10',5));

/*执行 增、删、改 之前先设定要操作的表（切换表之前只需要设定一次）*/
$db_mst->set_table_name('jan_goods');

/*
 * 以GET、POST 形式提交数据到当前页面
 * 如?goods_name=手机&goods_id=1
 * 即可获得sql语句：UPDATE `jan_goods` SET `goods_name` = '草莓' WHERE `goods_id` = '1'
 * */
$_REQUEST['goods_name'] = '草莓';
$_REQUEST['goods_id'] = 1;

$db_mst->update();


$db_slv->close();
$db_mst->close();
//

