<?php
  class ValidRecord extends FilterIterator {
    protected function isValidRecord($current) {
      list($id,$title,$privacy,$total_plays,$total_comments,$total_likes) = $current;
      return $privacy === 'anybody'
        && $total_likes > 10
        && $total_plays > 200
        && strlen($title) < 30;
    }

    public function accept() {
      $current = $this->current();
      return $this->isValidRecord($current);
    }
  };
  