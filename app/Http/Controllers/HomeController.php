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

        $product -> getProds_Category_ProdType();

        \Debugbar::warning("Cac danh muc san pham cap 1!");
        \Debugbar::info($prodTypeList);
        
        return view('home', ['prodTypeList' => $prodTypeList, 'listProducts' => $products_M, 'totalProd' => $grossProd, 'totalPages' => $totalPages ]);
    }

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
    public function getProds_Category_ProdType() {
        $level = 2;
        $c_pt_ID = 65;
        if($level == 1) { // Loại sản phẩm cấp 1 

        }else if($level == 3) { // Danh mục or loại sản phẩm cấp 3

        }else { // Danh mục or loại sản phẩm cấp 2

        }
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

    // Lấy các sản phẩm theo bộ lọc
    public function getProductsFilter(Request $request) {
        $prodType = $request->input('prod_type');
        $filters = json_decode($request->input('filters'));

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
                $prodDetailM = new ProductDetailModel();
                $prodDetailM -> ProductsForHomepage_PDM($prod);
            });

            \Debugbar::warning("Các sản phẩm cuối cùng sau khi lọc và bộ lọc >= 2!");
            \Debugbar::info($productsFiltered);
            return $this -> ProductsHomepage_HC($productsFiltered);
        }
        \Debugbar::warning("Các sản phẩm thỏa mãn bộ lọc 1 là: ");
        \Debugbar::info($products);

        return $this -> ProductsHomepage_HC($products);
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

    public function demoTest() {
        return view("productCategory");
    }
}
