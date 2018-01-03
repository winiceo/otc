<template>
    <el-container>
            adfafd
    </el-container>

</template>

<script>

    const now = new Date();


    export default {
        data() {
            return {
                
            }
        },
         
        computed: {
          
        },
        created() {
              
            var _vm = this;
            this.callbacks = {

                 
                receiveNewMessage: function (message) {
                    //console.log(message)
                    //alert([message.content.extra.order_id,_vm.order.id])
                    // var chatcontent = "";
                    if (message.content.extra.order_id != _vm.order.id) {
                        return false;
                    }
                    alert(message)
                },

                getInstance: function (ist) {
                    _vm.instance = ist;
                    
                    return ist
                }
            }


            BeeChat.init(this.callbacks)
           

        },
        methods: { 

             
        }
    }

</script>