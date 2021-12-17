<?php

/* @var $this yii\web\View */
/* @var $model common\models\QuerySearch */
/* @var $form yii\widgets\ActiveForm */


?>
<script src="../js/jquery.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script src="https://open.work.weixin.qq.com/wwopen/js/jwxwork-1.0.0.js"></script>

<script>
    $(document).ready(function(){

        var link = window.location.href;

        $("button").click(function(){
            $.ajax({
                //请求方式
                type : "GET",
                //请求的媒体类型
                contentType: "application/json;charset=UTF-8",
                //请求地址
                url : "http://domain.com/qyw/get-signature",
                //数据，json字符串
                data : {
                    "url":link
                },
                //请求成功
                success : function(res) {
                    res = JSON.parse(res)

                    wx.config({
                        beta: true,
                        debug: true,
                        appId: res.corpid,
                        timestamp: res.timestamp,
                        nonceStr: res.nonceStr,
                        signature: res.signature,
                        jsApiList: ['agentConfig','openUserProfile','thirdPartyOpenPage','selectExternalContact']
                    });

                    wx.ready(function(){

                        wx.agentConfig({
                            corpid: res.corpid, // 必填，企业微信的corpid，必须与当前登录的企业一致
                            agentid: res.agentId, // 必填，企业微信的应用id
                            timestamp: res.timestamp, // 必填，生成签名的时间戳
                            nonceStr: res.noncestr, // 必填，生成签名的随机串
                            signature: res.agentSignature,// 必填，签名，见附录1
                            jsApiList: ['agentConfig','openUserProfile','thirdPartyOpenPage','selectExternalContact'], //必填
                            success: function(res) {
                                // 发起审批流程
                                wx.invoke('thirdPartyOpenPage', {
                                        "oaType": "10001",// String
                                        "templateId": "8a1748e80f5a5bb201e2ebe486f1f594_1819173652",// String
                                        "thirdNo": "t01",// 审批单号，开发者自己控制，不可重复
                                        "extData": {
                                            'fieldList': [{
                                                'title': '采购类型',
                                                'type': 'text',
                                                'value': '市场活动',
                                            },{
                                                'title': '采购类型',
                                                'type': 'text',
                                                'value': '市场活动',
                                            },{
                                                'title': '采购类型',
                                                'type': 'text',
                                                'value': '市场活动',
                                            },{
                                                'title': '采购类型',
                                                'type': 'text',
                                                'value': '市场活动',
                                            },{
                                                'title': '采购类型',
                                                'type': 'text',
                                                'value': '市场活动',
                                            }],
                                        }
                                    },
                                    function(res) {
                                        // 输出接口的回调信息
                                        console.log(333)
                                        // console.log(res);
                                    });
                            },
                            fail: function(res) {
                                if(res.errMsg.indexOf('function not exist') > -1){
                                    alert('版本过低请升级')
                                }
                            }
                        });
                    })
                }
            });

        });
    });
</script>


<body>
<div style="margin: 0 auto;text-align: center;margin-top: 300px">
<button style="font-size: large;color: green">点我</button>
</div>
</body>
