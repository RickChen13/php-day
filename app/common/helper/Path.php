<?php

declare(strict_types=1);

namespace app\common\helper;

class Path
{
    /**
     * 格式化路径
     *
     * @param string $path
     * @return string
     */
    public static function formatPath(string $path): string
    {
        if (PHP_OS == "WINNT") {
            $path = strtr($path, "/", "\\");
        } else {
            $path = strtr($path, "\\", "/");
        }
        return $path;
    }

    /**
     * 获取分隔符
     *
     * @return string
     */
    public static function getDelimiter(): string
    {
        if (PHP_OS == "WINNT") {
            $Delimiter =  "\\";
        } else {
            $Delimiter =  "/";
        }
        return $Delimiter;
    }

    /**
     * 格式化路径
     *
     * @param string $str
     * @param boolean $append true:在str最前面添加分隔符 false:去除str最前面的分隔符
     * @return string
     */
    public static function formatFrist(string $str, bool $append = true): string
    {
        $frist = substr($str, 0, 1);
        $Delimiter = self::getDelimiter();
        if ($append) {
            if ($frist != $Delimiter) {
                $str = $Delimiter . $str;
            }
        } else {
            if ($frist == $Delimiter) {
                $str =  substr($str, 1, -1);
            }
        }
        return self::formatPath($str);
    }

    /**
     * 格式化路径
     *
     * @param string $str
     * @param boolean $append true:在str最后面添加分隔符 false:去除str最后面前面的分隔符
     * @return string
     */
    public static function formatLast(string $str, bool $append = true): string
    {
        $last = substr($str, -1, 1);
        $Delimiter = self::getDelimiter();
        if ($append) {
            if ($last != $Delimiter) {
                $str .= $Delimiter;
            }
        } else {
            if ($last == $Delimiter) {
                $str =  substr($str, 0, strlen($str) - 1);
            }
        }
        return self::formatPath($str);
    }

    /**
     * 获取文件目录列表,该方法返回数组
     *
     * @param string $dir
     * @return array
     */
    public static function getDir(string $dir): array
    {
        $dirArray = [];
        if (false != ($handle = opendir($dir))) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    if (is_dir(Path::formatPath($dir . '/' . $file))) {
                        $dirArray[] =  $file;
                    }
                }
            }
            //关闭句柄
            closedir($handle);
        }
        return $dirArray;
    }

    /**
     * 获取文件列表
     *
     * @param string $dir
     * @return array
     */
    public static function getFile(string $dir): array
    {
        $fileArray = [];
        if (false != ($handle = opendir($dir))) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    if (is_file(Path::formatPath($dir . '/' . $file))) {
                        $fileArray[] =  $file;
                    }
                }
            }

            closedir($handle);
        }
        return $fileArray;
    }

    /**
     * 获取目录下全部的文件夹和文件，0文件夹，1文件
     *
     * @param string $dir
     * @return array
     */
    public static function get_dir(string $dir): array
    {
        $dirArray = [];
        $fileArray = [];
        if (false != ($handle = opendir($dir))) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    if (is_dir(self::formatPath($dir . '/' . $file))) {
                        $dirArray[] =  $file;
                    } else {
                        $fileArray[] =  $file;
                    }
                }
            }
            //关闭句柄
            closedir($handle);
        }
        return [$dirArray, $fileArray];
    }

    /**
     * 获取文件后缀
     *
     * @param string $dir
     * @return string
     */
    public static function get_extension(string $dir): string
    {
        return pathinfo($dir, PATHINFO_EXTENSION);
    }

    /**
     * 获取文件名
     *
     * @param string $dir
     * @return string
     */
    public static function getFileName(string $dir): string
    {
        return pathinfo($dir, PATHINFO_FILENAME);
    }
}
