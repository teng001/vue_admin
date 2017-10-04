<?php
namespace App\Services\Common;

class ComLogService
{
    public static function write($key, $params, $fileName = NULL, $splitChar = "\t")
    {
        if (is_array($params)) {
            $params = json_encode($params,JSON_UNESCAPED_UNICODE);
        }
        $line = array(date('Y-m-d H:i:s'), $key, $params);
        $line = join($splitChar, $line);
        if ($fileName == NULL) {
            $fileName = '/webser/comlog/comlog' . date('Ymd');
        }

        $fp = self::_openFile($fileName);
        if ($fp) {
            self::_writeFile($fp, "$line\n");
        }
    }

    protected static function _openFile($strFile) {
        if ($strFile[0] == '/') {
            $fp = fopen($strFile, 'a');
        }
        return $fp;     
    }

    protected static function _writeFile($resFile, $strContent, $intCount = 1) {
        if (flock($resFile, LOCK_EX)) {
            fwrite($resFile, $strContent);
            flock($resFile, LOCK_UN);
            fclose($resFile);
            return true;
        }
        
        fclose($resFile);
        if ($intCount > 3) {
            return false;
        }
        $intCount++;
        return self::_writeFile($resFile, $strContent, $intCount);
    }
}
