<template>

    <div>
        <div class="form-title">
            <span class="form-name">你想出售多少？ </span>
            <span class="form-name"></span>
        </div>

        <span class="icon-equal"></span>
        <el-row :gutter="20">
            <el-col :span="10">

                <el-input placeholder="输入您想出售的金额" v-model="form.amount" @change="change_amount"
                          @keyup.native="change_amount">
                    <template slot="append">CNY</template>
                </el-input>
            </el-col>
            <el-col :span="4">
                《=》

            </el-col>
            <el-col :span="10">
                <el-input placeholder="输入您想出售的比特币" v-model="form.qty" @change="change_qty" @keyup.native="change_qty">
                    <template slot="append">BTC</template>
                </el-input>

            </el-col>

        </el-row>

        <el-row :gutter="20">
            <el-col :span="24">
                <el-input v-model="form.order_desc"></el-input>

            </el-col>


        </el-row>


        <el-button type="primary" @click="onSubmit">立即购买</el-button>
    </div>

</template>
<style>
    .el-row {
        margin-bottom: 20px;

    }

    .el-col {
        border-radius: 4px;
    }

    .bg-purple-dark {
        background: #99a9bf;
    }

    .bg-purple {
        background: #d3dce6;
    }

    .bg-purple-light {
        background: #e5e9f2;
    }

    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }

    .row-bg {
        padding: 10px 0;
        background-color: #f9fafc;
    }
</style>
<script>


    export default {
        props: {
            price: {
                type: String,
                default() {
                    return ''
                }
            },
            adId: {
                type: String,
                default() {
                    return ''
                }
            }
        },
        data() {
            return {
                form: {

                    qty: '',
                    amount: '',
                    order_desc: '',

                }

            }
        },

        watch: {
//            'form.amount': function(val, oldVal){
//                this.change_amount();
//            },
//            'form.qty': function(val, oldVal){
//                this.change_qty();
//            }
        },
        mounted() {


        },
        created() {

        },
        methods: {

            change_amount() {
                var amount = this.form.amount.toString();
                if (amount.indexOf(".") != "-1") {
                    var barr = amount.split(".");
                    var xiaoshu = barr[1].length;
                    if (xiaoshu > 2) {
                        var org = barr[1].substr(0, xiaoshu - 1);
                        var xin = parseFloat(barr[0] + "." + org);
                        this.form.amount = xin;
                        // $("#amount"+type).val(xin);
                    }
                }

                //转换成比特币 需要保留八位小数
                var btcnum = (this.form.amount / this.price).toFixed(10);
                btcnum = this.getnum(btcnum, 8);
                this.form.qty = btcnum;


            },

            change_qty() {
                var qty = this.form.qty.toString();
                if (qty.indexOf(".") != "-1") {
                    var barr = qty.split(".");
                    var xiaoshu = barr[1].length;
                    if (xiaoshu > 8) {
                        var org = barr[1].substr(0, xiaoshu - 1);
                        var xin = parseFloat(barr[0] + "." + org);
                        this.form.qty = xin

                    }
                }

                //转换成比特币 需要保留八位小数
                var btcnum = (this.form.qty * this.price).toFixed(4);
                btcnum = this.getnum(btcnum, 2);
                this.form.amount = btcnum


            },
            getnum(num, ss) {
                if (num.indexOf(".") != "-1") {
                    var barr = num.split(".");
                    var org = barr[1].substr(0, ss);
                    var xin = parseFloat(barr[0] + "." + org);
                    return xin;
                }
            },


            onSubmit() {
                this.form.ad_id = App.ad.id;

                this.$http.post('/order', this.form)
                    .then((response) => {
                        var data = response.data;
                        console.log(data)

                        if (data.code ==200) {
                            this.$message(data.msg);
                             window.location.href = '/order/info/' + data.data.order.id;
                        }else{
                            this.$message(data.msg);
                        }


                        //


                    }).catch(({response}) => {

                })
            }
        }
    }

</script>