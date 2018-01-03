@extends('layouts.app')

@section('content')
    <div class="usernewout">
        <div class="usncont">
            <div>
                <div class="change_tab">
                    <a href="/user/orders?status=1" class="on_new">进行中的交易</a>

                    <a href="/user/orders?status=2">完成的交易</a>
                </div>

                <div class="table_trade" style="min-height:750px;height: auto;">
                    <table>
                        <tbody><tr>
                            <th width="50px" style="padding-left: 30px;"></th>
                            <th width="200px">交易伙伴</th>
                            <th width="230px">订单编号</th>
                            <th width="100px">类型</th>
                            <th width="170px">交易金额</th>
                            <th width="170px">交易数量</th>
                            <th width="190px">创建时间</th>
                            <th width="115px">交易状态</th>
                            <th width="115px">交易操作</th>
                        </tr>

                        @forelse($orders as $order)
                        <tr class="bg_change">
                            <td style="padding-left: 30px;">
                                <div style="width:100%;height:100%;position:relative;">
                                    <span class="chattips" id="ct_66" data="66" type="1"></span>
                                    <span class="chattrigger" data="1" id="1" style="margin-top: -5px;">
										<img src="/Public/Home/news/images/chat.png" style="width: 18px;">
										<img src="/Public/images/downdown.png" style="margin-left: 3px;">
									</span>
                                </div>
                            </td>
                            <td>
                                <img style="height:35px;vertical-align: middle;margin-right:10px;width:35px;border-radius: 50%;" src="{{$order->advertiser->avatar}}">{{$order->advertiser->name}}							</td>
                            <td>
                                <a href="/order/info/{{$order->id}}" style="color:#108ee9;">
                                    {{$order->order_code}}									</a>
                            </td>
                            <td>

                                    @if(leven('trade_type')==0)
                                        购买
                                    @else
                                        出售
                                    @endif



                            </td>
                            <td>{{$order->amount}}</td>
                            <td>{{$order->qty}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->status}}</td>
                            <td>
                                						                            </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                    {{ $orders->links('pagination.default') }}
                       </div>
                </div>
            </div>
        </div>
    </div>
@endsection
