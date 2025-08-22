<div id="clock" class=""></div>
<script>
setInterval(function(){
    const event =  new Date();
    //event.toLocaleString('zh_Hant_HK', {timeZone:'Asia/Hong_Kong'});
    $('#clock').text(moment().tz('Asia/Hong_Kong').format('YYYY年MM月DD日h:mm:ssa'));
}, 1000);
</script>
