<?php

namespace App\Models\Product;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category\ProductCategoryModel;
use App\Models\Specification\ProductCategoryS_ProductS_Model;
use App\Models\Promotion\PmtDetail_PmtPackage_Model;

class Product extends Model
{
  private $prodNumbDisplayed = 10;

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
  public function getProds_Category_ProdType_PM($level, $c_pt_ID, $page) {
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

    \Debugbar::warning("Cac bo loc cua danh muc san pham capnnnnnnnnnnnn !" );
    \Debugbar::info($prodCollection);

    $products = array();
    $prodsFilteredPaging = $prodCollection -> skip(($page - 1) * ($this -> prodNumbDisplayed)) -> take($this -> prodNumbDisplayed);
    
    \Debugbar::warning("Cac bo loc cua danh muc san pham capnnnnnnnnnnnn !" );
    \Debugbar::info($prodsFilteredPaging);

    foreach($prodsFilteredPaging as $prod) {
      $prodDetailM = new ProductDetailModel();
      $prodDetailM -> ProductsForHomepage_PDM($prod);
      array_push($products, $prodDetailM);
    }


    return ["total_pages" => ceil($prodCollection  -> count() / $this -> prodNumbDisplayed), "listProducts" => $products];
  }

  // Lấy các sản phẩm theo danh mục hoặc loại sản phẩm cấp 3
  public function getProds_Category_ProdType_lv3($aSubItemID) {
    return DB::table('Products as prod') -> whereNotIn('prod.Status',[2,3])
            -> where('CategoryID', $aSubItemID)
            -> orWhere('Category','like','%,'.$aSubItemID.',%')
            -> select('prod.ID','prod.Name','prod.Alias','prod.Image','prod.MoreImages','prod.Price','prod.OriginalPrice','prod.PromotionPrice','prod.Quantity','prod.PromotionPackageID', 'prod.Status')
            -> get();
  } 

  // Tìm kiếm sản phẩm 
  public function SearchProducts_PM($showAll, $info_search, $page) {
    if($showAll == 0) {
      $productsDB = Product::whereNotIn('Status',[2,3])
                      -> where('Name', 'like', '%'.$info_search.'%')
                      -> orWhere('Description', 'like', '%'.$info_search.'%')
                      -> select('ID','Name','Alias','Image','Price','OriginalPrice','PromotionPrice','Quantity','PromotionPackageID') 
                      -> get();
      
      $prodsFilteredPaging = $productsDB -> skip(($page - 1) * ($this -> prodNumbDisplayed)) -> take($this -> prodNumbDisplayed);
    }else {
      $prodsFilteredPaging = Product::whereNotIn('Status',[2,3])
                      -> where('Name', 'like', '%'.$info_search.'%')
                      -> orWhere('Description', 'like', '%'.$info_search.'%')
                      -> select('ID','Name','Alias','Image','Price','OriginalPrice','PromotionPrice','Quantity','PromotionPackageID') 
                      -> take($showAll)
                      -> get();
    }

    $products = array();
    foreach($prodsFilteredPaging as $prod) {
      $prodDetailM = new ProductDetailModel();
      $prodDetailM -> ProductsForHomepage_PDM($prod);
      array_push($products, $prodDetailM);
    }

    \Debugbar::warning("Các sản phẩm thỏa mãn giá trị tìm kiếm ở ProductModel !" );
    \Debugbar::info($prodsFilteredPaging);
                      
    return ["total_pages" => ($showAll == 0 ? ceil($productsDB  -> count() / $this -> prodNumbDisplayed) : 0 ), "listProducts" => $products];
  }

  // Lấy các sản phẩm theo bộ lọc
  public function getProductsFilter_PM($prodType, $filters, $page, $sortType = 1) {
    $products = DB::table('ProductCategories as PC') 
                -> where('PC.IsCategory', 0)
                -> where('PC.Relationship', 'like', '%,'.$prodType.',%')
                -> join('Products as Prod', 'PC.ID', '=', 'Prod.CategoryID')
                -> whereNotIn('prod.Status',[2,3])
                -> join('Product_Specifications as PS', 'Prod.ID', '=', 'PS.ProductID')
                -> where('PS.SpecificationID', $filters[0] -> filterID)
                -> whereIn('PS.Value', $filters[0] -> values)
                -> select('Prod.ID','Prod.Name','Prod.Alias','Prod.Image','Prod.MoreImages','Prod.Price','Prod.OriginalPrice',
                              'Prod.PromotionPrice','Prod.Quantity','Prod.PromotionPackageID', 'Prod.Status',
                              'PS.SpecificationID', 'PS.ProductID', 'PS.Value')
                -> get();

    array_shift($filters);

    if(count($filters) > 0) {
      $productsFiltered = $products -> reject(function($prod, $key) use ($filters){
        $numbProdSatisfyFilter = 0;
        foreach($filters as $filter) {
          $numbProdSatisfyFilter = DB::table('Product_Specifications as PS') 
                              -> where('PS.ProductID', $prod -> ID)
                              -> where('PS.SpecificationID', $filter -> filterID)
                              -> whereIn('PS.Value', $filter -> values)
                              -> count();
          if($numbProdSatisfyFilter == 0) {
            break;
            return;
          }
        }
        if($numbProdSatisfyFilter == 0) {
          return true;
        }
      });

      \Debugbar::warning("Các sản phẩm cuối cùng sau khi lọc và bộ lọc >= 2!");
      \Debugbar::info($productsFiltered);
      return array("totalPages" => ceil($productsFiltered -> count() / $this -> prodNumbDisplayed), 
      "listProducts" => $this -> getProductsFilter_PDM
      ($productsFiltered -> skip($this -> prodNumbDisplayed * ($page - 1)) -> take($this -> prodNumbDisplayed)));
    }

    \Debugbar::warning("Các sản phẩm thỏa mãn bộ lọc 1 là: ");
    \Debugbar::info($products);

    return array("totalPages" => ceil($products -> count() / $this -> prodNumbDisplayed), 
    "listProducts" => $this -> getProductsFilter_PDM
    ($products -> skip($this -> prodNumbDisplayed * ($page - 1)) -> take($this -> prodNumbDisplayed)));
  }
  public function getProductsFilter_PDM($filteredProds) {
    $products = array();
    foreach($filteredProds as $prod) {
      $prodDetailM = new ProductDetailModel();
      $prodDetailM -> ProductsForHomepage_PDM($prod);
      array_push($products, $prodDetailM);
    }
    return $products;
  }

  // Sắp xếp sản phẩm
  public function ProductArrangements_PM($productsDB) {
    switch(1) {
      case 1: // Sắp xếp theo khuyến mãi tốt nhất
        $productsDBSorted = $productsDB -> join('PromotionPackages as PP', 'Prod.PromotionPackageID', '=', 'PP.ID')
                        -> join('PromotionDetails as PD', 'PP.ID', '=', 'PD.ProPackageID')
                        -> join('Promotions as Promt','PD.PromotionID', '=', 'Promt.ID')
                        -> where('Promt.Amount', '>', 0)
                        -> whereNotNull('Promt.Value')
                        -> orwhereNotNull('Promt.Image')
                        -> select(array('Prod.ID', DB::raw('COUNT(Promt.ID) as PromNumb')))
                        -> groupBy('Prod.ID')
                        -> orderBy('PromNumb', 'desc')
                        -> get();
        \Debugbar::warning("Các sản phẩm thỏa mãn bộ sắp xếp 1 là: ");
        \Debugbar::info($productsDBSorted);
        // code
        break;
      case 2: 
        // code
        break;
      case 3:
        // code
        break;
      case 4: 
        // code
        break;
      case 5:
        // code
        break;
      case 6: 
        // code
        break;
      default:
        break;
      return $productsDBSorted;
    }
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
