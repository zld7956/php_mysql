<?php
/**
 * Created by PhpStorm.
 * User: zld
 * Date: 2017/4/20
 * Time: 10:51
 */
/**
 * Class db_master  数据库读写操作类
 */
class db_master extends db{

    private $table_name;
    private $table_info;

    /**
     * db_master constructor.
     * @param 规则 $config
     * @param $table_name 要操作的表名
     * @param int $quiet
     * @return 返回对象本身
     */
    function init($config, $table_name = '', $quiet = 0)
    {
        parent::init($config, $quiet, 'master');
        $this->set_table_name($table_name);
        return $this;
    }


    /**
     * 根据提交过来的数据自动组成插入语句
     * @param $table_name 要更新的表名，不会更改对象中设定的表名
     * @return 返回插入成功与否
     */
    function insert($table_name = ''){

        if(!$table_name){
            $table_name = $this->table_name;
            $table_info = $this->table_info;
        }else{
            $table_info = $this->tables_info[$table_name];
        }

        $cols = array();
        $vals = array();
        for($i = 1; $i < count($table_info); $i ++){
            foreach ($_REQUEST as $k => $v){
                if($k == $table_info[$i]){
                    $cols[] = $k;
                    $vals[] = $v;
                }
            }
        }

        $cols = "`" . implode("`,`",$cols) . "`";           //将列组合起来
        $vals = "'" . implode("','",$vals) . "'";           //将值组合起来

        $sql = "INSERT INTO `$table_name` ($cols) 
                VALUES ($vals)";
        echo $sql;
//        return parent::query($sql);
    }

    /**
     * 删除记录
     * @param string $whr 可选项，如果提交的信息含有主键id此参数可不填写，如有特殊删除条件则填写此参数
     * @param $table_name 要更新的表名，不会更改对象中设定的表名
     * @return bool 返回执行成功与否
     */
    function del($whr = '', $table_name = ''){

        if(!$table_name){
            $table_name = $this->table_name;
            $table_info = $this->table_info;
        }else{
            $table_info = $this->tables_info[$table_name];
        }

        if(!$whr){
            //循环提交过来的信息检查是否有与表中的第一列字段相吻合的
            foreach ($_REQUEST as $k => $v){
                if($k == $table_info[0]){
                    $whr = " `$k` = '$v' ";
                }
            }
        }
        if($whr){
            $sql = "DELETE 
                    FROM $table_name
                    WHERE $whr";
            echo $sql;
//            return parent::query($sql);
        }
        return false;
    }

    /**
     * 根据主键id自动更新记录
     * @param $whr 更新条件
     * @param $table_name 要更新的表名，不会更改对象中设定的表名
     * @return bool
     */
    function update($whr = '', $table_name = ''){

        if(!$table_name){
            $table_name = $this->table_name;
            $table_info = $this->table_info;
        }else{
            $table_info = $this->tables_info[$table_name];
        }
        $datas = array();
        for($i = 0; $i < count($table_info); $i ++){
            foreach ($_REQUEST as $k => $v){
                if($i == 0){
                    if($k == $table_info[$i] && !$whr){
                        $whr = " `$k` = '$v' ";
                    }
                }
                elseif($k == $table_info[$i]){
                    $datas[] = "`" . $k . "` = '$v'";
                }
            }
        }
        if($whr){
            $datas = implode(",",$datas);
            $sql = "UPDATE `$table_name` SET $datas WHERE $whr";
            echo $sql;
//            return parent::query($sql);
        }
        return false;
    }

    /**
     * 修改要操作的表名
     * @param $table_name
     */
    function set_table_name($table_name){
        if($table_name) {
            $this->table_name = $table_name;
            $this->table_info = $this->tables_info[$this->table_name];
        }
    }
}