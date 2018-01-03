<div class="top_monkey">
    <div class="topinfo">

        @forelse($wallets as $wallet)
        <ul>
            <li class="moneyinfo">
                <h3 style="color:#eee;font-size: 14px;font-weight: normal;line-height: 40px;">@if ($wallet->coin_type==1) btc @else ETh @endif 钱包余额：</h3>
                <p class="p_new">可用：<span class="span_new">{{$wallet->can_balance}} </span>
                    </p>
                <p class="p_new">冻结：<span class="span_new span_new1">{{$wallet->block_balance}} </span>
                    </p>
                <p class="p_new">总计：<span class="span_new span_new2">{{$wallet->total_balance}} </span>
                    </p>
            </li>
        </ul>

        @endforeach

        </div>
</div>