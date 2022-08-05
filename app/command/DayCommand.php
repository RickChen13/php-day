<?php

declare(strict_types=1);

namespace app\command;

use app\common\helper\Io;
use app\common\helper\Path;
use app\common\helper\CoreCommand;

class DayCommand extends CoreCommand
{
    protected function setOptions()
    {
        $this->options = [
            "touch" => [
                "short" => "",
                "description" => "创建文件",
                "type" => "exists",
            ],
            "run" => [
                "short" => "",
                "description" => "执行文件",
                "type" => "exists",
            ],
            "time" => [
                "short" => "t",
                "description" => "时间参数",
                "type" => "string",
            ],
            "date" => [
                "short" => "d",
                "description" => "日期参数",
                "type" => "string",
            ],

        ];
    }

    protected function setEg()
    {
        $this->addEg("run 'php ./bin/command.php day --touch'    默认为今天的日期，如果需要指定日期，可以使用 --date 2019-01-01 或者 --time 1546300800");
        $this->addEg("run 'php ./bin/command.php day --touch -d 2019-01-01");
        $this->addEg("run 'run 'php ./bin/command.php day --run -t 1546300800'");
    }

    protected function handle()
    {
        $touch = $this->getOption('touch');
        $run = $this->getOption('run');
        $Time = $this->getTime();
        switch (true) {
            case $touch === true && $run !== true:
                if ($Time > -1) {
                    $this->TouchPHP($Time);
                } else {
                    $this->error("  时间或者日期参数错误~  ");
                }
                break;
            case $touch !== true && $run === true:
                if ($Time > -1) {
                    $this->RunPHP($Time);
                } else {
                    $this->error("  时间或者日期参数错误~  ");
                }
                break;
            default:
                $this->error("  参数错误~  ");
                break;
        }
    }

    private function getTime()
    {
        $time = $this->getOption("time");
        $date = $this->getOption("date");
        $Time = -1;

        switch (true) {
            case $time !== null && $date === null:
                $Time = (int)$time;
                break;
            case $time === null && $date !== null:
                $strtotime = strtotime((string)$date);
                if ($strtotime !== false) {
                    $Time = $strtotime;
                }
                break;

            case $time === null && $date === null:
                $Time = time();
                break;
            case $time !== null && $date !== null:
                break;
            default:
                break;
        }
        return $Time;
    }

    private function TouchPHP(int $time)
    {
        $y = date('Y', $time);
        $m = date('m', $time);
        $d = date('d', $time);

        $dir = BASE_PATH . "/app/day/Y$y/m$m";
        $Fullmc = "Day{$y}{$m}{$d}.php";
        $content =
            #region
            <<<EOL
<?php

declare(strict_types=1);

namespace app\\day\\Y{$y}\\m{$m};

class Day{$y}{$m}{$d}
{
    /**
     * 入口函数
     *
     * @return void
     */
    public function run()
    {
        echo "Hello World!",PHP_EOL;
    }
}

EOL;
        #endregion

        $filename = Path::formatPath($dir . "/" . $Fullmc);
        if (!file_exists($filename)) {
            IO::put($dir, $Fullmc, $content);
        } else {
            $this->error("  文件已存在~  ");
        }
    }

    private function RunPHP(int $time)
    {
        $y = date('Y', $time);
        $m = date('m', $time);
        $d = date('d', $time);

        $dir = BASE_PATH . "/app/day/Y$y/m$m";
        $Fullmc = "Day{$y}{$m}{$d}.php";

        if (file_exists($dir . "/" . $Fullmc)) {
            $class = "app\\day\\Y{$y}\\m{$m}\\Day{$y}{$m}{$d}";
            $info = "[Running] php \"{$dir}/{$Fullmc}\"";

            $this->line();
            $this->info($info);
            $this->line();
            try {
                $us = get_func_run_time(function () use ($class) {
                    (new $class())->run();
                });
                $ms = $us / 1000;
                $this->line();
                $this->info("[Done]  执行时间：{$ms}ms");
                $this->line();
            } catch (\Throwable $e) {
                $this->error("[Error] {$e->getMessage()}", false);
                $this->line();
            }
        } else {
            $this->error("  文件不存在~  ", false);
            $this->line();
            return;
        }
    }
}
