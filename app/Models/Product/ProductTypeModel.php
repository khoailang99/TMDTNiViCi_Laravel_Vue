<?php

namespace App\Models\Product;

class ProductTypeModel
{
  public function __construct($fatherLv, $childLv) {
    $this->fatherLv = $fatherLv;
    $this->childLv = $childLv;
  }

  public $fatherLv;
  public $childLv;
}
