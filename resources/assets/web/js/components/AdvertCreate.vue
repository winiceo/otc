<template>

<el-form ref="form" :model="form" label-width="80px">
   
    <el-form-item label="交易币种">
        <el-select v-model="cryptoCurrency" placeholder="交易币种">
            
            <el-option v-for='(coin, index) in coin_type'
              :key="coin.value"
              :label="coin.label"
              :value="coin.value"
              ></el-option>

        </el-select>
    </el-form-item>

       <el-form-item label="交易类型">
        <el-radio-group v-model="form.trade_type">
            <el-radio label="0">在线出售{{coin_lable}}</el-radio>
            <el-radio label="1">在线购买{{coin_lable}}</el-radio>
        </el-radio-group>
    </el-form-item>

     <el-form-item label="所在国家">
        <el-select v-model="form.country_code" placeholder="所在国家">
            <el-option label="中国" value="btc"></el-option>

        </el-select>
    </el-form-item>

    <el-form-item label="货币">
        <el-select v-model="form.currency" placeholder="货币">
            <el-option label="人民币" value="CNY"></el-option>

        </el-select>
        您希望交易付款的货币类型。
    </el-form-item>

     <el-form-item label="溢价">
        <el-input v-model="form.margin" @change='reset_price' @keyup.native='reset_price'></el-input>
    </el-form-item>

    <el-form-item label="价格">
        <el-input v-model="form.price" :readonly=true></el-input>
    </el-form-item>

    <el-form-item label="最低价">
        <el-input v-model="form.min_price"></el-input>
    </el-form-item>


    <el-form-item label="最小限额">
        <el-input v-model="form.min_amount"></el-input>
    </el-form-item>

      <el-form-item label="最大限额">
        <el-input v-model="form.max_amount"></el-input>
    </el-form-item>

    <el-form-item label="付款期限">
        <el-input v-model="form.payment_window_minutes"></el-input>
    </el-form-item>


     <el-form-item label="收款方式">
        <el-select v-model="form.payment_provider" placeholder="收款方式">
            <el-option label="支付宝" value="CNY"></el-option>
            <el-option label="微信" value="CNY"></el-option>

        </el-select>
    </el-form-item>
 
    
 
    <el-form-item label="广告留言">
        <el-input type="message" v-model="form.desc"></el-input>
    </el-form-item>
    <el-form-item>
        <el-button type="primary" @click="onSubmit">立即创建</el-button>
        <el-button>取消</el-button>
    </el-form-item>
</el-form>
</template>
<script>


    export default {

        props: {
            coins: {
                type: String,
                default() {
                    return ''
                }
            },
            ad:{
                type: String,
                default() {
                    return ''
                }
            }
        },
        data() {
            return {

                cryptoCurrency:1,
                coin_type:[],
                coin_lable:'',
                form: {
                    coin_type: 1,
                    trade_type: "0",
                    country_code: '',
                    currency: '',
                    margin: '',
                    price: '',
                    min_price: '',
                    min_amount: '',
                    max_amount:'',
                    payment_window_minutes:'',
                    payment_provider:'',
                    message:'',
                }
            }
        },
          watch: {
            // 如果 `question` 发生改变，这个函数就会运行
             cryptoCurrency: function (val) {
              
              this.coin_lable=this.coin_type[val-1].label
              this.form.coin_type=val
            }
          },
        computed: {
           
            
        },
        mounted(){
            this.coin_type=JSON.parse(this.coins)
            this.coin_lable=this.coin_type[this.form.coin_type-1].label

        },
        methods: {
            reset_price(){

             var sum = parseFloat(window.App.price)+parseFloat(window.App.price * this.form.margin/100);
              
                this.form.price= sum.toFixed(2);
            },
            onSubmit() {
               this.$http.post('/ad', this.form)
                    .then((response) => {

                   
                       if(response.data.code==200){
                       window.location.href='/trade'
                       }
                        console.log(response)

                        toastr.success('You publish the comment success!')
                    }).catch(({response}) => {
                    //this.isSubmiting = false
                    //stack_error(response)
                })
            }
        }
    }
</script>