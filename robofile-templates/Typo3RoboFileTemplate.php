<?php

// INSERT: IROBO_BOILERPLATE //

class RoboFile extends \Robo\Tasks {
    use \iMi\RoboPack\LoadTasks;

    public function __construct() {
        $this->stopOnFail();
    }

    /**
     * Initial Setup of the project
     */
    public function setup() {
        $data = $this->askSetup();
        $this->_writeAdditionalConfigurationFile( $data );
        $baseUrl = $data['baseUrl'];

        $this->updateDependencies();

        $this->updateBaseUrl( $baseUrl );
        $this->taskTypo3DatabaseStack()->createDatabase()->run();
    }

    /**
     * Update dependencies only
     */
    public function updateDependencies() {
        $this->taskComposerInstall()->run();
        $this->_exec( 'yarn' );
    }

    /**
     * set Base URL in enviroment.ts
     */
    public function updateBaseUrl( $baseUrl ) {
        $this->taskReplaceInFile( 'public/typo3conf/theme/Configuration/TypoScript/environment.ts' )
             ->from( '###baseUrl###' )
             ->to( $baseUrl )
             ->run();
    }

    public function update() {
        $this->updateDependencies();
        $this->updateDatabase();
    }

    /**
     * Imports a dump from ./sql/
     * By default the master.sql is imported
     *
     * @param string $fileName Filename (in sql/, do not add the path)
     */
    public function dbReplace( $fileName = 'master.sql' ) {
        $this->taskTypo3DatabaseDumpStack()
             ->setFilename( 'backup_before_replace.sql' )
             ->run();
        $this->taskTypo3DatabaseImportStack()
             ->setFilename( 'sql/' . $fileName )
             ->run();
        $this->updateDatabase();
    }


    /**
     * Wrapper for the TYPO3 CLI command to compare the DB Schema
     */
    public function updateDatabase() {
        $this->_typo3cms( 'database:updateschema' );
    }

    /**
     * Exports the TYPO3 Database into an file
     *
     * You can give the filename w/o a path as parameter e.g. "temp_backup.sql"
     * If no filename is given, then the default will be "<current branch>.sql"
     *
     * @param string $filename Optional filename w/o path
     * @option $full By default, the cache tables are excluded,
     *               by setting the --full you include the cache tables
     */
    public function dbDump( $fileName = "master.sql" ) {
        $this->taskTypo3Stack()->execDbDumpExclude( 'sql/' . $fileName )->run();
    }

    /**
     * Flush TYPO3 Cache
     */
    public function cacheFlush() {
        $this->_typo3cms( 'cache:flush' );
    }

    /**
     * Add a NEW backend admin user
     * dev_admin / password: dev
     */
    public function setupDev() {
        $this->taskTypo3DatabaseStack()
             ->safeQuery( "INSERT INTO be_users (username, password, admin) VALUES ('dev_admin', MD5('dev'), '1')" )
             ->run();
    }
}