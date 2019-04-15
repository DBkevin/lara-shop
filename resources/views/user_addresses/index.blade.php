@extends('layouts.app')
@section('title','收货地址详情')

@section("content")
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card panel-default">
                <div class="card-header">
                    收货地址列表
                    <a href="{{ route('user_addresses.create') }}" class="float-right">新增收货地址</a>
                </div>
                <div class="card-body">
                    <table class="table-bordered table table-striped">
                        <thead>
                            <tr>
                                <td>收货人</td>
                                <td>地址</td>
                                <td>邮编</td>
                                <td>电话</td>
                                <td>操作</td>
                            </tr>
                        </thead>
                        @foreach ($addresses as $item)
                            <tr>
                                <td>{{ $item->contact_name }}</td>
                                <td>{{ $item->full_address }}</td>
                                <td>{{ $item->zip }}</td>
                                <td>{{ $item->contact_phone }}</td>
                                <td>
                                    <button class="btn-primary btn">修改</button>
                                    <button class="btn-danger btn"> 删除</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

            </div>

        </div>
    </div>
@stop