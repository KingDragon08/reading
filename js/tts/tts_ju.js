var audioPalyUrl = "http://h5.xf-yun.com/audioStream/";
var session = new IFlyTtsSession({
									'url'                : 'wss://ttscloud.openspeech.cn/tts.do',
									'reconnection'       : true,
									'reconnectionDelay'  : 30000
								});
window.iaudio = null;
var audio_state = 0;
function play(content, vcn){
  reset();

	ssb_param = {"appid": '58cb464c', "appkey":"4246d69fc76ac885", "synid":"12345", "params" : "ent=aisound,aue=lame,vcn="+vcn};

	session.start(ssb_param, content, function (err, obj)
	{
		var audio_url = audioPalyUrl + obj.audio_url;
		if( audio_url != null && audio_url != undefined )
		{
			window.iaudio.src = audio_url;
			window.iaudio.play();
		}
	});
};
function stop() {
    audio_state = 2;
    window.iaudio.pause();
}

function start() {
	audio_state = 1;
	window.iaudio.play();
}

function play_xiaoyan()
{
  var index = $("#selected_ju").val();
  if(index!=="")
  {
    var word = $("#words_"+index).val();
    play(word, 'aisxping')
  }
  else
  {
    alert("请先点击左侧列表选择测试的短文哟");
  }
};

function reset()
{
	audio_array = [];
	audio_state = 0;
	if(window.iaudio != null)
	{
		window.iaudio.pause();
	}
	window.iaudio = new Audio();
	window.iaudio.src = '';
	//window.iaudio.play();
};
