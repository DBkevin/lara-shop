@extends("layouts.app")
@section('title','分期付款列表')
@section('content')
    <div class="row">
        <div class="col-10 offset-1">
            <div class="card">
                <div class="card-head text-center"><h2>分期付款列表</h2></div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>编号</th>
                                <th>金额</th>
                                <th>期数</th>
                                <th>费率</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($installments as $installment)
                                
                                <tr>
                                    <td>{{$installment->no}}</td>
                                    <td>${{$installment->total_amount}}</td>
                                    <td>{{$installment->count}}</td>
                                    <td>{{$installment->fee_rate}}</td>
                                    <td>{{\App\Models\Installment::$statusMap[$installment->status]}}</td>
                                    <td><a href="" class=" btn btn-sm btn-primary">查看</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
@endsection