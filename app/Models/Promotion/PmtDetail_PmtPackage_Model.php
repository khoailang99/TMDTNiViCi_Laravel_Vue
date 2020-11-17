<?php

namespace App\Models\Promotion;

use Illuminate\Support\Facades\DB;

class PmtDetail_PmtPackage_Model
{
  public $pmtPackage;
  public $pmtDetail;

  // Lấy gói khuyến mại và danh sách các gói khuyến mại
  public function PmtDetail_PmtPackage_PDPPM($p_pmtPackageID)
  {
    $promotions = DB::table('PromotionDetails')
                    -> where('ProPackageID', $p_pmtPackageID)
                    -> join('Promotions', 'PromotionDetails.PromotionID', '=', 'Promotions.ID')
                    -> get();
    
    $this -> pmtPackage = DB::table('PromotionPackages') -> where('ID', $p_pmtPackageID) -> first();
    $this -> pmtDetail = $promotions;

    \Debugbar::warning("Đây là gói danh sach km");
    \Debugbar::info($this -> pmtDetail); 
    return $this;  
  }

  // Lấy các quà tặng cho sản phẩm tương ứng
  public function Gift_PDPPM($p_pmtPackageID) {
    $gifts = DB::table('PromotionDetails as pd')
                    -> where('ProPackageID', $p_pmtPackageID)
                    -> join('Promotions as p', 'pd.PromotionID', '=', 'p.ID')
                    -> whereNotNull('p.Image') -> select('p.Name', 'p.Image')
                    -> where('p.Amount','>',0) -> where('p.Status','<>',1) -> where('p.IsDeleted','<>',1)
                    -> get();

    $this -> pmtDetail = $gifts;
    return $this;   
  }
}
