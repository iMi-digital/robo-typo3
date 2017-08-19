Typo3Console Wrapper for Robo.li
================================

This is (currentl very thin) wrapper around Typo3 Wrapper for using it in the
Robo task runner.

It requires typo3 console.

Commands
--------

Execute typo3cms

    $this->taskTypo3Stack()->exec($command)
    
Shortcut for the above:
    
    $this->_typo3cms($command);

Dump Database to file    

    $this->taskTypo3Stack()->execDbDump($fileName)
    
Dump Database to file, excluding cache files, inspired by magerun

    $this->taskTypo3Stack()->execDbDumpExclude(fileName)