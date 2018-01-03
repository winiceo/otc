@extends('user.layout')

@section('userright')

    <div class="usnc_right">
        <h1>
            我的信任
            <div class="xr">
                <a class="on" href="/User/trusted.html?type=1">我信任的</a>
                <a href="/User/trusted.html?type=2">我屏蔽的</a>
                <a href="/User/trusted.html?type=3">信任我的</a>
            </div>
        </h1>
        <div class="recharge_list">
            <table>
                <tbody><tr>
                    <th width="150px">用户名</th>
                    <th width="100px">交易次数</th>
                    <th width="100px">信任人数</th>
                    <th width="100px">好评度</th>
                    <!--<th width="100px">历史交易</th>-->
                    <th width="100px">放行时间</th>
                    <th width="100px">与TA交易次数</th>
                </tr>
                <tr>
                    <td>suenli</td>
                    <td>3</td>
                    <td>1</td>
                    <td>0%</td>
                    <!--<td>0 BTC</td>-->
                    <td>0 min</td>
                    <td>0</td>
                </tr><tr>
                    <td>wangyujie123</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0%</td>
                    <!--<td>0 BTC</td>-->
                    <td>0 min</td>
                    <td>0</td>
                </tr>									</tbody></table>
            <div class="pages"> 2 条记录 1/1 页          </div>
        </div>
    </div>
@endsection