@extends('user.layout')

@section('userright')

    <div class="usnc_right">
        <h1>安全中心</h1>
        <div class="safetopbox">
            <form action="/user/info" method="post" id="frm" name="frm" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="safetop_info">
                    <div class="img">
                        <img src="{{$user->avatar}}" onclick="select()"
                             name="image"> <input id="file" style="display:none" type="file" name="file"
                                                  onchange="upimg()" accept="image/*" title="修改头像">
                        <p class="name">{{$user->name}}</p>
                    </div>
                </div>
                <div class="test">
                    <p>
                        身份验证：&nbsp;&nbsp;
                        已认证 </p>
                    <p>
                        电子邮件：&nbsp;&nbsp;
                        已绑定 | <a href="/user/email.html">查看</a></p>
                    <p>
                        谷歌验证：&nbsp;&nbsp;
                        未验证 ｜ <a href="/user/ga.html">立即验证</a></p>
                    <p>
                        手机验证：&nbsp;&nbsp;
                        <a href="/user/mobile.html">查看</a></p>
                    <p>注册时间：&nbsp;&nbsp; 2017-05-27 18:22:55</p>
                    <p>第一次交易时间：&nbsp;&nbsp;
                        --
                    </p>
                    <p>信任人数：&nbsp;&nbsp; 被 6 人信任</p>
                    <p>累计交易次数：&nbsp;&nbsp; 0 次</p>
                    <p>好评度：&nbsp;&nbsp; 0%</p>
                    <!--<p>累计交易量：&nbsp;&nbsp;  0 BTC</p>-->
                    <p>平均放行时间：&nbsp;&nbsp; 0 分</p>
                    <p>个人简介</p>
                    <textarea class="area" style="color: rgba(0,0,0,0.7);"
                              onblur="if(this.value == '')this.value='简介，在您的公共资料上展示您的介绍信息。纯文本，不超过200个字';"
                              onclick="if(this.value == '简介，在您的公共资料上展示您的介绍信息。纯文本，不超过200个字')this.value='';" id="area">简介，在您的公共资料上展示您的介绍信息。纯文本，不超过200个字</textarea>


                    <button class="btn btn-primary" type="button" onclick="jj()">保存</button>

                </div>
            </form>
        </div>

        <script>
            function jj() {
                var jianjie = $('#area').val();
                if (jianjie != '简介，在您的公共资料上展示您的介绍信息。纯文本，不超过200个字') {
                    $.post("/User/jianjie.html", {jianjie: jianjie}, function (data) {
                        if (data.status == 1) {
                            layer.msg(data.info, {icon: 1});
                            window.location = "/User/index.html";
                        } else {
                            layer.msg(data.info, {icon: 2});
                            if (data.url) {
                                window.location = data.url;
                            }
                        }
                    }, "json");
                } else {
                    layer.msg('请填写后提交', {icon: 2});
                }
            }

            function select() {
                $('#file').click();
            }

            function upimg() {
                if (confirm('是否上传?')) {
                    $("#frm").submit();
                }
            }

        </script>
        <!--   <div class="rz_box">
             <ul class="sc_statu">
                 <li><em class="sc_statu_type_1"></em>
                      <dl>
                       <dt>实名认证</dt>
                       <dd class="alpass">
                        已认证<a href="/user/nameauth.html">查看</a>
                       </dd>
                      </dl>		  </li>
                 <li><em class="sc_statu_type_2_1"></em>
                  <dl>
                   <dt>谷歌认证</dt>
                   <dd class="nopass">
                    未验证<a href="/user/ga.html">立即验证</a>
                   </dd>
                  </dl>
                  </li>
             &lt;!&ndash;    <li style="background: transparent;"> <em class="sc_statu_type_3"></em>
                  <dl>
                   <dt>绑定手机</dt>
                   <dd class="alpass">
                    已认证 <a href="/user/mobile.html">查看</a>
                   </dd>
                  </dl></li>&ndash;&gt;
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
        <!--    <div class="safeftbox" id="safebox">
                 <div class="sc_info_list" id="sc_info_list">
                  <dl>
                   <dt>登录密码</dt>
                   <dd>
                    <p>登录账户时需要输入的密码</p>
                   </dd>
                   <dd>
                    <div class="changepw">
                     <a href="/user/password.html">修改登录密码</a>
                    </div>
                   </dd>
                  </dl>
                  <dl>
                   <dt>交易密码</dt>
                   <dd>
                    <p>在进行交易、提现、转币等时需要输入的密码</p>
                   </dd>
                   <dd>
                    <div class="changepw">
                                     <a href="/user/paypassword.html">修改交易密码</a>			</div>
                   </dd>
                  </dl>
                  <dl>
                   <dt>实名认证</dt>
                   <dd>
                    <p>必须完成实名认证才能提现</p>
                   </dd>
                   <dd>
                    <div class="changepw">
                                     已认证 <a href="/user/nameauth.html">查看</a>			</div>
                   </dd>
                  </dl>
                  <dl>
                   <dt>谷歌验证</dt>
                   <dd>
                    <p>Google Authenticator (双重验证)，可以更安全的保护您的账户</p>
                   </dd>
                   <dd>
                    <div class="changepw">
                     未验证 ｜ <a href="/user/ga.html">立即验证</a> 			</div>
                   </dd>
                  </dl>
                  <dl>
                   <dt>手机绑定</dt>
                   <dd>
                    <p>在提现、修改密码、转币等时候需要使用</p>
                   </dd>
                   <dd>
                    <div class="changepw">
                     已绑定 | <a href="/user/mobile.html">查看</a>			</div>
                   </dd>
                  </dl>
                  <dl>
                   <dt>邮箱绑定</dt>
                   <dd>
                    <p>在提现、修改密码、转币等时候需要使用</p>
                   </dd>
                   <dd>
                    <div class="changepw">
                     已绑定 | <a href="/user/email.html">查看</a>			</div>
                   </dd>
                  </dl>
                  <dl>
                   <dt>密保问题</dt>
                   <dd>
                    <p>可以在找回密码和找回交易密码时使用</p>
                   </dd>
                   <dd>
                    <div class="changepw">
                     已设置 | <a href="/user/mibao.html">查看</a>			</div>
                   </dd>
                  </dl>
                 </div>
            </div>-->
    </div>
@endsection