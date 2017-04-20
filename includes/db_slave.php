<?php
/**
 * Created by PhpStorm.
 * User: zld
 * Date: 2017/4/20
 * Time: 10:51
 */
    /**
     * Class db_slave 数据库只读操作类
     */
    class db_slave extends db{

        /**
         * 自动选择为slave模式
         * db_slave constructor.
         * @param $config
         * @param int|是否将错误直接显示出来 $quiet
         * @return 返回对象本身
         */
        function init($config, $quiet = 0, $model = 'slave')
        {
            parent::init($config, $quiet, 'slave');
            return $this;
        }

        /**
         * 获取某个字段的值
         * @param $sql
         * @param $cacheTM
         * @return array|bool
         */
        function getOne($sql,$cacheTM){
            if($result = parent::select($sql,$cacheTM)){
                $result = $result[0];
                return $result[array_keys($result)[0]];
            }
            return false;
        }

        /**
         * 获取一行数据
         * @param $sql
         * @param $cacheTM
         * @return array|bool
         */
        function getRow($sql,$cacheTM){
            if($result = parent::select($sql,$cacheTM)){
                return $result[0];
            }

            return false;
        }


        /**
         * 获取一列数据，查询的列必须为一列
         * @param $sql
         * @param $cacheTM
         * @return array|bool
         */
        function getCol($sql,$cacheTM){
            if($result = parent::select($sql,$cacheTM)){
                $reArr = array();
                foreach ($result as $value){
                    $reArr[] = $value[array_keys($value)[0]];
                }
                return $reArr;
            }
            return false;
        }

        /**
         * 查询所有数据
         * @param $sql
         * @param $cacheTM
         * @return array|bool|mixed
         */
        function getAll($sql,$cacheTM){
            return parent::select($sql,$cacheTM);
        }

    }