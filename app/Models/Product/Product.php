<?php

namespace App\Models\Product;

use Illuminate\Support\Facades\DB;
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

  // Lấy các sản phẩm theo ID và cấp độ loại sản phẩm hoặc danh mục
  public function getProds_Category_ProdType($level = 2, $c_pt_ID = 49) {
    if($level == 1) { // Loại sản phẩm cấp 1 
      $prodCollection = DB::table('ProductCategories as pc') -> where('Relationship','like','%,'.$c_pt_ID.',%')
                    -> join ('Products as prod', 'prod.CategoryID', '=', 'pc.ID')
                    -> whereNotIn('prod.Status',[2,3])
                    -> select('prod.ID','prod.Name','prod.Alias','prod.Image','prod.MoreImages','prod.Price','prod.OriginalPrice','prod.PromotionPrice','prod.Quantity','prod.PromotionPackageID', 'prod.Status') 
                    -> get();
    } else if($level == 3) { // Danh mục or loại sản phẩm cấp 3
      $prodCollection = $this -> getProds_Category_ProdType_lv3($c_pt_ID);
    } else { // Danh mục or loại sản phẩm cấp 2
      $prodCollection = collect(array());
      $childItems = DB::table('ProductCategories as pc') -> where('ParentID',$c_pt_ID) -> get();
      foreach($childItems as $aSubItem) {
        $prodCollection = $prodCollection -> concat($this -> getProds_Category_ProdType_lv3($aSubItem -> ID));
      }
    }
    return $prodCollection;
  }

  // Lấy các sản phẩm theo danh mục hoặc loại sản phẩm cấp 3
  public function getProds_Category_ProdType_lv3($aSubItemID) {
    return DB::table('Products as prod') -> whereNotIn('prod.Status',[2,3])
            -> where('CategoryID', $aSubItemID)
            -> orWhere('Category','like','%,'.$aSubItemID.',%')
            -> select('prod.ID','prod.Name','prod.Alias','prod.Image','prod.MoreImages','prod.Price','prod.OriginalPrice','prod.PromotionPrice','prod.Quantity','prod.PromotionPackageID', 'prod.Status')
            -> get();
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
