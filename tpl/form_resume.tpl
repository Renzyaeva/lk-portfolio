<link rel="stylesheet" type="text/css" href="/styles/user.css">
<script type="text/javascript">
	$(function() {
		
	});
	function checkYes() {
		if(!$("#yes").is(':checked')) {
			var msg_warn = true;
		}
		if(msg_warn) {
			if(confirm('Внимание! Не принято соглашение о персональных данных! В данном случае резюме не будет фигурировать в поиске системы: вы уверены, что хотите сохранить резюме?')) {
				$( "#form-resume" ).submit();
			} else {
				return false;
			}
		} else $( "#form-resume" ).submit();
	}
</script>
<div class="item_nav"><a href="/portfolio/{#id_user}">Портфолио</a></div>
<div class="item_nav"><a href="/work">ВУЗ + Работодатель</a></div>
<form action="/portfolio/{#id_user}/resume" method="post" enctype="multipart/form-data" id="form-resume" >
<div style="text-align: right;">{if date_create_unix}Дата создания {#date_create}{/if}{if date_update_unix}, Дата обновления {#date_update}{/if}</div>
<div class="resume">
	<div class="itemres">ФИО</div><div class="itemres"><a href="/portfolio/{#id_user}">{#name}</a></div>
	<div class="itemres">Пол</div><div class="itemres">{#sex}</div>
	<div class="itemres">Дата рождения</div><div class="itemres">{#date_birth} ({#age} лет)</div>
	{if tel}<div class="itemres">Телефон</div><div class="itemres">{#tel}</div>
	{if email}<div class="itemres">E-mail</div><div class="itemres">{#email}</div>
	{if edu}<div class="itemres">Уровень образования</div><div class="itemres">{#edu}</div>
	{if science}<div class="itemres">Научные достижения</div><div class="itemres">{#science}</div>
	{if know_lng}<div class="itemres">Знание иностранных языков</div><div class="itemres">{if edit}<textarea name="know_lng">{/if}{if know_lng}{#know_lng}{if edit}</textarea>{/if}{if know_lng}</div>
	{if know_plng}<div class="itemres">Знание языков программирования</div><div class="itemres">{if edit}<textarea name="know_plng">{/if}{if know_plng}{#know_plng}{if edit}</textarea>{/if}{if know_plng}</div>
	<div class="itemres">Уровень знания ПК</div><div class="itemres">
		<input type="radio" name="know_pk" value="1" id="pk1" {#pk1} {if !edit}disabled="disabled"{/if}><label for="pk1">Начальный</label>
		<input type="radio" name="know_pk" value="2" id="pk2" {#pk2} {if !edit}disabled="disabled"{/if}><label for="pk2">Средний</label>
		<input type="radio" name="know_pk" value="3" id="pk3" {#pk3} {if !edit}disabled="disabled"{/if}><label for="pk3">Уверенный</label>
		<input type="radio" name="know_pk" value="4" id="pk4" {#pk4} {if !edit}disabled="disabled"{/if}><label for="pk4">Профессиональный</label></div>
	{if know_prog}<div class="itemres">Знание программ</div><div class="itemres">{if edit}<textarea name="know_prog">{/if}{if know_prog}{#know_prog}{if edit}</textarea>{/if}{if know_prog}</div>
	{if work_condition}<div class="itemres">Желаемые условия труда</div><div class="itemres">{if edit}<textarea name="work_condition" placeholder="Необходимо заполнить желаемые условия труда">{/if}{if work_condition}{#work_condition}{if edit}</textarea>{/if}{if work_condition}</div>
	{if know_dop}<div class="itemres">Дополнительная информация</div><div class="itemres">{if edit}<textarea name="know_dop">{/if}{if know_dop}{#know_dop}{if edit}</textarea>{/if}{if know_dop}</div>
	{if edit}<div class="itemres">Согласие на обработку персональных данных<br><br><span onclick="toggle_tree('agreement', '');" style="cursor: pointer;"><u>Ознакомиться с соглашением</u></span></div><div class="itemres"><label for="yes"><input id="yes" type="checkbox" name="yes_pers" {if yes_pers}checked="checked"{/if}{if edit}>&nbsp;Я согласен</label><br><div class="txt-msg">Если отметка о согласии не установлена, Ваше резюме не попадает в список резюме, доступных для работодателей в системе "ВУЗ + Работодатель"</div></div>
</div>
<div class="itemagr" id="agreement" style="display: none;">Соглашение о защите персональных данных</div>

{if id}<input type="hidden" name="id" value="{#id}">
{if date_create_unix}<input type="hidden" name="date_create" value="{#date_create_unix}">
<input type="hidden" name="id_user" value="{#id_user}">		
{if edit}<input type="hidden" name="save_resume" value="1"><input type="button" value="Сохранить" onclick="checkYes();">
{if edit}<input type="button" value="Отмена" onclick="history.back()">
</form>