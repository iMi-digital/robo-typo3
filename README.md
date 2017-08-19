Typo3Console Wrapper for Robo.li
================================

This is (currentl very thin) wrapper around Typo3 Wrapper for using it in the
Robo task runner.

It requires typo3 console.

Commands:

    $this->taskTypo3Stack()->exec($command)
    
Soon:

    $this->taskTypo3Stack()->execDbDump(filename)
    $this->taskTypo3Stack()->execDbDumpStripped(filename)