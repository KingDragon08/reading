/**
 * Created by zhangqi on 16/10/12.
 */
var iflytek = (function(document){
    //var example = {"0":["cn","read_syllable","好"],"1":["cn","read_word","明天"],"2":["cn","read_sentence","不管我的梦想能否成为事实"],"3":["en","read_word","[word]today"],"4":["en","read_sentence","It was two weeks before the Spring Festival."]};

    //var iat_result = document.getElementById('iat_result');
    var tip = document.getElementById('a');
    var volumeTip = document.getElementById('volume');
    volumeTip.width = 200;//parseFloat(window.getComputedStyle(tip, null).width) -100;
    var volumeWrapper = document.getElementById('canvas_wrapper');
    var oldText = tip.innerHTML;
    /* 标识麦克风按钮状态，按下状态值为true，否则为false */
    var mic_pressed = false;

    var volumeEvent = (function () {
        var lastVolume = 0;
        var eventId = 0;
        var canvas = volumeTip,
            cwidth = canvas.width,
            cheight = canvas.height;
        var ctx = canvas.getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, cwidth, 0);
        var animationId;
        gradient.addColorStop(1, 'red');
        gradient.addColorStop(0.8, 'yellow');
        gradient.addColorStop(0.5, '#9ec5f5');
        gradient.addColorStop(0, '#c1f1c5');

        volumeWrapper.style.display = "none";

        var listen = function(volume){
            lastVolume = volume;
        };
        var draw = function(){
            if(volumeWrapper.style.display == "none"){
                cancelAnimationFrame(animationId);
            }
            ctx.clearRect(0, 0, cwidth, cheight);
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, 1 + lastVolume*cwidth/30, cheight);
            animationId = requestAnimationFrame(draw);
        };

        var start = function(){
            animationId = requestAnimationFrame(draw);
            volumeWrapper.style.display = "block";
        };

        var stop = function(){
            clearInterval(eventId);
            volumeWrapper.style.display = "none";
        };

        return {
            "listen":listen,
            "start":start,
            "stop":stop
        };

    })();
    /***********************************************local Variables**********************************************************/

    /**
     * 初始化Session会话
     */
    var session = new IFlyIatSession({
        "callback":{
            "onResult": function (err, result) {
                /* 若回调的err为空或错误码为0，则会话成功，可提取识别结果进行显示*/
                if (err == null || err == undefined || err == 0)
                {
                    if (result == '' || result == null)
                    {
                      console.log("没有获取到评测结果");
                    }
                    else
                    {
                        // iat_result.innerHTML = result;
                        //alert(JSON.parse(result).totle_score);
                        var index = $("input[name='selected_zi_id']").val();
                        var s_score = JSON.parse(result).totle_score
                        $("#score").html(s_score);
                        scores[index] = s_score;
                   }
                }
                else//若回调的err不为空且错误码不为0，则会话失败，可提取错误码
                {
                    //alert('error code : '+err+", error description : "+result);
                    alert("录音时间过短或其他错误,请重试");
                }
                mic_pressed = false;
                volumeEvent.stop();
            },
            "onVolume": function (volume) {
                volumeEvent.listen(volume);
            },
            "onError":function(){
                mic_pressed = false;
                volumeEvent.stop();
            },
            "onProcess":function(status){
                switch (status){
                    case 'onStart':
                        tip.innerHTML = "服务初始化...";
                        break;
                    case 'normalVolume':
                    case 'started':
                        tip.innerHTML = "倾听中,再次点击提交";
                        break;
                    case 'onStop':
                        tip.innerHTML = "等待结果...";
                        break;
                    case 'onEnd':
                        tip.innerHTML = oldText;
                        break;
                    case 'lowVolume':
                        tip.innerHTML = "倾听中(声音过小)...";
                        break;
                    default:
                        tip.innerHTML = status;
                }
            }
        }
    });

    if(!session.isSupport()){
        alert("当前浏览器不支持!");
        return;
    }

    var play = function() {
        if (!mic_pressed)
        {
            var index = $("input[name='selected_zi_id']").val();
            if(index!=="")
            {
              var word = words[index];
              //["cn","read_syllable","好"]
              var ssb_param = {
                  "ise_word": word,
                  "ise_category": "read_syllable",
                  "params": "appid=58cb464c,appidkey=4246d69fc76ac885,bom=true,rstcd=utf8,category=read_syllable,auf=audio/L16;rate=16000,vad_enable=1,vad_speech_tail=10000,ent=cn,aue=speex-wb;7"
              };
              /* 调用开始录音接口，通过function(volume)和function(err, obj)回调音量和识别结果 */
              session.start(ssb_param);
              mic_pressed = true;
              volumeEvent.start();
            }
            else
            {
              alert("请先点击左侧列表选择测试的字哟");
            }
        }
        else
        {
            //停止麦克风录音，仍会返回已传录音的识别结果.
            session.stop();
        }
    }

    /**
     * 取消本次会话识别
     */
    var cancel = function() {
        session.cancel();
    }

    tip.addEventListener("click",function(){
        //alert(1);
        play();
    });

    //页面不可见，断开麦克风调用
    document.addEventListener("visibilitychange",function(){
        if(document.hidden == true){
            session.kill();
        }
    });
})(document)
