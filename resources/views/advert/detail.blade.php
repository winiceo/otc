@extends('layouts.app')

@section('title', $ad->id)
 
 
               
@section('content')
 
 
    <div class=" content">
        <div class="usncont">
            <div class="usnc_right">
                <!-- 上班区域-->
                <div class="usnc_order">
                    <!-- 左边区域-->
                    <div class="ad_left">
                        <div>
                            <div class="user_info">
                                <a href="javascript:void(0)">
                                    <img class="tou" src="{{asset('images/user_avatar.png')}}">
                                </a>
                                <div class="aduser_names">
                                    <span>{{$ad->user->name}}</span>
                                    {{--<span><a href="javascript:;" onclick="chatwindow();"><img src="/Public/Home/news/images/chat.png" style="width: 20px;"></a></span>--}}
                                    {{--<div style="float: right;">--}}
                                        {{--<input class="input2_new" id="trust" type="button" value="取消信任">--}}
                                        {{--<input style="margin-right: 0;" class="input1_new" id="ban" type="button" value="屏蔽此用户">--}}
                                    {{--</div>--}}
                                </div>
                                <div class="poster">
								<span class="infos" style="padding-left: 0;">
									<div style="font-size: 16px;font-weight: bold;text-align: center;">0</div>
									<div>交易次数</div>
								</span>
                                    <span class="infos">
									<div style="font-size: 16px;font-weight: bold;text-align: center;">1</div>
									<div>信任人数</div>
								</span>
                                    <span class="infos">
									<div style="font-size: 16px;font-weight: bold;text-align: center;">0%</div>
									<div>好评度</div>
								</span>
                                    <!--<span class="infos">
                                        <div style="font-size: 16px;font-weight: bold;text-align: center;">0 BTC</div>
                                        <div style="text-align: center;">历史成交</div>
                                    </span>-->
                                    <span class="infos">
									<div style="font-size: 16px;font-weight: bold;text-align: center;">0 min</div>
									<div style="text-align: center;">平均放行时间</div>
								</span>
                                    <div style="float: right;margin-top:15px;">
									<span class="chkemail">
																					<img src="/Public/Home/news/images/success.png">邮箱已验证									</span>

                                        <span class="chkemail">
																					<img src="/Public/Home/news/images/success.png">谷歌已认证									</span>

                                        <span class="chkemail">
																					<img src="/Public/Home/news/images/success.png">身份已验证									</span>

                                        <span class="chkemail">
																					<img src="/Public/Home/news/images/success.png">手机已验证									</span>
                                    </div>
                                </div>
                                <div style="margin-bottom:10px;color:rgba(0,0,0,0.7);font-size: 16px;"><span style="color:#fd634f;margin-right: 4px;">*</span>个人简介: <span style="font-size: 14px;">00</span>							</div>
                            </div>
                        </div>
                        <table class="danz">
                            <tbody><tr>
                                <th>报价:
                                </th><td></td>
                                <td class="price">{{$ad->price}} CNY/BTC</td>
                            </tr>
                            <tr>
                                <th>交易限额:
                                </th><td></td>
                                <td>{{$ad->min_amount}}-{{$ad->max_amount}} CNY</td>
                            </tr>
                            <tr>
                                <th>付款方式:
                                </th><td></td>
                                <td>{{$ad->payment_provider}}</td>
                            </tr>
                            <tr>
                                <th>付款期限:
                                </th><td></td>
                                <td>{{$ad->payment_window_minutes}} 分钟</td>
                            </tr>

                            </tbody></table>
                        <div class="form-cont">

                           

                            <order-create price="{{$ad->price}}" adId="{{$ad->id}}"></order-create>
                            <!-- 购买 -->

                            <div class="ad_right" style="float:left;width:100%;margin-bottom: 35px;">
                                <div class="form-title pt-30" style="margin-bottom: 20px;padding-bottom: 10px;border-bottom:1px solid #d6dbdd;">
                                    <span class="form-name" style="color:rgba(0,0,0,0.7);">交易条款</span>
                                </div>
                                <!-- <hr style="margin-top: 10px;margin-bottom: 20px;"> -->
                                <p class="p mb-20">
                                    2222222222222							</p>
                            </div>

                            <div class="form-title pt-30" style="margin-bottom: 20px;padding-bottom: 10px;border-bottom:1px solid #d6dbdd;">
                                <span class="form-name" style="color:rgba(0,0,0,0.7);">交易须知</span>
                            </div>
                            <div class="line mt-20 mb-20"></div>
                            <p class="p">1.交易前请详细了解对方的交易信息。<br>2.请通过平台进行沟通约定，并保存好相关聊天记录。<br>3.如遇到交易纠纷，可通过申诉来解决问题。<br>4.在您发起交易请求后，币被锁定在托管中，受到BEE Network保护。如果您是买家，发起交易请求后，请在付款周期内付款并把交易标记为付款已完成。卖家在收到付款后将会放行处于托管中的币。<br>5.交易前请阅读《BEE Network服务条款》以及常见问题、交易指南等帮助文档。<br>6.请注意欺诈风险，交易前请检查该用户收到的评价和相关信用信息，并对新近创建的账户多加留意。<br>7.托管服务保护网上交易的买卖双方。在发生争议的情况下，我们将评估所提供的所有信息，并将托管的币放行给其合法所有者。<br></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection