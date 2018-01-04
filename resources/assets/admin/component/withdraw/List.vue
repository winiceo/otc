<template>
    <div class="container-fluid" style="margin:15px;">
        <div v-show="message.success" class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ message.success }}
        </div>
        <div v-show="message.error" class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ message.error }}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
              <div class="form-inline">
                <!-- 关键词 -->
                <div class="form-group">
                  <input type="text" class="form-control" v-model="filter.keyword" placeholder="提现用户名/ID">
                </div>
                <!-- 类型 -->
                <div class="form-group">
                  <select class="form-control" v-model="filter.type">
                    <option v-for="type in withdraw_types" :value="type.name">{{ type.alias }}</option>
                  </select>
                </div>
                <!-- 时间段 -->
                <div class="form-group">
                  <div class="input-group">
                    <input type="date" class="form-control" v-model="filter.start">
                    <div class="input-group-addon">-</div>
                    <input type="date" class="form-control" v-model="filter.end">
                  </div>
                </div>
                <!-- 搜索 -->
                <div class="form-group">
                  <router-link class="btn btn-default" tag="button" :to="{ path: '/withdraw/list', query: searchQuery }">
                    搜索
                  </router-link>
                </div>
                <!-- 导出 -->
                <a :href="exportUrl" class="btn btn-success">导出</a>
              </div>
            </div>
            <!-- 添加广告 -->
            <div class="panel-body">
              <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>提现用户</th>
                            <th>提现币种</th>
                            <th>提现金额</th>
                            <th>提现地址</th>
                            <th>提现时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- 加载 -->
                        <table-loading :loadding="loadding" :colspan-num="6"></table-loading>
                        <tr v-for="withdraw in withdraws">
                          <td>{{ withdraw.id }}</td>
                          <td>{{ withdraw.user.name }}</td>
                          <td>{{ withdraw.coin.name }}</td>
                          <td>{{ withdraw.amount  }}</td>
                          <td>{{ withdraw.address }}</td>

                          <td>{{ withdraw.created_at | localDate }}</td>
                        </tr>
                    </tbody>
                </table>
                <!-- 分页 -->
                <div class="text-center">
                  <offset-paginator class="pagination" :total="total" :offset="offset" :limit="15">
                    <template slot-scope="pagination">
                      <li :class="(pagination.disabled ? 'disabled': '') + (pagination.currend ? 'active' : '')">
                        <span v-if="pagination.disabled || pagination.currend">{{ pagination.page }}</span>
                        <router-link v-else :to="offsetPage(pagination.offset)">{{ pagination.page }}</router-link>
                      </li>
                    </template>
                  </offset-paginator>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import request, { createRequestURI } from '../../util/request';
import { plusMessageFirst } from '../../filters';

const ListComponent = {
    data: () => ({
      loadding: false,
      withdraws: [],
      total: 0,
      filter: {
        type: '',
        start: '',
        end: '',
        keyword: '',
      },
      message: {
        error: null,
        success: null,
      },
      withdraw_types: [
        { name: '', alias: '全部' },
        { name: 'feeds', alias: '动态提现' },
        { name: 'news', alias: '资讯提现' },
        { name: 'users', alias: '用户提现' },
        { name: 'question-answers', alias: '问答提现' },
      ],
    }),
    computed: {
      exportUrl () {
        return '/admin/withdraws/export?export_type=list' + $.param(this.filter);
      },
      offset () {
        const { query: { offset = 0 } } = this.$route;
        return parseInt(offset);
      },
      searchQuery () {
        return { ...this.filter, offset: 0 };
      },
    },
    watch: {
      '$route': function ($route) {
        this.total = 0;
        this.getRewards({ ...$route.query });
      },
    },
    methods: {
      getRewards (query = {}) {
        this.withdraws = {};
        this.loadding = true;
        request.get(
          createRequestURI('withdraws'),
          { 
            validateStatus: status => status === 200,
            params: { ...query, limit: 15 },
          },
        ).then(({ data = [], headers: { 'x-withdraw-total': total } }) => {
          this.loadding = false;
          this.total = parseInt(total);
          this.withdraws = data;
        }).catch(({ response: { data: { errors = ['加载失败'] } = {} } = {} }) => {
          this.loadding = false;
          this.message.error = plusMessageFirst(errors);
        });
      },
      offsetPage(offset) {
        return { path: '/withdraw/list', query: { ...this.filter, offset } };
      },
    },
    created () {
      this.getRewards(this.$route.query);
    },
};
export default ListComponent;
</script>

