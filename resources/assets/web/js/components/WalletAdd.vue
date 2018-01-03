<template>
    <div>
    <el-form ref="form" :inline="true" :model="form" label-width="80px">
        <el-form-item label="币种">
            <el-select v-model="form.coin_type" placeholder="请选择币钟">
                <el-option v-for='(coin, index) in coin_type'
              :key="coin.value"
              :label="coin.label"
              :value="coin.value"
              ></el-option>

            </el-select>
        </el-form-item>
        <el-form-item label="名称">
            <el-input v-model="form.wallet_name"></el-input>
        </el-form-item>
        <el-form-item label="地址">
            <el-input v-model="form.wallet_address"></el-input>
        </el-form-item>
        <el-button type="primary" @click="save_address">添加</el-button>




    </el-form>

    <el-dialog title="安全验证" :visible.sync="dialogFormVisible">
      <el-form :model="form">
        <el-form-item label="手机号" :label-width="formLabelWidth">
            <el-input placeholder="请输入内容" v-model="form.mobile">
                <template slot="append">
                    <el-button type="primary" @click='send_mobile_code'>发送验证码</el-button>
                </template>
              </el-input>
          
        </el-form-item>
        <el-form-item label="验证码" :label-width="formLabelWidth">
          <el-input v-model="form.mobile_code" auto-complete="off"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="save">确 定</el-button>
      </div>
    </el-dialog>
</div>
</template>

<script>


    export default {
         props: {
            coins: {
                type: String,
                default() {
                    return ''
                }
            } 
        },
        data() {
            return {
                coin_type:[],
                coin_lable:'',
                formLabelWidth: '120px',
                dialogFormVisible:false,
                coin_type: 1,
                form: {
                    wallet_name: '',
                    coin_type: 1,
                    wallet_address: '',
                    mobile:'',
                    mobile_code:'',

                }
            }
        },
        mounted(){
            this.coin_type=JSON.parse(this.coins)
           // this.coin_lable=this.coin_type[this.form.coin_type-1].label

        },
        methods: {
            save_address(){
                var _vm=this;
                this.$http.post('/user/safe/check', this.form)
                    .then((response) => {
                        console.log(response)
                        _vm.dialogFormVisible=true;

                     }).catch(({response}) => {
                     
                })
            },
            send_mobile_code(){
                    
                var _vm=this;
                this.$http.post('/sms/send', this.form)
                    .then((response) => {
                        console.log(response)
                        _vm.dialogFormVisible=true;

                     }).catch(({response}) => {
                     
                })
            },
            save() { 
                
                var _vm=this;
                this.$http.post('/user/address', this.form)
                    .then((response) => {
                        var data=response.data;
                        if(data.code==200){
                           _vm.$message.error(data.msg);   
                           window.location.href='/user/wallet'  
                        }else{
                            _vm.$message.error(data.msg);
                        }
                         
                    }).catch(({response}) => {
                    
                })
            }
        }
    }

</script>