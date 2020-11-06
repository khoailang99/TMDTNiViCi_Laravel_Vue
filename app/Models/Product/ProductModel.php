<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  private $prodNumbDisplayed = 8;

  public function getCountProd() {
    return Product::count();
  }

  public function getAllProductsPM() {
    $products = Product::where('CategoryID',1) -> take($this -> prodNumbDisplayed) -> get();
    return $products;
  }

  public function getProdP($page) {
    $products = Product::skip(($page - 1) * $this -> prodNumbDisplayed) -> take($this -> prodNumbDisplayed) -> get();
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
