<?php

namespace App\Exports;

use App\Models\SaleBill;
// use Maatwebsite\Excel\Concerns\FromCollection;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SaleBillsExport implements FromView
{


    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return SaleBill::paginate(10);
    // }
    public function view(): View
    {

    	
        return view('admin/exports/salebill_export', [
            'bills' =>SaleBill::with('user')->with('customer')->get(),
            // 'total_final'  => Product::sum('sale_price') 

        ]);
    }
}
