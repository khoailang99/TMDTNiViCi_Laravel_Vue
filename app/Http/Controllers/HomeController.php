<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use App\Models\Product;

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
            $aSuperPT = new ProductType($prodT, array());
            $prodTypeT = $this -> getListProdTAccordTFather($prodT->ID);
            foreach($prodTypeT as $prodTT) {
                array_push($aSuperPT -> childLv, new ProductType($prodTT, $this -> getListProdTAccordTFather($prodTT->ID)));
            }
            array_push($prodTypeList, $aSuperPT);
        }
        \Debugbar::info($prodTypeList);
        \Debugbar::warning('----');
        return view('home', ['prodTypeList' => $prodTypeList, 'listProducts' => $product -> getAllProductsPM() ]);
    }

    public function getAllProductHC() {
        $product = new Product();
        $x = $product -> getAllProductsPM();
        \Debugbar::info($x);
        \Debugbar::warning('---------------');
        return view('Demo', ['productList' => $x]);
    }

    private function getListProdTAccordTFather($id) {
        return DB::table('ProductCategories') -> where('ParentID', '=', $id) -> orderBy('DisplayOrder', 'asc') -> get() -> toArray();            
    }
}
