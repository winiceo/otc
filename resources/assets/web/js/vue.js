window.Vue = require('vue');


import httpPlugin from 'plugins/http';

import Element from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'


Vue.config.productionTip = false;

Vue.component('comment', require('components/comments/Comment.vue'));
Vue.component('comment-list', require('components/comments/Comment-list.vue'));
Vue.component('comment-form', require('components/comments/Comment-form.vue'));

Vue.component('like', require('components/Like.vue'));

//
// Vue.component('avatar', require('components/AvatarUpload.vue'));
// Vue.component('wallet-add', require('./components/WalletAdd.vue'));

Vue.component('advert-create', require('./components/AdvertCreate.vue'));
// Vue.component('order-create', require('./components/OrderCreate.vue'));
//
// Vue.component('edit-create', require('./views/web/ad/edit.vue'));
//
// Vue.component('notice', require('./components/Notice.vue'));


import VueTimeago from 'vue-timeago'

Vue.use(VueTimeago, {
    name: 'timeago', // component name, `timeago` by default
    locale: 'zh-TW',
    locales: {
        // you will need json-loader in webpack 1
        'zh-TW': require('vue-timeago/locales/zh-TW.json')
    }
})
Vue.use(Element)
Vue.use(httpPlugin);

window.Event = new Vue();

const app = new Vue({
  el: '#app',

  mounted() {
    $('[data-confirm]').on('click', function () {
      return confirm($(this).data('confirm'))
    })
  }
});
