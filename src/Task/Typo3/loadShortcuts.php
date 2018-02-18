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

    protected function _typo3dbDevelopmentDump( $filename ) {
        $this->taskDatabaseStack( [
            'dbname'   => 'club_sata_com',
            'username' => 'root',
            'password' => 'root',
            'host'     => 'localhost'
        ], $this->_typo3getTableDefinitions() )->setFilename( $filename )
             ->setIsHumanReadable( true )
             ->setAddTime( 'no' )
             ->setStrip( '@development' )
             ->dump()->run();
    }
}
