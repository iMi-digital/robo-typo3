<?php

namespace iMi\RoboTypo3\Task\Typo3;

use Robo\Task\Filesystem\FilesystemStack;

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


    protected function _writeAdditionalConfigurationFile(
        $data,
        $mapVariablesToValues = [
            'dbName'     => 'DATABASE',
            'dbHost'     => 'HOST',
            'dbUser'     => 'USERNAME',
            'dbPassword' => 'PASSWORD',
        ]
    ) {
        $fileSystemTask = $this->task( FilesystemStack::class );
        $target = 'public/typo3conf/AdditionalConfiguration.php';
        $fileSystemTask->copy( 'public/typo3conf/AdditionalConfiguration.example.php', $target )->run();
        foreach ( $mapVariablesToValues as $dataKey => $configKey ) {
            $value = isset( $data[ $dataKey ] ) ? $data[ $dataKey ] : '';
            $this->taskReplaceInFile( $target )->from( '#' . $configKey . '#' )->to( $value )->run();
        }
    }

}
