<div class=" ">
    <div class="usncont">
        <div>
            <div class="change_tab">
                <a href="/trade?trade_type=0"
                   <?php if(leven('trade_type')==0): ?>
                         class="on_new"
                        <?php endif; ?>>购买</a>
                <a href="/trade?trade_type=1" <?php if(leven('trade_type')==1): ?>
                        class="on_new"
                        <?php endif; ?>>出售</a>
            </div>
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            

            
            
            
            
            
            
            
            <div class="table_trade">
                <table>
                    <tbody>
                    <tr>
                        <th width="180px" style="padding-left:40px;">用户名</th>
                        <th width="100px">币种</th>
                        <th width="100px">地区</th>
                        <th width="250px">信用</th>
                        <th width="150px">支付方式</th>
                        <th width="200px">交易限额</th>
                        <th width="200px">价格</th>
                        <th width="115px">操作</th>
                    </tr>

                    <?php $__empty_1 = true; $__currentLoopData = $adverts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $advert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


                        <tr>
                            <td style="padding-left:40px;"><img
                                        style="height:35px;vertical-align: middle;margin-right:10px;width:35px;border-radius: 50%;"
                                        src="<?php echo e(asset('images/user_avatar.png')); ?>"><?php echo e($advert->user->name); ?></td>
                            <td><?php echo e($advert->coin_name); ?></td>
                            <td><?php echo e($advert->country_code); ?></td>

                            <td>
                                交易 0 | 好评度 0% | 信任 0
                            </td>
                            <td><?php echo e($advert->payment_provider); ?> </td>
                            <td><?php echo e($advert->min_amount); ?>-<?php echo e($advert->max_amount); ?> CNY</td>
                            <td><?php echo e($advert->price); ?> CNY</td>
                            <td>

                                <?php echo e(link_to_route('site.advert.detail',leven('trade_type')==0? __('site.trade.buy'):__('site.trade.sell'), ['id',$advert->id], ['class' => 'bsedit'])); ?>


                                
                                    
                                        
                                        
                                        
                                    

                                
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
