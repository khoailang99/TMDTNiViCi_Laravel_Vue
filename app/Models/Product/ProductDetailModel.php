<?php

namespace App\Models\Product;

use App\Models\Category\ProductCategoryModel;
use App\Models\Promotion\PmtDetail_PmtPackage_Model;
use App\Models\Specification\ProductCategoryS_ProductS_Model;

class ProductDetailModel
{
  public $product;
  public $prodType_categories;
  public $pmtDetail_PmtPackage;
  public $PCS_PS;

  // Xem chi tiết sản phẩm 
  public function GetProductsAccordConds($p_prod) { // p: parameters
    $prodCategoryM = new ProductCategoryModel();
    $pmtDetail_PmtPackage_Model = new PmtDetail_PmtPackage_Model();
    $PCS_PS_Model = new ProductCategoryS_ProductS_Model();

    $this -> product = $p_prod;
    $this -> prodType_categories = $prodCategoryM -> ProdType_Categories_PCM($p_prod -> CategoryID, $p_prod -> Category);
    $this -> pmtDetail_PmtPackage = $pmtDetail_PmtPackage_Model -> PmtDetail_PmtPackage_PDPPM($p_prod -> PromotionPackageID);
    $this -> PCS_PS = $PCS_PS_Model -> PCS_PS_PCSPSM($p_prod -> CategoryID, $p_prod -> ID);
  }

  // Lấy các sản phẩm có hoặc không có khuyến mại và hiển thị ở trang chủ phía client
  public function ProductsForHomepage_PDM($p_prod) {
    $pmtDetail_PmtPackage_Model = new PmtDetail_PmtPackage_Model();

    $this -> product = $p_prod;
    $this -> pmtDetail_PmtPackage = $pmtDetail_PmtPackage_Model -> Gift_PDPPM($p_prod -> PromotionPackageID);

  } 
}
