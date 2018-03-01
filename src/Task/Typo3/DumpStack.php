<?php

namespace iMi\RoboTypo3\Task\Typo3;

use IMI\DatabaseHelper\Operations\Dump;

class DumpStack extends OperationStack  {
    public function __construct() {
        parent::__construct();
        $this->operation = new Dump($this->helper, $this->output, $this->asker);
    }
}