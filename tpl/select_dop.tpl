<script type="text/javascript" language="javascript">
	function linked(ch, link) {
		var str;
		str = link;
		if(ch.checked) location.href=link+'/'+ch.id; 
		else {
			location.href=str.replace(ch.id, '');
		}
	}
</script>

<div>
	<input type="checkbox" name="is_dop" id="dop" onchange="linked(this, '/{#link}'); return false;" {if is_dop} checked {/if}><label for="dop">&nbsp;Отображать дополнительную информацию</label>
{if is_pass}	<br><input type="checkbox" name="pass" id="pass" onchange="linked(this, '/{#link}'); return false;" {if pass} checked {/if}{if is_pass}><label for="pass">&nbsp;Показать логин/пароль</label>
</div>