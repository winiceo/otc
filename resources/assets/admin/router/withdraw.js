/**
 * 打赏路由
 */
import Main from '../component/withdraw/Main';
// 打赏统计
import Home from '../component/withdraw/Home';
// 打赏清单
import List from '../component/withdraw/List';

export default {
  path: 'withdraw',
  component: Main,
    children: [
        { path: '', component: Home },
        { path: 'list', component: List },
    ],
};
