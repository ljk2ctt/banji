<?php

namespace Lib;

class Cache
{
    public static $config = array(
        'cache_path' => 'Runtime/Mycache',
        // Default expiration time in *minutes*
        'expires' => 3600,
    );
    public static function configure($key, $val = null)
    {
        if (is_array($key)) {
            foreach ($key as $config_name => $config_value) {
                self::$config[$config_name] = $config_value;
            }
        } else {
            self::$config[$key] = $val;
        }
    }
    private static function getRoute($key)
    {
        $path=DOC_ROOT.'/'.APP_PATH.static::$config['cache_path'] . '/';
        if(!is_dir($path))
        {
            mkdir($path,0755,true);
        }
        return $path . $key . '.php';
    }
    public static function get($key)
    {        
        $file = self::getRoute($key);
        $content = @file_get_contents($file);
        if($content)
        {
            $expire  =  (int)substr($content,8, 12);
            if($expire != 0 && time() > filemtime($file) + $expire) {
                //缓存过期删除缓存文件
                unlink($file);
                return false;
            }
            $content   =  unserialize(substr($content,20, -3));
            return $content;
        }
        return false;
    }
    public static function put($key, $content,$custom_time=null)
    {        
        if(is_null($custom_time))
        {
            $custom_time=  self::$config['expires'];
        }
        $dest_file_name = self::getRoute($key);
        if(is_null($content))
        {
            @unlink($dest_file_name);
            return true;
        }
        $temp_file_name = str_replace(".php", uniqid("-", true).".php", $dest_file_name);
        $data=serialize($content);
        $writhcontent="<?php\n//".sprintf('%012d',$custom_time).$data."\n?>";        
        $ret = @file_put_contents($temp_file_name, $writhcontent);
        if ($ret === false) {
            @unlink($temp_file_name);
            return false;
        }
        return @rename($temp_file_name, $dest_file_name);
    }
}