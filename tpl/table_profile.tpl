<div style="width: 40px; height: 40px; float: left;">
    <a href="{#profile_url}" target="_blank"><img style="width: 35px; height: 35px;"  src="{#image}"></a>
    <div style="margin-top: -47px;">
	{if del}<a href="delprof/{#id_profile}" onclick="if(!confirm('Элемент удаляется без возможности восстановления! Продолжить?')) return false;"><img src="/images/cross_2196.png" style="width: 10px;"></a>
	<input type="hidden" name="id_profile" value="{#id_profile}">
    </div>
</div>