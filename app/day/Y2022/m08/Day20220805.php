<?php

declare(strict_types=1);

namespace app\day\Y2022\m08;

use function Swoole\Coroutine\go;
use Swoole\Coroutine\WaitGroup;
use app\common\helper\Http;

class Day20220805
{

    /**
     * 入口函数
     *
     * @return void
     */
    public function run()
    {
        $ip = "66.42.67.158";
        $this->getIpTerritory($ip);
    }

    /**
     * 获取ip属地
     *
     * @param string $ip
     * @return void
     * @tab IP 获取ip属地
     */
    public function getIpTerritory(string $ip)
    {
        // 百度
        $baidu_url = "http://opendata.baidu.com/api.php?query={$ip}&co=&resource_id=6006&oe=utf8";
        // 直接调用即可【没有频率限制】
        $useragentinfo_url = "https://ip.useragentinfo.com/json?ip={$ip}";
        $result = [];
        $wg = new WaitGroup();
        $wg->add(2);
        go(function () use ($baidu_url, $wg, &$result) {
            $data = Http::get($baidu_url);
            $res = json_decode($data, true);
            $result['baidu'] = $res;
            $wg->done();
        });
        go(function () use ($useragentinfo_url, $wg, &$result) {
            $data = Http::get($useragentinfo_url);
            $res = json_decode($data, true);
            $result['useragentinfo'] = $res;
            $wg->done();
        });
        $wg->wait();
        var_dump($result);
    }
}
