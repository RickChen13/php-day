<?php

declare(strict_types=1);

namespace app\day\Y2022\m08;

# composer require symfony/yaml
# link https://symfony.com/doc/current/components/yaml.html
use Symfony\Component\Yaml\Yaml;

class Day20220831
{
    /**
     * 入口函数
     *
     * @return void
     */
    public function run()
    {
    }

    /**
     * 解析yaml内容
     *
     * @param string $str
     * @return mixed
     * @tag yaml 解析yaml内容
     */
    public function parse(string $str)
    {
        return Yaml::parse($str);
    }

    /**
     * 读取并解析yaml文件内容
     *
     * @param string $filename
     * @return mixed
     * @tag yaml 读取并解析yaml文件内容
     */
    public function parseFile(string $filename)
    {
        return Yaml::parseFile($filename);
    }

    /**
     * 写入yaml文件
     *
     * @param string $filename
     * @param array $array
     * @return void
     * @tag yaml 写入yaml文件
     */
    public function dump(string $filename, array $array)
    {
        $yaml = Yaml::dump($array);
        file_put_contents($filename, $yaml);
    }
}
