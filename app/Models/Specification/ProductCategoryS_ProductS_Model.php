<?php

namespace App\Models\Specification;

use Illuminate\Support\Facades\DB;

class ProductCategoryS_ProductS_Model
{
  private $PCSModel;
  private $PSModel;

  /**
   * Get the value of PCSModel
   */ 
  public function getPCSModel()
  {
    return $this->PCSModel;
  }

  /**
   * Set the value of PCSModel
   *
   * @return  self
   */ 
  public function setPCSModel($PCSModel)
  {
    $this->PCSModel = $PCSModel;

    return $this;
  }

  /**
   * Get the value of PSModel
   */ 
  public function getPSModel()
  {
    return $this->PSModel;
  }

  /**
   * Set the value of PSModel
   *
   * @return  self
   */ 
  public function setPSModel($PSModel)
  {
    $this->PSModel = $PSModel;

    return $this;
  }

  public function PCS_PS_PCSPSM($p_prodTypeID, $p_prodID) {
    $pcs_ps = DB::table('PCSpecifications as pcs') -> where('ProductCategoriesID', $p_prodTypeID)
                -> join('Product_Specifications as ps', 'pcs.ID', '=', 'ps.SpecificationID')
                -> where('ps.ProductID', $p_prodID) -> whereNotNull('ps.Value') -> where('ps.Status',1)
                -> select('pcs.ID', 'pcs.Name', 'ps.Value', 'pcs.TypeSpecifications', 'pcs.IsGeneralInfo', 'pcs.IsGeneralInfo', 'pcs.ParentID')
                -> orderBy('pcs.TypeSpecifications','asc')
                -> orderBy('pcs.ID') -> get();

    \Debugbar::warning("Đây là danh sách thông số kĩ thuật");
    \Debugbar::info($pcs_ps);
    return $pcs_ps;
  }
}
