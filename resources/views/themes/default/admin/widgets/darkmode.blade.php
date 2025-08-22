<button id="darkmode-switcher" class="w-6">
    <svg class="feather feather-moon dark-mode" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
    <svg class="light-mode" viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"><rect fill="none" height="256" width="256"/><circle cx="128" cy="128" fill="none" r="60" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12"/><line fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" x1="128" x2="128" y1="36" y2="16"/><line fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" x1="62.9" x2="48.8" y1="62.9" y2="48.8"/><line fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" x1="36" x2="16" y1="128" y2="128"/><line fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" x1="62.9" x2="48.8" y1="193.1" y2="207.2"/><line fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" x1="128" x2="128" y1="220" y2="240"/><line fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" x1="193.1" x2="207.2" y1="193.1" y2="207.2"/><line fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" x1="220" x2="240" y1="128" y2="128"/><line fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="12" x1="193.1" x2="207.2" y1="62.9" y2="48.8"/></svg>

</button>
<style type="text/css">
.dark .light-mode{
    display: none;
}
.dark .dark-mode{
    display: block;
}
.dark-mode{
    display: none;
}
</style>
<script type="text/javascript">
$('#darkmode-switcher').click(()=>{
    if($('html').hasClass("dark")){
        localStorage.removeItem("dark_mode");
    }else{
        localStorage.setItem("dark_mode",1);
    }
    $('html').toggleClass("dark");

});

$(function(){
    if(localStorage.getItem("dark_mode")){
        $('html').addClass("dark");
    }
})
</script>
