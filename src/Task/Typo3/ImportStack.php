<?php

namespace iMi\RoboTypo3\Task\Typo3;

use IMI\DatabaseHelper\Operations\Import;
use Symfony\Component\Process\ExecutableFinder;

class ImportStack extends OperationStack  {
    public function __construct() {
        parent::__construct();
        $this->operation = new Import($this->helper, $this->output, $this->asker);

        $finder = new ExecutableFinder();
        $pvAvailable = $finder->find('pv', null, []);
        $this->setIsPipeViewerAvailable($pvAvailable);
    }
}