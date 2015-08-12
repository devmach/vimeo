<?php
  /**
   * In a modern framework, we would probably autoload
   * the following filters.
   * http://php.net/manual/en/function.spl-autoload.php
   */
  require('filters/ValidRecord.php');
  require('filters/NotValidRecord.php');
  require('libs/ProcessCSV.php');


  /**
   * try .. catch will cath possible errors, like clips.csv
   * not exists... Another way could be checking if related
   * file readable/writable via isReadable & isWritable of
   * SplFileInfo
   *
   * http://php.net/manual/en/splfileinfo.isreadable.php
   * http://php.net/manual/en/splfileinfo.iswritable.php
   */

  try {

    /**
     * General idea of reading big files is, reading it by
     * chunks. ProcessCSV / SplFileObject does the magic here.
     * If we didnt used it, we could read file by fread with
     * a length parameter.
     */

    $clips = new ProcessCSV('./clips.csv');

    $clips->applyFilter('ValidRecord', './valid.csv')
          ->applyFilter('NotValidRecord', './invalid.csv');

    echo "Done... Good luck and good night...\n";
  } catch(Exception $e) {
    echo 'Critical Error>: ' . $e->getMessage() . "\n";
    return;
  }
