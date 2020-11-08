<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;

use App\Models\Specification\PmtDetail_PmtPackage_Model;
use App\Models\Promotion\ProductCategoryS_ProductS_Model;

class ProductCategoryModel extends Model
{
  protected $table = 'ProductCategories';

  public function ProdType_Categories_PCM($p_prodType = 1, $p_category = ",55,65,66,67,68,72,77,80,") {
    // $arr_prodType_categories = array();
    $arr_category = explode(",", substr($p_category, 1, strlen($p_category) - 2));
    return ProductCategoryModel::whereIn('ID', $arr_category) -> get();
  }
}
