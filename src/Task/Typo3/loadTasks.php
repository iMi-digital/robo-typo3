<?php
namespace iMi\RoboTypo3\Task\Typo3;

trait loadTasks
{
    /**
     * @param string $pathToWpcli
     *
     * @return \iMi\RoboTypo3\Task\Typo3\Stack
     */
    protected function taskTypo3Stack($pathToTypo3Cms = null)
    {
        return $this->task(Stack::class, $pathToTypo3Cms);
    }


    protected function taskTypo3DatabaseStack()
    {
        return $this->task(DatabaseStack::class);
    }

    protected function taskTypo3DatabaseDumpStack()
    {
        return $this->task(DumpStack::class);
    }

    protected function taskTypo3DatabaseImportStack()
    {
        return $this->task(ImportStack::class);
    }

}
