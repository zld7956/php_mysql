<?php
/**
 * Created by PhpStorm.
 * User: zld
 * Date: 2017/4/20
 * Time: 10:52
 */
/**
 * Class db_cache 将数据缓存到硬盘上
 */
class db_cache{
    private $files = "%s.cache";
    private $dir = "cache/cache/";

    /**
     * @param $files  文件名模板 如 %s.cache
     * @param $dir    缓存文件路径
     * @return $this    返回当前对象
     */
    function init($files,$dir)
    {
        $this->files = $files;
        $this->dir = $dir;
        return $this;
    }

    function get($key){
        if(file_exists($this->file_name($key))){
            if($text = file_get_contents($this->file_name($key))) {
                return $text;
            }
        }
        return false;
    }

    function set($key,$value,$cacheTM){
//        var_dump('保存缓存信息');
        if(!is_dir($this->dir)){
            self::dir_create($this->dir);
        }
        $myfile = fopen($this->file_name($key),'w');
        fwrite($myfile,$value);
        fclose($myfile);
    }

    function file_name($key){
        return $this->dir . sprintf($this->files,$key);
    }

    public static function dir_create($dir){

        if(!file_exists($dir)){
            mkdir($dir,0755,true);
        }
    }
}