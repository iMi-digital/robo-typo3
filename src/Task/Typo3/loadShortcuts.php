<?php
namespace iMi\RoboTypo3\Task\Typo3;

trait loadShortcuts
{
    /**
     * @param string $url
     *
     * @return \Robo\Result
     */
    protected function _typo3cms($action)
    {
        return $this->taskTypo3Stack()->exec($action)->run();
    }
}
