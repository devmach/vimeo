<?php
  class ProcessCSV extends SplFileObject {
    public function __construct($filename) {
      parent::__construct($filename);
      $this->setFlags(SplFileObject::SKIP_EMPTY
        | SplFileObject::DROP_NEW_LINE
        | SplFileObject::READ_CSV);
      /**
       * We don't want the header line... So use move iterator by one
       * to ignore it.
       */
      $this->next();
    }

    public function rewind() {
      parent::rewind();
      parent::next();
    }

    public function applyFilter($filter, $filename) {
      $data = new $filter($this);
      $file = new SplFileObject($filename, 'w');

      /**
       * We could have format rows and turn them into objects, so we
       * could use something like $row->id than $row[0]
       */
      foreach($data as $row) {
        $file->fwrite($row[0] . "\n");
      }
      return $this;
    }
  }