<style lang="css" module>
    .image {
        max-width:200px;
        margin-bottom: 10px;
    }
    .help-block {
      font-size: 12px !important;
    }
</style>

<template>
<div class="container-fluid" style="margin-top:15px;">
    <div class="panel panel-default">
      <div class="panel-heading">
        站点配置
      </div>
      <div class="panel-body">
        <div class="form-horizontal">
          <loading :loadding="loadding"></loading>
          <div v-show="!loadding">


            <div class="form-group">
              <label class="control-label col-md-2">预留呢称</label>
              <div class="col-md-6">
                <input type="text" class="form-control" v-model="site.reserved_nickname">
              </div>
              <div class="col-md-4">
                <span class="help-block">预留呢称，多个呢称用英文半角符号","分割</span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">客户邮箱</label>
              <div class="col-md-6">
                <input type="text" class="form-control" v-model="site.client_email">
              </div>
              <div class="col-md-4">
                <span class="help-block">客户邮箱</span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">用户邀请模版</label>
              <div class="col-md-6">
                <textarea class="form-control" v-model="site.user_invite_template">
                </textarea>
              </div>
              <div class="col-md-4">
                <span class="help-block">用户邀请模版</span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2">关于我们</label>
              <div class="col-md-6">
                <input type="text" class="form-control" v-model="site.about_url" placeholder="例如: http://www.about.com">
                </textarea>
              </div>
              <div class="col-md-4">
                <span class="help-block">关于我们链接地址</span>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2"></label>
              <div class="col-md-6">
                <button class="btn btn-primary btn-block" 
                @click.prevent="updateSiteConfigure" 
                data-loading-text="提交中" 
                autocomplete="off" id="submit-btn">确认</button>
              </div>
              <div class="col-md-4">
                 <span class="text-success"  v-show="message.success">{{ message.success }}</span>
                 <span class="text-danger" v-show="message.error">{{ message.error }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</template>
<script>
import request, { createRequestURI } from '../../util/request';
import PlusMessageBundle from 'plus-message-bundle';
const Site = {
    
    data: () => ({
        loadding: true,
        radio: {
          on: true,
          off: false,
        },
        site: {
          gold: {
            status: true,
          },
          reward: {
            status: true,
            amounts: '',
          },
          reserved_nickname: '',
          client_email: '',
          user_invite_template: '',
          anonymous: {
            status: false,
            rule: ''
          },
          about_url:null,
        },
        message: {
          error: null,
          success: null,
        }
    }),
    methods: {
      getSiteConfigures () {
        this.loadding = true;
        request.get(createRequestURI('site/configures'), {
          validateStatus: status => status === 200,
        }).then(({ data = {} }) => {
          this.loadding = false;
          this.site = { ...this.site, ...data };
        }).catch(({ response: { data = { message: '加载站点配置失败' } } = {} }) => {
          this.loadding = false;
          this.message.error = (new PlusMessageBundle).getMessage();
        });
      },
      updateSiteConfigure () {
        $("#submit-btn").button('loading');
        request.put(
          createRequestURI('update/site/configure'),
          { site: this.site },
          { validateStatus: status => status === 201 }
        ).then(({ data: { message: [ message ] = [] } }) => {
          $("#submit-btn").button('reset');
          this.message.success = message;
        }).catch(({ response: { data = {} } = {} }) => {
          let Message = new PlusMessageBundle(data);
          this.message.error = Message.getMessage();
        });
      },
      validate () {
        let site = this.site;
        return (site.status && !site.off_reason) ? false : true;
      },
    },
    created () {
      this.getSiteConfigures();
    },
};
export default Site;
</script>