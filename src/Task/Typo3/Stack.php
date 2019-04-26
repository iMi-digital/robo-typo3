<?php
namespace iMi\RoboTypo3\Task\Typo3;

use Robo\Exception\TaskException;
use Robo\Task\CommandStack;

class Stack extends CommandStack
{
    /**
     * @param null|string $pathToWpcli
     *
     * @throws \Robo\Exception\TaskException
     */
    public function __construct($pathToTypo3Cms = null)
    {
        $this->executable = $pathToTypo3Cms;
        if ( ! $this->executable) {
            $this->executable = $this->findExecutable('typo3cms');
        }
        if ( ! $this->executable) {
            $cmd = 'public/typo3cms';
            if (file_exists($cmd)) {
                $this->executable = $cmd;
            }
        }
        if ( ! $this->executable) {
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

    /**
     * @param $fileName
     * @param array $parameters Array of parameters (will be escaped)
     */
    public function execDbDump($fileName, $parameters = [])
    {
        $parameters = (array)$parameters;
        $this->exec('database:export ' . implode(" ", $parameters) . ' > ' . $fileName);
    }

    public function execDbDumpExclude(
        $fileName,
        $excludeTables = 'cache,cache_tag,be_sessions,sys_log,cf_cache_hash,cf_cache_hash_tags,cf_cache_imagesizes,cf_cache_imagesizes_tags,cf_cache_pages,cf_cache_pages_tags,cf_cache_pagesection_cf_cache_pagesection_tags,cf_cache_rootline,cf_cache_rootline_tags'
    ) {
        $excludeTablesArray = explode(',', $excludeTables);

        foreach ($excludeTablesArray as $key => $value) {
            $excludeTablesArray[$key] = '--exclude ' . escapeshellarg($value);
        }

        $this->execDbDump($fileName, $excludeTablesArray);
    }
}
