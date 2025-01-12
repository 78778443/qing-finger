<?php
declare (strict_types=1);

namespace app\command;

use app\controller\Reqable;
use app\model\aimodel;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class scan extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('app\command\scan')
            ->setDescription('the app\command\scan command');
    }

    protected function execute(Input $input, Output $output)
    {
        // 指令输出
//        $output->writeln('app\command\scan');
//        aimodel::ai();
        aimodel::mingan_data();
//        Reqable::test();
//        aimodel::domainGet();
    }
}
