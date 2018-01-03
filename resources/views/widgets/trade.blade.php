<div class=" ">
    <div class="usncont">
        <div>
            <div class="change_tab">
                <a href="/trade?trade_type=0"
                   @if(leven('trade_type')==0)
                         class="on_new"
                        @endif>购买</a>
                <a href="/trade?trade_type=1" @if(leven('trade_type')==1)
                        class="on_new"
                        @endif>出售</a>
            </div>
            {{--<div class="select_div">--}}
            {{--<form action="/Trade/index.html" method="get">--}}
            {{--<input type="hidden" name="type" value="1">--}}
            {{--<select id="changeobj" name="obj">--}}
            {{--<option value="1">搜广告</option>--}}
            {{--<option value="2">搜用户</option>--}}
            {{--</select>--}}

            {{--<select name="coin">--}}
            {{--<option value="" selected="">币种</option>--}}
            {{--<option value="3">BTC 比特币</option>--}}
            {{--<option value="4">ETH 以太坊</option>--}}
            {{--</select>--}}
            {{--<select name="loca">--}}
            {{--<option value="" selected="">地区</option>--}}
            {{--<option value="1">CN 中国</option>--}}
            {{--<option value="2">US 美国</option>--}}
            {{--<option value="3">AU 澳大利亚</option>--}}
            {{--<option value="4">JP 日本</option>--}}
            {{--<option value="5">KR 韩国</option>--}}
            {{--<option value="6">CA 加拿大</option>--}}
            {{--<option value="7">FR 法国</option>--}}
            {{--<option value="8">IN 印度</option>--}}
            {{--<option value="9">RU 俄罗斯</option>--}}
            {{--<option value="10">DE 德国</option>--}}
            {{--<option value="11">GB 英国</option>--}}
            {{--<option value="12">HK 香港</option>--}}
            {{--<option value="13">BR 巴西</option>--}}
            {{--<option value="14">ID 印尼</option>--}}
            {{--<option value="15">PH 菲律宾</option>--}}
            {{--</select>--}}
            {{--<select name="curr">--}}
            {{--<option value="" selected="">货币</option>--}}
            {{--<option value="1">CNY 人民币</option>--}}
            {{--<option value="2">USD 美元</option>--}}
            {{--<option value="3">AUD 澳元</option>--}}
            {{--<option value="4">JPY 日元</option>--}}
            {{--<option value="5">KRW 韩币</option>--}}
            {{--<option value="6">CAD 加元</option>--}}
            {{--<option value="7">CHF 法郎</option>--}}
            {{--<option value="8">INR 卢比</option>--}}
            {{--<option value="9">RUB 卢布</option>--}}
            {{--<option value="10">EUR 欧元</option>--}}
            {{--<option value="11">GBP 英镑</option>--}}
            {{--<option value="12">HKD 港币</option>--}}
            {{--<option value="13">BRL 巴西雷亚尔</option>--}}
            {{--<option value="14">IDR 印尼盾</option>--}}
            {{--<option value="15">MXN 比索</option>--}}
            {{--</select>--}}
            {{--<select name="paym">--}}
            {{--<option value="" selected="">支付方式</option>--}}
            {{--<option value="1">现金存款</option>--}}
            {{--<option value="2">银行转账</option>--}}
            {{--<option value="3">支付宝</option>--}}
            {{--<option value="4">微信支付</option>--}}
            {{--<option value="5">iTunes礼品卡</option>--}}
            {{--<option value="6">Paytm</option>--}}
            {{--<option value="7">其它</option>--}}
            {{--</select>--}}

            {{--<div class="search_input" id="userbox" style="display: none;">--}}
            {{--<input type="text" name="uname" value=""--}}
            {{--style="width:672px;height:33px;border: 1px solid #dbdbdb;border-radius: 4px;color: #252525;text-indent: 5px;margin-left: -5px;">--}}
            {{--</div>--}}
            {{--<input type="submit" value="搜索" class="search_trade">--}}
            {{--</form>--}}
            {{--</div>--}}
            <div class="table_trade">
                <table>
                    <tbody>
                    <tr>
                        <th width="180px" style="padding-left:40px;">用户名</th>
                        <th width="100px">币种</th>
                        <th width="100px">地区</th>
                        <th width="250px">信用</th>
                        <th width="150px">支付方式</th>
                        <th width="200px">交易限额</th>
                        <th width="200px">价格</th>
                        <th width="115px">操作</th>
                    </tr>

                    @forelse($adverts as $advert)


                        <tr>
                            <td style="padding-left:40px;"><img
                                        style="height:35px;vertical-align: middle;margin-right:10px;width:35px;border-radius: 50%;"
                                        src="{{asset('images/user_avatar.png')}}">{{$advert->user->name}}</td>
                            <td>{{ $advert->coin_name }}</td>
                            <td>{{$advert->country_code}}</td>

                            <td>
                                交易 0 | 好评度 0% | 信任 0
                            </td>
                            <td>{{$advert->payment_provider}} </td>
                            <td>{{$advert->min_amount}}-{{$advert->max_amount}} CNY</td>
                            <td>{{$advert->price}} CNY</td>
                            <td>

                                {{ link_to_route('site.advert.detail',leven('trade_type')==0? __('site.trade.buy'):__('site.trade.sell'), ['id',$advert->id], ['class' => 'bsedit']) }}

                                {{--<a href="/ad/detail/{{$ad->id}}" class="bsedit">--}}
                                    {{--@if(leven('trade_type')==0)--}}
                                        {{--购买--}}
                                        {{--@else--}}
                                        {{--出售--}}
                                    {{--@endif--}}

                                {{--</a></td>--}}
                        </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
