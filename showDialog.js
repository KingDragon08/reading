function showDialog()
{
  var bg_div = document.createElement("div");
  bg_div.style = "background:rgba(0,0,0,0.5); position:fixed; left:0; top:0; right:0; bottom:0; z-index:99;";
  var dialog_div = document.createElement("div");
  dialog_div.style = "background:#fff; border-radius:3px; width:400px; height:120px; position:absolute; top:50%; left:50%; margin-top:-60px; margin-left:-200px;"
  var title_div = document.createElement("div");
  title_div.style = "width:100%; height:30px; line-height:30px; background:blue; color:#fff; font-size:14px; text-indent:1em;";
  title_div.innerHTML = "对话框标题";
  var content_div = document.createElement("div");
  content_div.style = "width:100%; height:60px; line-height:30px; background:blue; color:#fff; font-size:14px; text-indent:1em;";
  content_div.innerHTML = "对话框内容";
  var ctr_div = document.createElement("div");
  var btn_ok = document.createElement("button");
  var btn_no = document.createElement("button");
  btn_ok.value="确定";
  btn_no.value= "取消";
  ctr_div.appendChild(btn_ok);
  ctr_div.appendChild(btn_no);
  dialog_div.appendChild(title_div);
  dialog_div.appendChild(content_div);
  dialog_div.appendChild(ctr_div);
  bg_div.appendChild(dialog_div);
  document.body.appendChild(bg_div);
}
