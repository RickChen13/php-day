<?php

declare(strict_types=1);

namespace app\command;

use app\common\helper\CoreCommand;

class Command extends CoreCommand
{
    protected function setOptions()
    {
    }

    protected function setEg()
    {
    }

    /**
     * 开始执行
     *
     * @return void
     */
    public function run()
    {
        if ($this->argc >= 2) {
            $command = $this->argv[1];
            if ($command == "--help" || $command == "-h") {
                $this->help();
                return;
            }
        }
        $this->handle();
    }

    protected function handle()
    {
        if ($this->argc >= 2) {
            $command = ucfirst($this->argv[1]);
            $dir = BASE_PATH . "/app/command";
            $Fullmc = "{$command}Command.php";
            if (file_exists($dir . "/" . $Fullmc)) {
                $class = "\\app\\command\\{$command}Command";
                (new $class($this->argc, $this->argv))->run();
            } else {
                $this->error("  文件不存在~  ", false);
                $this->line();
                return;
            }
        }
    }
}
