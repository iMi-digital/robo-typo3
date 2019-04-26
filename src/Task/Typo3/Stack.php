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
        if (!$this->executable) {
            $this->executable = $this->findExecutable('typo3cms');
        }
        if (!$this->executable) {
            $cmd = 'public/typo3cms';
            if (file_exists($cmd)) {
                $this->executable = $cmd;
            }
        }
        if (!$this->executable) {
            throw new TaskException(__CLASS__, "typo3cms installation could be found.");
        }
    }

    /**
     * @param $fileName
     * @param array $parameters Array of parameters (will be escaped)
     */
    public function execDbDump($fileName, $parameters = [])
    {
        $parameters = (array) $parameters;

        if (count($parameters)>0) {
            for ($i = 0; $i<count($parameters); $i++) {
                $parameters[$i] = '--exclude ' . escapeshellarg($parameters[$i]);
            }
        }

        $this->exec('database:export ' . implode(" ",$parameters) . ' > ' . $fileName);
    }

    public function execDbDumpExclude($fileName)
    {
        $excludeTables = 'cache,cache_tag,be_sessions,sys_log,cf_cache_hash,cf_cache_hash_tags,cf_cache_imagesizes,cf_cache_imagesizes_tags,cf_cache_pages,cf_cache_pages_tags,cf_cache_pagesection_cf_cache_pagesection_tags,cf_cache_rootline,cf_cache_rootline_tags';
        $excludeTablesArray = explode(',',$excludeTables);

        $this->execDbDump($fileName, $excludeTablesArray);
    }
}
