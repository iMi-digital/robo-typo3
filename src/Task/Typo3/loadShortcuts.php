<?php

namespace iMi\RoboTypo3\Task\Typo3;

trait loadShortcuts {
    /**
     * @param string $url
     *
     * @return \Robo\Result
     */
    protected function _typo3cms( $action ) {
        return $this->taskTypo3Stack()->exec( $action )->run();
    }

    protected function _typo3getTableDefinitions() {
        return [
            'development' => [ 'tables' => [ 'cache cache_tag be_sessions sys_log cf_cache*' ] ],
        ];
    }


    /**
     * Load the Database Configuration
     */
    protected function typo3dbLoadConfig() {
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

    protected function _typo3dbDevelopmentDump( $filename ) {
        $this->taskDatabaseStack( $this->typo3dbLoadConfig(),
            $this->_typo3getTableDefinitions() )->setFilename( $filename )
             ->setIsHumanReadable( true )
             ->setAddTime( 'no' )
             ->setStrip( '@development' )
             ->dump()->run();
    }
}
