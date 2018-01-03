@extends('layouts.app')

@section('content')


    <div class="container">
        <div class=" ">
            <div class="usncont">
                <div class="usnc_right">
                    <h1>创建一个广告</h1>
                    <div class="leftmoney">
                        如果您经常交易虚拟币，可以发布自己的虚拟币交易广告。
                        <br>如果您只想购买或出售一次，我们建议您直接从购买或出售列表中下单交易。
                        <br>
                        发布一则交易广告是免费的。
                        <br>
                        发布交易广告的 BEE Network 用户每笔完成的交易需要缴纳 0.5% 的费用。<br>
                        您必须在交易广告或交易聊天中提供您的付款详细信息，发起交易后，价格会锁定，除非定价中有明显的错误。<br>
                        所有交流必须在 BEE Network 上进行，请注意高风险有欺诈风险的付款方式。<br>
                        <a href="/User/nameauth.html" style="color:#108ee9;">身份验证</a>成功后您的广告才会显示在交易列表中。
                    </div>



                    <advert-create coins='@json($coins)'></advert-create>


                </div>
            </div>
        </div>    </div>
@endsection

@section('scripts')
<script type="text/javascript">



</script>
@endsection

@section('styles')
<style>
    .dicussion {
        margin-top: 40px;
    }
</style>
@endsection
