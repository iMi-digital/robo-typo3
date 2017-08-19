<?php
namespace iMi\RoboTypo3\Task\Typo3;

use Robo\Task\CommandStack;

class Stack extends CommandStack
{
	/**
	 * @param null|string $pathToWpcli
	 *
	 * @throws \Robo\Exception\TaskException
	 */
	public function __construct($pathToWpcli = null)
	{
		$this->executable = $pathToWpcli;
		if (!$this->executable) {
			$this->executable = $this->findExecutablePhar('typo3cms');
		}
		if (!$this->executable) {
			throw new TaskException(__CLASS__, "typo3cms installation could be found.");
		}
	}

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->printTaskInfo("Running Typo3Cms commands...");
        return parent::run();
    }
}
