<?php

namespace App\Models\Category;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use App\Models\Specification\PmtDetail_PmtPackage_Model;
use App\Models\Promotion\ProductCategoryS_ProductS_Model;

class ProductCategoryModel
{
  public $filters = array();

  public function ProdType_Categories_PCM($p_prodType = 1, $p_category = ",55,65,66,67,68,72,77,80,") {
    // $arr_prodType_categories = array();
    $arr_category = explode(",", substr($p_category, 1, strlen($p_category) - 2));
    return DB::table('ProductCategories') -> whereIn('ID', $arr_category) -> get();
  }

  public function Filter_PCM($pt_c_level, $pt_c_id) {
    // $pt_c_level = 2;
    // $pt_c_id = 53;

    if($pt_c_level == 1) { // Loại sản phẩm cấp 1
      $this -> PrimaryFilter_PCM($pt_c_id); 
      return;
    }
    
    $pt_c_detail = DB::table('ProductCategories as PC') -> where('PC.ID', $pt_c_id) -> first();
    
    if($pt_c_level == 3) { // Loại sản phẩm hoặc danh mục cấp 3
      $this -> TertiaryFilter_PCM($pt_c_id, explode(',', $pt_c_detail -> Relationship));
      return;
    }
    
    if($pt_c_detail -> IsCategory) {
      $this -> PrimaryFilter_PCM($pt_c_detail -> ParentID); 
      return;
    }
    $this -> SecondaryFilter_PCM($pt_c_id, $pt_c_detail -> ParentID); // Loại sản phẩm hoặc danh mục cấp 2

  }

  public function PrimaryFilter_PCM($id) {
    $listPrimaryFilterName = DB::table('ProductCategories as PC')
                      -> join('PCSpecifications as PCS', function($join){
                        $join -> on('PC.ID', '=', 'PCS.ProductCategoriesID')
                              -> where('PCS.Status',1)
                              -> where('PCS.IsDeleted',0)
                              -> where('PCS.IsFilter',1)
                              -> whereIn('PCS.FilterUpperLevel', [0,1,3]); // 1: 1 bộ lọc đc hiển thị trên cấp 1, 3: 1 bộ lọc hiển thị ở cấp 1, 2
                      })
                      -> where('PC.ID', $id)
                      -> orWhere('PC.Relationship', 'like', '%,'.$id.',%')
                      -> orderBy('PCS.ProductCategoriesID','asc')
                      -> select('PCS.ID', 'PCS.Name')
                      -> get();
    \Debugbar::warning('anh sách tên bộ lọc cấp 1!');                    
    \Debugbar::info($listPrimaryFilterName);
    
    $this -> FilterValue_PCM($listPrimaryFilterName, $id);
  }

  public function SecondaryFilter_PCM($pt_c_id, $father_id) {
    $secondLFilterNameList = DB::table('ProductCategories as PC')
                      -> join('PCSpecifications as PCS', function($join){
                        $join -> on('PC.ID', '=', 'PCS.ProductCategoriesID')
                              -> where('PCS.Status',1)
                              -> where('PCS.IsDeleted',0)
                              -> where('PCS.IsFilter',1);
                      })
                      -> where('PC.ID', $pt_c_id)
                      -> orWhere('PC.ParentID', $pt_c_id) -> whereIn('PCS.FilterUpperLevel', [2,3]) // 2: 1 bộ lọc đc iển thị ở cấp 2
                      -> orWhere('PC.ID', $father_id) -> where('PCS.IsGeneralInfo', 1)
                      -> orderBy('PCS.ProductCategoriesID','asc')
                      -> select('PCS.ID', 'PCS.Name')
                      -> get();
      
    \Debugbar::warning('danh sách tên bộ lọc cấp 2!');                    
    \Debugbar::info($secondLFilterNameList); 
    
    $this -> FilterValue_PCM($secondLFilterNameList, $pt_c_id);
  }

  public function TertiaryFilter_PCM($pt_c_id, $relationalArr) {
    $listThirdLFilterName = DB::table('ProductCategories as PC')
                      -> join('PCSpecifications as PCS', function($join){
                        $join -> on('PC.ID', '=', 'PCS.ProductCategoriesID')
                              -> where('PCS.Status',1)
                              -> where('PCS.IsDeleted',0)
                              -> where('PCS.IsFilter',1);
                      })
                      -> where('PC.ID', $pt_c_id)
                      -> orWhereIn('PC.ID', $relationalArr) -> where('PCS.IsGeneralInfo', 1)
                      -> orderBy('PCS.ProductCategoriesID','asc')
                      -> select('PCS.ID', 'PCS.Name')
                      -> get();
    
    \Debugbar::warning('danh sách tên bộ lọc cấp 3!');                    
    \Debugbar::info($listThirdLFilterName);  

    $this -> FilterValue_PCM($listThirdLFilterName, $pt_c_id);
  }

  public function FilterValue_PCM($listPrimaryFilterName, $pt_c_id) {
    foreach($listPrimaryFilterName as $filterName) {
      $filterResult = DB::table('ProductCategories as PC') 
                      -> where('PC.Relationship','like','%,'.$pt_c_id.',%')
                      -> join('Products as Prod', 'Prod.CategoryID', '=', 'PC.ID')
                      -> join('Product_Specifications as PS', 'Prod.ID', '=', 'PS.ProductID')
                      -> whereNotNull('PS.Value')
                      -> where('PS.SpecificationID', $filterName -> ID) 
                      -> select('PS.Value')
                      -> distinct() 
                      -> get();
      if($filterResult -> count() == 0) { 
        continue;
      } 
      array_push($this -> filters, new FilterModel($filterName, $filterResult));
    }
    
    \Debugbar::warning('anh sách kết quả bộ lọc cấp 1!');                    
    \Debugbar::info($this -> filters);
  }

}

class FilterModel {
  function __construct($filterName, $filterValues) {
    $this -> filterName = $filterName;
    $this -> filterValues = $filterValues;
  }

  public $filterName;
  public $filterValues;
}
