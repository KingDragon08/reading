$().ready(function(){
  //设置book_info内容垂直居中
  $(".book_info").each(function(){
    $(this).height($(this).parent().find(".book_img").height());
  });
});
