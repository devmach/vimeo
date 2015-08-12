<?php
  /*
  * We could have a prameter to negate to ValidRecord
  * but the way we implemented is more explicit.
  */
  
  class NotValidRecord extends ValidRecord {
    public function accept() {
      $current = $this->current();
      return !parent::isValidRecord($current);
      }
  }