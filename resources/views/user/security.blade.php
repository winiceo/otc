@extends('user.layout')

@section('userright')

    <div class="usnc_right">
        <h1>安全中心</h1>
        <!--      <div class="safetopbox">
                  <div class="safe_center clear">
                      <div class="sc_level">
                                                      <div class="sc_level_2"></div>
                                                  </div>
                  </div>
                  <div class="safetop_info">
                      <p>ID：<b class="orange">1</b></p>
                      <p>姓名：<span style="color: #666;">管理员</span></p>
                      <p>用户名：<b style="color: #666;">admin</b></p>
                  </div>
              </div>-->
        <!--       <div class="rz_box">
                   <ul class="sc_statu">
                       <li><em class="sc_statu_type_1"></em>
                           <dl>
                               <dt>实名认证</dt>
                               <dd class="alpass">
                                   已认证<a href="/user/nameauth.html">查看</a>
                               </dd>
                           </dl>                    </li>
                       <li><em class="sc_statu_type_2_1"></em>
                           <dl>
                               <dt>谷歌认证</dt>
                               <dd class="nopass">
                                   未验证<a href="/user/ga.html">立即验证</a>
                               </dd>
                           </dl>
                           </li>
                       <li style="background: transparent;"> <em class="sc_statu_type_3"></em>
                           <dl>
                               <dt>绑定手机</dt>
                               <dd class="alpass">
                                   已认证 <a href="/user/mobile.html">查看</a>
                               </dd>
                           </dl></li>
                       <li style="background: transparent;"> <em class="sc_statu_type_4"></em>
                           <dl>
                               <dt>绑定邮箱</dt>
                               <dd class="alpass">
                                   已绑定 <a href="/user/email.html">查看</a>
                               </dd>
                           </dl></li>
                       <li style="background: transparent;"> <em class="sc_statu_type_5"></em>
                           <dl>
                               <dt>密保问题</dt>
                               <dd class="alpass">
                                   已设置 <a href="/user/mibao.html">查看</a>
                               </dd>
                           </dl></li>
                   </ul>
               </div>-->
        <div class="safeftbox" id="safebox">
            <div class="sc_info_list" id="sc_info_list">
                <dl>
                    <div style="float: left;height: 90px;width:60px;"><img src="/images/icon_03.png" alt=""></div>
                    <div style="float: left;height: 90px;width:850px;">
                        <dt>登录密码</dt>
                        <dd>
                            <p>登录账户时需要输入的密码</p>
                        </dd>
                        <dd>
                            <div class="changepw">
                                <a href="/user/password.html">修改登录密码</a>
                            </div>
                        </dd>
                    </div>
                </dl>
                <dl>
                    <div style="float: left;height: 90px;width:60px;"><img src="/images/icon_05.png" alt=""></div>
                    <div style="float: left;height: 90px;width:850px;">
                        <dt>交易密码</dt>
                        <dd>
                            <p>在进行交易、提现、转币等时需要输入的密码</p>
                        </dd>
                        <dd>
                            <div class="changepw">
                                <a href="/user/paypassword.html">修改交易密码</a>                            </div>
                        </dd>
                    </div>
                </dl>
                <dl>
                    <div style="float: left;height: 90px;width:60px;"><img src="/images/icon_07.png" alt=""></div>
                    <div style="float: left;height: 90px;width:850px;">
                        <dt>实名认证</dt>
                        <dd>
                            <p>必须完成实名认证才能提现</p>
                        </dd>
                        <dd>
                            <div class="changepw">
                                已认证 ｜ <a href="/user/nameauth.html">查看</a>                            </div>
                        </dd>
                    </div>
                </dl>
                <dl>
                    <div style="float: left;height: 90px;width:60px;"><img src="/images/icon_09.png" alt=""></div>
                    <div style="float: left;height: 90px;width:850px;">
                        <dt>谷歌验证</dt>
                        <dd>
                            <p>Google Authenticator (双重验证)，可以更安全的保护您的账户</p>
                        </dd>
                        <dd>
                            <div class="changepw">
                                未验证 ｜ <a href="/user/ga.html">立即验证</a>                             </div>
                        </dd>
                    </div>
                </dl>


                <dl>
                    <div>
                        <div style="float: left;height: 90px;width:60px;"><img src="/images/icon_11.png" alt=""></div>
                        <div style="float: left;height: 90px;width:850px;">
                            <dt>邮箱绑定</dt>
                            <dd>
                                <p>在提现、修改密码、转币等时候需要使用</p>
                            </dd>
                            <dd>
                                <div class="changepw">
                                    已绑定 | <a href="/user/email.html">查看</a>                            </div>
                            </dd>
                        </div>
                    </div></dl>
                <dl>
                    <div style="float: left;height: 90px;width:60px;"><img src="/images/icon_13.png" alt=""></div>
                    <div style="float: left;height: 90px;width:850px;">
                        <dt>手机绑定</dt>
                        <dd>
                            <p>在订单处理过程中需要使用</p>
                        </dd>
                        <dd>
                            <div class="changepw">
                                已绑定  | <a href="/user/mobile.html"> 查看</a>                            </div>
                        </dd>
                    </div>
                </dl>
                <!-- <dl>
                <div style="float: left;height: 90px;width:60px;"><img src="/images/icon_13.png" alt=""></div>
                 <div style="float: left;height: 90px;width:850px;">
                    <dt>密保问题</dt>
                    <dd>
                        <p>可以在找回密码和找回交易密码时使用</p>
                    </dd>
                    <dd>
                        <div class="changepw">
                            已设置 | <a href="/user/mibao.html">查看</a>                            </div>
                    </dd>
                    </div>
                </dl> -->
            </div>
        </div>
    </div>
@endsection