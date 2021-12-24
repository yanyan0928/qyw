<?php

namespace CORP\contants;

/**
 * Class Common
 *
 * @author syy
 * @date   2021-12-24 下午5:10
 */
class Common{
    
    public static function writeLog($log, $file = 'out'){
        #生产环境写消息队列
        $dir = $file;
        self::CreateFolder($dir);
        $of = @fopen($dir . "/{$file}-" . date("Y-m-d-H") . ".txt", 'a+');
        @fwrite($of, $log . '-----------' . date("Y-m-d H:i:s", time()) . "\r\n");
        @fclose($of);
    }
    
    /**
     * 循环创建目录创建目录 递归创建多级目录
     * @param string $dir
     * @param string $mode
     */
    public static function CreateFolder($dir, $mode = 0777)
    {
        if (is_dir($dir) || @mkdir($dir, $mode))
            return true;
        if (!self::CreateFolder(dirname($dir), $mode))
            return false;
        return @mkdir($dir, $mode);
        
    }
}


