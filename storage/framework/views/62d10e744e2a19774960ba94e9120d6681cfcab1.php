<?php $__env->startSection('content'); ?>
    <div class="usernewout">
        <div class="usncont">
            <div>
                <div class="change_tab">
                    <a href="/user/orders?status=1" class="on_new">进行中的交易</a>

                    <a href="/user/orders?status=2">完成的交易</a>
                </div>

                <div class="table_trade" style="min-height:750px;height: auto;">
                    <table>
                        <tbody><tr>
                            <th width="50px" style="padding-left: 30px;"></th>
                            <th width="200px">交易伙伴</th>
                            <th width="230px">订单编号</th>
                            <th width="100px">类型</th>
                            <th width="170px">交易金额</th>
                            <th width="170px">交易数量</th>
                            <th width="190px">创建时间</th>
                            <th width="115px">交易状态</th>
                            <th width="115px">交易操作</th>
                        </tr>

                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="bg_change">
                            <td style="padding-left: 30px;">
                                <div style="width:100%;height:100%;position:relative;">
                                    <span class="chattips" id="ct_66" data="66" type="1"></span>
                                    <span class="chattrigger" data="1" id="1" style="margin-top: -5px;">
										<img src="/Public/Home/news/images/chat.png" style="width: 18px;">
										<img src="/Public/images/downdown.png" style="margin-left: 3px;">
									</span>
                                </div>
                            </td>
                            <td>
                                
                            <td>
                                <a href="/order/info/<?php echo e($order->id); ?>" style="color:#108ee9;">
                                    <?php echo e($order->order_code); ?>									</a>
                            </td>
                            <td>

                                    <?php if(leven('trade_type')==0): ?>
                                        购买
                                    <?php else: ?>
                                        出售
                                    <?php endif; ?>



                            </td>
                            <td><?php echo e($order->amount); ?></td>
                            <td><?php echo e($order->qty); ?></td>
                            <td><?php echo e($order->created_at); ?></td>
                            <td><?php echo e($order->status); ?></td>
                            <td>
                                						                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>
                    </table>
                    <?php echo e($orders->links('pagination.default')); ?>

                       </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>