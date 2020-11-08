<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

use App\Models\Category\ProductCategoryModel;
use App\Models\Specification\ProductCategoryS_ProductS_Model;
use App\Models\Promotion\PmtDetail_PmtPackage_Model;

class Product extends Model
{
  private $prodNumbDisplayed = 8;

  public function totalNumbProdDisplayed() {
    return Product::whereNotIn('Status',[2,3]) -> count(); // 2: ẩn, 3: xóa
  }

  public function ProductsHomepage_PM($page = null) {
    if($page == null) {
      $productsDB = Product::whereNotIn('Status',[2,3])
                        -> take($this -> prodNumbDisplayed)
                        -> select('ID','Name','Alias','Image','MoreImages','Price','OriginalPrice','PromotionPrice','Quantity','PromotionPackageID', 'Status') 
                        -> get(); 
    }else {
      $productsDB = Product::whereNotIn('Status',[2,3]) 
                          -> skip(($page - 1) * $this -> prodNumbDisplayed)
                          -> take($this -> prodNumbDisplayed) 
                          -> select('ID','Name','Alias','Image','MoreImages','Price','OriginalPrice','PromotionPrice','Quantity','PromotionPackageID', 'Status')
                          -> get();
    }
    
    $products = array();
    foreach($productsDB as $prod) {
      $prodDetailM = new ProductDetailModel();
      $prodDetailM -> ProductsForHomepage_PDM($prod);
      array_push($products, $prodDetailM);
    }
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
