<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  private $prodNumbDisplayed = 30;

  public function getAllProductsPM() {
    $products = Product::where('CategoryID',1) -> take($this -> prodNumbDisplayed) -> get();
    return $products;
  }

  /**
   * Get the value of prodNumbDisplayed
   */ 
  public function getProdNumbDisplayed()
  {
    return $this->prodNumbDisplayed;
  }

  /**
   * Set the value of prodNumbDisplayed
   *
   * @return  self
   */ 
  public function setProdNumbDisplayed($prodNumbDisplayed)
  {
    $this->prodNumbDisplayed = $prodNumbDisplayed;

    return $this;
  }
}
