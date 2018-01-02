// ad Gold
import Main from '../component/coin/Main';
import CoinType from '../component/coin/CoinType.vue';
import AddCoinType from '../component/coin/AddCoinType.vue';

export default {
  path: 'coin',
  component: Main,
    children: [
        { path: '', component: CoinType },
        { path: 'types/add', component: AddCoinType }

    ],
};
