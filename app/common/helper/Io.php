<?php

declare(strict_types=1);

namespace app\common\helper;

use app\common\helper\Path;

class Io
{
    /**
     * 文件写入本地
     *
     * @param string $dir 目录
     * @param string $Fullmc 文件名称
     * @param string $content 内容
     * @return void
     */
    public static function put(string $dir, string $Fullmc, string $content): void
    {
        $dir = Path::formatLast($dir, false);
        if (!is_dir($dir)) {
            mkdir($dir, 755, true);
        }
        $filename = Path::formatPath($dir . "/" . $Fullmc);
        if (!file_exists($filename)) {
            touch($filename, 755);
        }
        file_put_contents($filename, $content);
    }

    /**
     * 传输文件
     *
     * @param string $file_dir
     * @param string $file_name
     * @return void
     */
    public static function download(string $file_dir, string $file_name): void
    {
        $file_dir = Path::formatLast($file_dir);
        // 创建文件下载路径
        $file = "$file_dir$file_name";
        // 判断文件是否存在
        if (!file_exists($file)) {
            die("抱歉，文件不存在！");
        } else {
            // 发送文件头部
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            // header("Content-type: $type");
            header('Content-Disposition: attachment; filename=' . basename($file));
            header("Content-Transfer-Encoding: binary");
            header('Cache-Control: must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');
            header('Content-Length: ' . filesize($file));
            // 发送文件内容
            set_time_limit(0);
            ob_clean();
            flush();
            readfile($file);
        }
    }
}
