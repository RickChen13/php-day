<?php

declare(strict_types=1);

namespace app\common\helper;

abstract class CoreCommand
{
    public int $argc = 0;

    public array $argv = [];

    public array $eg = [];

    public array $options = [];

    public array $optionsShort = [];

    public array $optionsLong = [];

    public function __construct(int $argc, array $argv)
    {
        $this->argv = $argv;
        $this->argc = $argc;
        $this->setOptions();
        $this->setEg();
        $this->options["help"] = [
            "short" => "h",
            "description" => "查看帮助",
            "type" => "exists",
        ];
        $this->setOptionsAlias();
        return $this;
    }

    /**
     * 设置参数
     *
     * @return void
     */
    protected function setOptions()
    {
    }

    /**
     * 设置例子
     *
     * @return void
     */
    protected function setEg()
    {
    }

    private function setOptionsAlias()
    {
        foreach ($this->options as $key => $value) {
            if ($value["short"] != "") {
                $this->optionsShort[] = '-' . $value["short"];
            }
            $this->optionsLong[] = '--' . $key;
        }
    }

    /**
     * 开始执行
     *
     * @return void
     */
    public function run()
    {
        $help = $this->getOption('help');
        if ($help === true) {
            $this->help();
        } else {
            $this->handle();
        }
    }

    /**
     * 处理
     *
     * @return void
     */
    protected function handle()
    {
    }

    /**
     * 获取参数
     *
     * @param string $name
     * @param mixed  $default
     * @return mixed
     */
    protected function getOption(string $name, $default = null)
    {
        if (array_key_exists($name, $this->options)) {
            $targe = $this->options[$name];
            for ($i = 1; $i < $this->argc; $i++) {
                switch (true) {
                    case $this->argv[$i] == "-" .  $targe["short"]:
                    case $this->argv[$i] == "--" .  $name:
                        switch ($targe['type']) {
                            case 'string':
                                $j = $i + 1;
                                if ($j < $this->argc) {
                                    $res =  $this->argv[$j];
                                    if (!in_array($res, $this->optionsShort) && !in_array($res, $this->optionsLong)) {
                                        return trim($this->argv[$j]);
                                    } else {
                                        return null;
                                    }
                                } else {
                                    return $default;
                                }
                                break;
                            case 'exists':
                                return true;
                                break;
                            default:
                                return $default;
                                break;
                        }
                        break;
                }
            }
        } else {
            return $default;
        }
    }

    /**
     * 添加例子
     *
     * @param string $string
     * @return void
     */
    protected function addEg(string $string)
    {
        $this->eg[] = $string;
    }

    /**
     * 输出文字
     *
     * @param string $str
     * @return void
     */
    protected function line($str = "")
    {
        echo $str, PHP_EOL;
    }

    /**
     * 输出错误信息
     *
     * @param string $str
     * @return void
     */
    protected function error(string $str)
    {
        $this->line();
        $this->line($this->strStyle("\t[error]" . $str, "error"));
        $this->help();
    }

    /**
     * 输出信息
     *
     * @param string $str
     * @return void
     */
    protected function info(string $str)
    {
        $this->line($this->strStyle($str, "info"));
    }

    /**
     * 输出帮助
     *
     * @return void
     */
    protected function help()
    {
        $t = "\t";
        $this->line();
        $this->info("Help：");
        if ($this->argc > 1) {
            $this->info("{$t}参数：");
            $this->info("{$t}{$t}name{$t}shot{$t}long{$t}description{$t}type{$t}");
            foreach ($this->options as $name => $option) {
                $short = $option["short"] ? "-" . $option["short"] : "";
                $long = "--" . $name;
                $description = $option["description"];
                $type = $option["type"];
                $this->info("{$t}{$t}{$name}{$t}{$short}{$t}{$long}{$t}{$description}{$t}{$type}{$t}");
            }
        }
        if (!empty($this->eg)) {
            $this->info("{$t}示例：");
            foreach ($this->eg as $eg) {
                $this->info("{$t}{$t}{$eg}");
            }
        }
        $this->line();
    }

    /**
     * 给文字写入颜色
     *
     * @param string $str
     * @param string $style
     * @return string
     */
    public function strStyle(string $str, string $style): string
    {
        switch ($style) {
            case 'info':
                return "\033[32m" . $str . "\033[0m";
                break;
            case 'error':
                return "\033[41m" . $str . "\033[0m";
                break;
            case 'warn':
                return "\033[43m" . $str . "\033[0m";
            default:
                return $str;
                break;
        }
    }
}
