<script type="text/javascript" language="javascript">
var id=0;
$(function() {
	$("#mayfer_date_begin").datepicker();
	$("#mayfer_date_begin").datepicker("option", "dateFormat", "dd.mm.yy");
	$("#mayfer_date_begin").datepicker("setDate", "{#mayfer_date_begin}");
	$("#mayfer_date_end").datepicker();
	$("#mayfer_date_end").datepicker("option", "dateFormat", "dd.mm.yy");
	$("#mayfer_date_end").datepicker("setDate", "{#mayfer_date_end}");
	
});
function addInput() {
	if(document.getElementById('div'+id)) {
		document.getElementById('div'+id).innerHTML = '<select name="id_profile[]"><option value="0">нет</option>{#profile_type}</select><input type="text" name="url_profile[]" style="width: 200px;" placeholder="Вставьте ссылку на профиль"><div id="div'+(id+1)+'"></div>'
		id++;
	}
}
function rand( min, max ) { // Generate a random integer
		    if( max ) {
		        return Math.floor(Math.random() * (max - min + 1)) + min;
		    } else {
		        return Math.floor(Math.random() * (min + 1));
		    }
}

function genPass() {
		var arr = new Array('a','b','c','d','e','f',
				    'g','h','i','j','k',
				    'm','n','o','p','r','s',
		            't','u','v','x','y','z',
		            'A','B','C','D','E','F',
		            'G','H','J','K','L',
		            'M','N','O','P','R','S',
		            'T','U','V','X','Y','Z',
		            '1','2','3','4','5','6',
		'7','8','9','0');
		var pass = "";
		var num = 0;
		var sym = 0;
		for(i = 0; i < 8; i++) {
			index = rand(0, arr.length - 1);
			pass += arr[index];
		}
		document.getElementById('new_pass2').innerHTML = pass;
		document.getElementById('password2').value = pass;
		document.getElementById('pass_form').style.display = "block";
}


</script>
{if is_deleted}<div class="msg-error">Данный пользователь ЗАБЛОКИРОВАН (отчислен/выпустился/не работает)! Редактирование данных ЗАПРЕЩЕНО! Вход на территорию ЗАПРЕЩЕН!</div>
<table width="100%" {if is_deleted}style="background-color: #f5d7d7;" title="Данный пользователь ЗАБЛОКИРОВАН! Редактирование данных ЗАПРЕЩЕНО! Вход на территорию ЗАПРЕЩЕН!"{/if}><tr>
{if id}{if is_foto}<td width="1px"><div class="portfolio_img" style="background-image: url('/files/lk/photo/{#id}.jpg');"></div></td>
<td>
<div class="portfolio_tbl" style="width: 100%;">
<table class="ispgut" {if is_foto} style="width: 99% !important;" {/if}>
{if auth}<tr><td colspan="2">
{if admin}<div style="float:left;"><img style="background-image: url('/images/cam.png'); background-size: 100px;" src="/files/sphinx/{#id}.jpg" title="Фотоизображение с камеры КПП ПГУ"></div>
<div class="back_grey"><div>{#biography}</div>
{if !no_card}{if auth}{if card}<div style="text-align: right;"><a target="_blank" href="/card/{#id}"><img src="/images/card.png" align="absmiddle">&nbsp;Личная карточка учащегося</a></div>
{if !no_card}{if auth}{if !card}<div style="text-align: right;"><a target="_blank" href="/card/{#id}"><img src="/images/card1.png" align="absmiddle">&nbsp;Личная карточка сотрудника</a></div>
            {if med}<div style="text-align: right;"><a href="/med/{#id}"><img src="/images/card1.png" align="absmiddle">&nbsp;Медицинская карта</a></div>
{if admin}<div style="text-align: right; cursor: pointer;"><a onclick="toggle_tree('new_pass', '');"><img src="/images/card1.png" align="absmiddle">&nbsp;Пароль</a><span id="new_pass" style="display: none;">Логин: "{#login}" Пароль: "<span id="new_pass2">{#password}</span>" <a onclick="genPass()">сгенерировать пароль</a></span><form action="/portfolio/savepass/" id="pass_form" style="display: none;" method="post"><input type="hidden" name="login" value="{#login}"><input type="hidden" name="id" value="{#id}"><input type="hidden" name="password" id="password2" value="{#password}"><input type="submit" value="Сохранить" onclick="if(!confirm('Пароль будет перезаписан! Продолжить?')) return false;"></form></div>
{if admin}<div style="text-align: right; cursor: pointer;"><a onclick="toggle_tree('new_mayfer', '');"><img src="/images/card1.png" align="absmiddle">&nbsp;Обновить код карты</a><span id="new_mayfer" style="display: none;"><form action="/portfolio/savemayfer/" id="mayfer_form" method="post"><input type="text" name="mayfer" {if mayfer}value="{#mayfer}"{/if}{if admin} placeholder="Введите новый код Mayfer карты" style="width: 200px;"><input type="text" name="mayfer_date_begin" value="{#mayfer_date_begin}" id="mayfer_date_begin"><input type="text" value="{#mayfer_date_end}" placeholder="Введите дату окончания действия карты" name="mayfer_date_end" id="mayfer_date_end"><input type="hidden" name="id" value="{#id}"><input type="hidden" name="id_sphinx" value="{#id_sphinx}"><input type="hidden" name="is_student" value="{#is_student}"><input type="hidden" name="is_empl" value="{#is_empl}"><input type="submit" value="Сохранить" onclick="if(!confirm('Данные о карте будут изменены! Продолжить?')) return false;">
{if admin}<br><table>{#row_dev}</table>
{if admin}</form></span></div>
</div>
{if auth}</td></tr>
{if date_birth}<tr><td width="300">Дата рождения:</td><td>{#date_birth}</td></tr>
{if code}<tr><td>Табельный/регистрационный номер:</td><td>{#code}</td></tr>
{if code}{if contract_list}<tr><td colspan="2"><table border="1">Договора:<tr><td>тип</td><td>нормер</td><td>статус</td><td>долг (руб.)</td></tr>{#contract_list}</table></td></tr>
{if exp}<tr><td>Стаж:</td><td>{#exp}</td></tr>
{if exp_pgu}<tr><td>Педагогический стаж:</td><td>{#exp_pgu}</td></tr>
{if my}<tr><td>Телефон:</td><td>{#tel} <b><a style="cursor: pointer;" onclick="toggle_tree('new_tel', '');">Сменить телефон</a></b><div id="new_tel" style="display: none;"><form action="/portfolio/{#id}/savetel" method="post"><input type="text" name="tel" value="{#tel}" style="width: 160px;"><input type="submit" value="Сохранить"></form></div></td></tr>
{if my}<tr><td>E-mail:</td><td>{#email} <b><a style="cursor: pointer;" onclick="toggle_tree('new_mail', '');">Сменить e-mail</a></b><div id="new_mail" style="display: none;"><form action="/portfolio/{#id}/saveemail" method="post"><input type="text" name="email" value="{#email}" style="width: 160px;"><input type="submit" value="Сохранить"></form></div></td></tr>
{if my}<tr><td>Загрузить фотографию:</td><td><form action="/portfolio/my/savepho" method="post" enctype="multipart/form-data" id="sendform" name="sendform"><input type="file" name="upload_photo" value="Выбрать файл для загрузки" onchange="sendform.submit();"></form></td></tr>
{if my}<tr><td>Добавить внешние профили соцсетей:</td><td><form action="/portfolio/{#id}/showdopinfo" method="post"><div id="div0"></div><button onclick="addInput();return false;">Добавить профиль</a></td></tr>
{if my}<tr><td colspan="2">Показывать дополнительную информацию: <select name="is_show"><option value="1" {if is_show_user}selected="selected"{/if}{if my}>Да</option><option value="0" {if !is_show_user}selected="selected"{/if}{if my}>Нет</option></select><input type="submit" name="savedop" value="Сохранить"></form></td></tr>
{if my}<tr><td colspan="2">{if is_owner} <a href="/portfolio/addconf"><b><font size="6">+</font></b>Добавить информацию</a></td></tr>
<tr><td colspan="2">{#list_profile}</td></tr>
</table>
</div>
</td></tr></table>


{if edit_group} <form action="/users/{#id}" method="post">
{if edit_group} Учебная группа: <select name="id_group">{#edit_group}</select>
{if edit_group} <input type="submit" name="save" value="Сохранить">

{if rows_edu}<div class="msg-neutral" style="margin-top: 15px; cursor: pointer;" onclick="toggle_tree('listedu', '');"><b>Образование</b>&nbsp;<img src="/images/sort1.png"></div>
{if rows_edu}<div id="listedu" style="display: none;">
{if rows_edu}<table>{#rows_edu}</table>
{if rows_edu}</div>

{if rows}<div class="msg-neutral" style="margin-top: 15px; cursor: pointer;" onclick="toggle_tree('listwork', '');"><b>Работа/Учеба</b>&nbsp;<img src="/images/sort1.png"></div>
{if rows}<div id="listwork" style="display: none;">
{if rows}<table>{#rows}</table>
{if rows}</div>

{if cars}<div class="msg-neutral" style="margin-top: 15px; cursor: pointer;" onclick="toggle_tree('listcars', '');"><b>Сведения об автомобиле</b>&nbsp;<img src="/images/sort1.png"></div>
{if cars}<div id="listcars" style="display: none;">
{if cars}<table width="80%">
{if cars}<tr align="center"><td>Статус</td><td>Марка</td><td>Номер</td><td>Разрешенные КПП</td></tr>
{if cars}{#cars}
{if cars}</table>
{if cars}{#edit_form}
{if cars}</div>

