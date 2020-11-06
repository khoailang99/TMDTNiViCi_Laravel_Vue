<?php

namespace App\Http\Controllers;

use App\Models\Product\ProductTypeModel;
use App\Models\Product\Product;

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

        $grossProd = $product -> getCountProd();
        $totalPages = ceil($grossProd / $product -> getProdNumbDisplayed());
        $ancentralLevelProdT = $this -> getListProdTAccordTFather(0);

        foreach($ancentralLevelProdT as $prodT) {
            $aSuperPT = new ProductTypeModel($prodT, array());
            $prodTypeT = $this -> getListProdTAccordTFather($prodT->ID);
            foreach($prodTypeT as $prodTT) {
                array_push($aSuperPT -> childLv, new ProductTypeModel($prodTT, $this -> getListProdTAccordTFather($prodTT->ID)));
            }
            array_push($prodTypeList, $aSuperPT);
        }
        \Debugbar::info($prodTypeList);
        \Debugbar::warning('----');
        return view('home', ['prodTypeList' => $prodTypeList, 'listProducts' => $product -> getAllProductsPM(), 'totalProd' => $grossProd, 'totalPages' => $totalPages ]);
    }

    public function getAllProdByPagination(Request $request) {
        $page = $request -> input('page');
        $prodNumbDisplayed = $request -> input('prodNumbDisplayed');
        $product = new Product();
        
        return array("listProducts" => $product -> getProdP($page));
    }

    private function getListProdTAccordTFather($id) {
        return DB::table('ProductCategories') -> where('ParentID', '=', $id) -> orderBy('DisplayOrder', 'asc') -> get() -> toArray();            
    }
}
