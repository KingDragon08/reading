//写cookies
function set_cookie(name,value)
{
  var Days = 1;
  var exp = new Date();
  exp.setTime(exp.getTime() + Days*24*60*60*1000);
  document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}

//读cookies
function get_cookie(name)
{
  var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
  if(arr=document.cookie.match(reg))
    return unescape(arr[2]);
  else
    return null;
}

//删除cookie
function del_cookie(name)
{
  var exp = new Date();
  exp.setTime(exp.getTime() - 1);
  var cval=get_cookie(name);
  if(cval!=null)
    document.cookie= name + "="+cval+";expires="+exp.toGMTString();
}
