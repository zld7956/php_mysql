<?php
/**
 * Created by PhpStorm.
 * User: zld
 * Date: 2017/4/20
 * Time: 10:51
 */
    /**
     * Class db 数据库操作基础类
     */
    class db{

        private $config;
        protected $mysql;
        protected $tables_info = array();

        /**
         * db constructor.
         * @param $config 规则$_config['master'][] = array(
        'dbhost'=>'192.168.0.114:3306',
        'dbname'=>'jan',
        'dbuser'=>'root',
        'dbpw'=>'123456'
        );

        //数据库从服务器设置( slave, 只读 ), 支持多组服务器设置, 当设置多组服务器时, 系统每次随机使用
        $_config['slave'][] = array(
        'dbhost'=>'192.168.0.114:3306',
        'dbname'=>'jan',
        'dbuser'=>'root',
        'dbpw'=>'123456'
        );
         * @param $model slave只读，master读写
         * @param $quiet 是否将错误直接显示出来
         * @return 返回对象本身
         */
        protected function init($config, $quiet = 0, $model = 'slave')
        {
            $this->config = $config;
            $config = $config[$model];
            extract($config[rand(0,count($config)-1)]);
            $this->connect($dbhost, $dbuser, $dbpw, $dbname, $charset, $quiet);
            return $this;
        }


        /**
         * @param $dbhost
         * @param $dbuser
         * @param $dbpw
         * @param string $dbname
         * @param string $charset
         * @param int $quiet
         * @return bool
         */
        private function connect($dbhost, $dbuser, $dbpw, $dbname = '', $charset = 'utf8', $quiet = 0)
        {
            $this->mysql = @mysqli_connect($dbhost, $dbuser, $dbpw);
            if (!mysqli_connect_errno()) {
                $this->tables_info($dbname);
                mysqli_select_db($this->mysql, $dbname);
                mysqli_set_charset($this->mysql, $charset);
            } else {
                if ($quiet) {
                    return false;
                }
                $this->ErrorMsg(mysqli_connect_error());
            }
        }

        protected function tables_info($db){
            $sql = "SELECT TABLE_NAME,COLUMN_NAME 
                  FROM information_schema.columns
                  WHERE table_schema = '$db'";
            if($result = $this->select($sql,10)){
                foreach ($result as $row){
                    $this->tables_info[$row['TABLE_NAME']][] = $row['COLUMN_NAME'];
                }
            }
    //        print_r($this->table_info);
        }

        protected function select($sql,$cacheTM,$cacheTag = ''){
            if($cacheTM){
                $cacheKey = md5($sql . $cacheTM . $cacheTag);                                   //cache 的key值
                $cache = $GLOBALS['db_cache']->get($cacheKey);                                //cache 数据获取后存入$cache
                if($cache){
//                    var_dump('获取到缓存信息');
                    return json_decode($cache, true);
                }
            }

            if($result = $this->query($sql)){
//                var_dump('到数据库查询信息');
                $resultRow = array();
                while($row = mysqli_fetch_assoc($result)){
                    $resultRow[] = $row;
                }
                if($cacheTM){                                                                   //如果设置了缓存时间，就保存信息
                    $GLOBALS['db_cache']->set($cacheKey,json_encode($resultRow),$cacheTM);
                }
                return $resultRow;
            }
            return false;
        }

        /**
         * 所有的语句执行最终都走这里，这里可以将每一个sql缓存到一个list中
         * @param $sql
         * @return bool|mysqli_result
         */
        protected function query($sql){
            return mysqli_query($this->mysql,$sql);
        }

        function close(){
            mysqli_close($this->mysql);
        }

        /**
         * @param string $message
         * @param string $sql
         */
        private function ErrorMsg($message = '', $sql = '')
        {
            if ($message)
            {
                echo "<b>ECSHOP info</b>: $message\n\n<br /><br />";
                //print('<a href="http://faq.comsenz.com/?type=mysql&dberrno=2003&dberror=Can%27t%20connect%20to%20MySQL%20server%20on" target="_blank">http://faq.comsenz.com/</a>');
            }
            else
            {
                echo "<b>MySQL server error report:";
                print_r($this->error_message);
                //echo "<br /><br /><a href='http://faq.comsenz.com/?type=mysql&dberrno=" . $this->error_message[3]['errno'] . "&dberror=" . urlencode($this->error_message[2]['error']) . "' target='_blank'>http://faq.comsenz.com/</a>";
            }

            exit;
        }

    }