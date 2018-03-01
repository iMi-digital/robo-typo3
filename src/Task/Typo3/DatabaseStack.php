<?php

namespace iMi\RoboTypo3\Task\Typo3;

use IMI\DatabaseHelper\Mysql;
use Robo\Task\StackBasedTask;

class DatabaseStack extends AbstractStack {

    protected function getDelegate() {
        return $this->helper;
    }
}