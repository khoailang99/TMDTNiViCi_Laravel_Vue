<?php

namespace App\Models;

class ProductType
{
  public function __construct($fatherLv, $childLv) {
    $this->fatherLv = $fatherLv;
    $this->childLv = $childLv;
  }

  public $fatherLv;
  public $childLv;
}
