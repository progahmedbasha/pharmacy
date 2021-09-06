<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductDate;
use App\Models\Doctor;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

//        dd(session()->get('showModal'));

//        if ()

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()->user_type_id <= 3 ){


            $getProductsWithQTY = ProductDate::where('quantity','<',10)->with('product.item')->get();


//            return $getProductsWithQTY->sum()

            $plusTwoMonth = date('Y-m-d', strtotime(date('Y-m-d'). ' + 2 months'));


            $getProductsWithDate = ProductDate:: whereBetween('expire_date',[date('Y-m-d'),
                $plusTwoMonth])->with('product.item')->get();


            if ($getProductsWithQTY->count() > 0 or $getProductsWithDate->count() > 0){
                $checkModal = 'yes';
            }else{
                $checkModal = 'no';
            }



            return view('admin.dashboard',compact('checkModal','getProductsWithQTY','getProductsWithDate'));
        }
        else{
            $doctor = Doctor::where('user_doctor_id',auth()->user()->id)->first();
            return view('doctor.profile',compact('doctor'));
        }
    }//end fun


    public function getProductsAlarm(){

        $getProductsWithQTY = ProductDate::where('quantity','<=',10)->with('product.item')->get();



        $plusTwoMonth = date('Y-m-d', strtotime(date('Y-m-d'). ' + 2 months'));


        $getProductsWithDate = ProductDate:: whereBetween('expire_date',[date('Y-m-d'),
            $plusTwoMonth])->with('product.item')->orderby('expire_date')->get();




        return view('admin/productsAlarm',compact('plusTwoMonth','getProductsWithDate','getProductsWithQTY'));
    }
}
