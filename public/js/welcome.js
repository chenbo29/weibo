cid=51 //客户ID 即数据库表company中id字段
num=1;
function closeMain(){
 $(".main").hide();
}
function run() {
  $.post('welcome/info',{cid:cid,num:num}, function(data){
    console.log(data.info);
    if (data.info.link) {
      var info='<a style="margin-left: 10px;" href="welcome/redirect/'+data.info.link+ '/' + data.info.id+'" target="_blank">'+data.info.title+'</a>';
    } else {
      var info='<a style="margin-left: 10px;" href="#" onclick="return false" target="_blank">'+data.info.title+'</a>';
    }
    $('.marquee').fadeOut();
    $('.marquee').html(info);
    $('.marquee').fadeIn();
    if (num == data.info.count) {num = 0;console.log(data.info.count)};
     num++;
  })
}
run()
setInterval("run()",5000)