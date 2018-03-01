<?php

namespace iMi\RoboTypo3\Task\Typo3;

use IMI\DatabaseHelper\Mysql;
use Robo\Common\IO;
use Robo\Task\StackBasedTask;

class AbstractStack extends StackBasedTask {
    protected $t3conf = './public/typo3conf/';

    protected $t3src = './public/typo3/';

    use IO;

    /**
     * @var Mysql
     */
    protected $helper;

    public function __construct() {
        $this->output = function ($text) {
            $this->outputAdapter()->writeMessage($text . PHP_EOL);
        };
        $this->asker = function ($question, $default) {
            return $this->askDefault($question, $default);
        };

        $this->helper = new Mysql($this->getTypo3Config(), $this->output);
    }

    /**
     * Load the Database Configuration
     */
    protected function getTypo3Config() {
        $databaseConfiguration = $this->t3conf . 'AdditionalConfiguration.php';
        if (is_file($databaseConfiguration)) {
            require_once $databaseConfiguration;
        }

        $host     = $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host'];
        $username = $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user'];
        $password = $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'];
        $dbname = $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname'];

        return compact('host', 'username', 'password', 'dbname');
    }


}