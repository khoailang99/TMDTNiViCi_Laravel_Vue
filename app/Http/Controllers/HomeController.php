<?php

namespace App\Http\Controllers;

use App\Models\Category\ProductCategoryModel;
use App\Models\Product\ProductTypeModel;
use App\Models\Product\Product;
use App\Models\Product\ProductDetailModel;
use App\Models\Specification\ProductCategoryS_ProductS_Model;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $product = new Product();
        $prodTypeList = array();
        // $ancentralLevelProdT = $this -> getListProdTAccordTFather(0);
        // foreach($ancentralLevelProdT as $prodT) {
        //     array_push($prodTypeList, $prodT);
        //     $prodTypeT = $this -> getListProdTAccordTFather($prodT->ID);
        //     foreach($prodTypeT as $prodTT) {
        //         array_push($prodTypeList, $prodTT);
        //         array_push($prodTypeList, ...($this -> getListProdTAccordTFather($prodTT->ID)));
        //     }
        // }

        $ancentralLevelProdT = $this -> getListProdTAccordTFather(0);
        foreach($ancentralLevelProdT as $prodT) {
            $aSuperPT = new ProductTypeModel($prodT, array());
            $prodTypeT = $this -> getListProdTAccordTFather($prodT->ID);
            foreach($prodTypeT as $prodTT) {
                array_push($aSuperPT -> childLv, new ProductTypeModel($prodTT, $this -> getListProdTAccordTFather($prodTT->ID)));
            }
            array_push($prodTypeList, $aSuperPT);
        }

        $products_M = $product -> ProductsHomepage_PM();
        $grossProd = $product -> totalNumbProdDisplayed();
        $totalPages = ceil($grossProd / $product -> getProdNumbDisplayed());

        // $product -> getProds_Category_ProdType();

        \Debugbar::warning("Cac danh muc san pham cap 1!");
        \Debugbar::info($prodTypeList);
        
        return view('home', ['prodTypeList' => $prodTypeList, 'listProducts' => $products_M, 'totalProd' => $grossProd, 'totalPages' => $totalPages ]);
    }

    // Lấy các sản phẩm theo phân trang
    public function getAllProdByPagination(Request $request) {
        $page = $request -> input('page');
        $prodNumbDisplayed = $request -> input('prodNumbDisplayed');
        $product = new Product();
        
        return array("listProducts" => $product -> ProductsHomepage_PM($page));
    }

    private function getListProdTAccordTFather($id) {
        return DB::table('ProductCategories') -> where('ParentID', '=', $id) -> orderBy('DisplayOrder', 'asc') -> get() -> toArray();            
    }

    // Lấy các sản phẩm theo danh mục hoặc loại sp
    public function getProds_Category_ProdType(Request $request) {
        $f_lv = $request -> input('f_lv');
        $pt_c_ID = $request -> input('pt_c_ID');
        $page = $request -> input('page') ? $request -> input('page') : 1;

        \Debugbar::warning("Cac bo loc cua danh muc san pham cap !" );
        \Debugbar::info($f_lv);
        \Debugbar::warning("Ma cac bo loc cua danh muc san pham!" );
        \Debugbar::info($pt_c_ID);
        \Debugbar::warning("Cac bo loc cua danh muc san pham cap !" );
        \Debugbar::info($page);

        $product = new Product();
        return $product -> getProds_Category_ProdType_PM($f_lv, $pt_c_ID, $page);
    }

    // Lấy bộ lọc cho loại sản phẩm
    public function getFilters_Category_ProdType(Request $request) {
        $f_lv = $request -> input('f_lv');
        $pt_c_id = $request -> input('pt_c_id');

        \Debugbar::warning("Cac bo loc cua danh muc san pham cap !".$f_lv." - ".$pt_c_id );
        \Debugbar::info($f_lv);
        
        $pc_M = new ProductCategoryModel();
        $pc_M -> Filter_PCM($f_lv, $pt_c_id);

                
        return $pc_M -> filters;
    }

    public function test() {
        \Debugbar::warning("Xin chao em" );
    }

    // Lấy các sản phẩm theo bộ lọc
    public function getProductsFilter(Request $request) {
        $prodType = $request -> input('prod_type');
        $filters = json_decode($request -> input('filters'));
        $page = $request -> input('page') ? $request -> input('page') : 1;


        $product = new Product();
        return $product -> getProductsFilter_PM($prodType, $filters, $page);
    } 

    public function ProductsHomepage_HC($filteredProds) {
        $products = array();
        foreach($filteredProds as $prod) {
            $prodDetailM = new ProductDetailModel();
            $prodDetailM -> ProductsForHomepage_PDM($prod);
            array_push($products, $prodDetailM);
        }
        return $products;
    }

    // Tìm kiếm sản phẩm
    public function SearchProducts_HC(Request $request) {
        $infoSearch = $request -> input('info_searched');
        $page = $request -> input('page') ? $request -> input('page') : 1;
        // showAll: 0: hiển thị tất cả sản phẩm, 1: Hiển thị 15 sản phẩm 
        $showAll = ($request -> input('show_all')) == 0 ? 15 : 0;
        
        \Debugbar::warning("Thông tin được tìm kiếm: ");
        \Debugbar::info($infoSearch);

        $product = new Product();
        
        return $product -> SearchProducts_PM($showAll, $infoSearch, $page);
    }

    // Sắp xếp sản phẩm
    public function ProdArrangements(Request $request) {
        
    }

    // Xem chi tiết sản phẩm
    public function ProductDetails($prodID) {
        $prodTypeList = array();
        $ancentralLevelProdT = $this -> getListProdTAccordTFather(0);
        foreach($ancentralLevelProdT as $prodT) {
            $aSuperPT = new ProductTypeModel($prodT, array());
            $prodTypeT = $this -> getListProdTAccordTFather($prodT->ID);
            foreach($prodTypeT as $prodTT) {
                array_push($aSuperPT -> childLv, new ProductTypeModel($prodTT, $this -> getListProdTAccordTFather($prodTT->ID)));
            }
            array_push($prodTypeList, $aSuperPT);
        }

        $prodDetailM = new ProductDetailModel();
        $prodDetailM -> GetProductsAccordConds(DB::table('Products as Prod') -> where('Prod.ID', '=', $prodID) -> first());

        \Debugbar::warning("Chi tiết sản phẩm: ");
        \Debugbar::info($prodDetailM);

        return view('product', ['prodDetailM' => $prodDetailM, 'prodTypeList' => $prodTypeList]);
    }

}
