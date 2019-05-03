<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Installment;

class InstallmentsController extends Controller
{
    //

    public function index(Request $request){
        $installments=Installment::query()
            ->where('user_id',$request->user()->id)
            ->paginate(10);
        return  view('installments.index',compact('installments'));
    }

    public function show(Installment $installment){
        $this->authorize('own',$installment);
        //取出当前的还款计划,并按还款排序
        $items=$installment->items()->orderBy('sequence')->get();
        return view('installments.show',[
            'installment'=>$installment,
            'items'=>$items,
            'nextItem'=>$items->where('paid_at',null)->first(),
        ]);
    }
}
