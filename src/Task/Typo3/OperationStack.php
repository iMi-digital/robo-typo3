<?php

namespace iMi\RoboTypo3\Task\Typo3;

use IMI\DatabaseHelper\Mysql;
use IMI\DatabaseHelper\Operations\Dump;
use Robo\Collection\CollectionBuilder;
use Robo\Common\ExecCommand;
use Robo\Common\ProcessExecutor;
use Robo\Task\Base\ExecStack;
use Robo\Task\StackBasedTask;
use Robo\TaskAccessor;
use Symfony\Component\Process\Process;

class OperationStack extends AbstractStack {
    use TaskAccessor;

    protected function getDelegate() {
        return $this->operation;
    }

    public function run() {
        parent::run(); // to call setters

        $stack = new ExecStack();
        $stack->inflect($this)->printOutput(true);

        $commands = $this->operation->createExec()->getCommands();
        foreach ($commands as $command) {

            $stack->exec($command);
        }
        $stack->run();
    }


}