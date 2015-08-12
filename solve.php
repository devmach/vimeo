<?php
  /**
   * In a modern framework, we would probably autoload
   * the following filters.
   * http://php.net/manual/en/function.spl-autoload.php
   */
  require('filters/ValidRecord.php');
  require('filters/NotValidRecord.php');


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
     * chunks. SplFileObject does the magic here. If we didnt
     * used it, we could read file by fread with a length
     * parameter. 
     */

    $clips = new SplFileObject("./clips.csv");
    $clips->setFlags(SplFileObject::SKIP_EMPTY 
      | SplFileObject::DROP_NEW_LINE
      | SplFileObject::READ_CSV);

    $validsFile = new SplFileObject('./valid.csv', 'w');
    $invalidsFile = new SplFileObject('./invalid.csv', 'w');

    /**
     * We don't want the header line... So use LimitIterator
     * to ignore it.
     */

    $data = new LimitIterator($clips, 1);
    $accepted = new ValidRecord($data);
    $declined = new NotValidRecord($data);

    /**
     * We could format rows and turn them into objects, so we
     * could use something like $row->id than $row[0]
     */

    foreach($accepted as $row) {
      $validsFile->fwrite($row[0] . "\n");
    }

    foreach($declined as $row) {
      $invalidsFile->fwrite($row[0] . "\n");
    }

  } catch(Exception $e) {
    echo 'Critical Error>: ' . $e->getMessage();
    return;
  }
