<link rel="stylesheet" type="text/css" href="/styles/user.css">
<link rel="stylesheet" href="/styles/lightbox.css">
<script src="/scripts/js/mini-lightbox.min.js"></script>
<script>
    window.onload = function () {
        let ml = new MiniLightbox("#my-photo{#id}");
        function waitForAnimationEnd (element, callback) {
            var animationEnd = "animationend";
            var handleAnimationEnd = function (event) {
                // remove listner
                event.target.removeEventListener(animationEnd, handleAnimationEnd);
                // fire callback
                return callback(event);
            };
            element.addEventListener(animationEnd, handleAnimationEnd);
        }
        MiniLightbox.customClose = function (self) {
            self.img.classList.add("animated", "fadeOutDown");
            waitForAnimationEnd(self.img, function () {
                self.box.classList.add("animated", "fadeOut");
            });
            waitForAnimationEnd(self.box, function () {
                self.box.classList.remove("animated", "fadeOut", "fadeIn");
                self.img.classList.remove("animated", "fadeOutDown");
                self.box.style.display = "none";
            });
            return false;
        };
        MiniLightbox.customOpen = function (self) {
            if (self.el.parentElement.tagName === "A") {
                return false;
            }
            self.box.classList.add("animated", "fadeIn");
            self.img.classList.add("animated", "fadeInUp");
        };
    };
</script>
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

function setBio() {
   $('.biography').slideToggle( "slow" );
}


</script>
{if is_deleted}<div class="msg-error">Данный пользователь ЗАБЛОКИРОВАН (отчислен/выпустился/не работает)! Редактирование данных ЗАПРЕЩЕНО! Вход на территорию ЗАПРЕЩЕН!</div>
<div class="user-menu">
    {if !no_card}{if auth}	<div class="user-btn menu"><a target="_blank" href="/card/{#id}">Личная карточка</a></div>
    {if med}  <div class="user-btn menu"><a href="/med/{#id}">Медицинская карта</a></div>
    {if fvo}<div class="user-btn menu"><a target="_blank" href="/mil/{#id}" class="link-pointer">Карточка ВУ</a></div>
    {if admin_all}<div class="user-btn menu"><a onclick="toggle_tree('new_pass', '');" class="link-pointer">Пароль</a></div>
	{if admin_all}<div class="user-btn menu"><a onclick="toggle_tree('new_mayfer', '');" class="link-pointer">Обновить код карты</a></div>
	{if admin_all}	<div class="user-btn menu"><a onclick="toggle_tree('rights', '');" class="link-pointer">Права</a></div>
	{if is_praepostor}	<div class="user-btn menu"><a href="/attendance" target="_blank" class="link-pointer">Учет посещаемости</a></div>
    {if is_curator}	<div class="user-btn menu"><a href="/attendance" target="_blank" class="link-pointer">Учет посещаемости</a></div>
</div>
{if admin_all}<div id="new_pass" class="slave-div">Логин: "{#login}" Пароль: "<span id="new_pass2">{#password}</span>" <a onclick="genPass()">сгенерировать пароль</a>
	{if admin_all}	<form action="/portfolio/savepass/" id="pass_form" style="display: none;" method="post">
		{if admin_all}	<input type="hidden" name="login" value="{#login}">
		{if admin_all}	<input type="hidden" name="id" value="{#id}">
		{if admin_all}	<input type="hidden" name="password" id="password2" value="{#password}">
		{if admin_all}	<input type="submit" value="Сохранить" onclick="if(!confirm('Пароль будет перезаписан! Продолжить?')) return false;">
	{if admin_all}	</form>
{if admin_all}</div>
{if admin_all}<div id="new_mayfer" class="slave-div">
	{if admin_all}<form action="/portfolio/savemayfer/" id="mayfer_form" method="post">
	{if admin_all}<input type="text" name="mayfer" {if mayfer}value="{#mayfer}"{/if}{if admin_all} placeholder="Введите новый код Mayfer карты" style="width: 200px;">
	{if admin_all}<input type="text" name="mayfer_date_begin" value="{#mayfer_date_begin}" id="mayfer_date_begin">
	{if admin_all}<input type="text" value="{#mayfer_date_end}" placeholder="Введите дату окончания действия карты" name="mayfer_date_end" id="mayfer_date_end">
	{if admin_all}<input type="hidden" name="id" value="{#id}">
	{if admin_all}<input type="hidden" name="id_sphinx" value="{#id_sphinx}">
	{if admin_all}<input type="hidden" name="is_student" value="{#is_student}">
	{if admin_all}<input type="hidden" name="is_empl" value="{#is_empl}">
	{if admin_all}<input type="submit" value="Сохранить" onclick="if(!confirm('Данные о карте будут изменены! Продолжить?')) return false;">
	{if admin_all}<br><table>{#row_dev}</table>
	{if admin_all}</form>
{if admin_all}</div>
{if admin_all}<div id="rights" class="slave-div">Права доступа:<form action="/portfolio/{#id}/rightsadd" method="post"><table><tr><td>уровень прав</td><td>для подразделения</td><td>модуль</td><td></td></tr>
{if admin_all}{#row_rights}<tr><td><input type="hidden" name="id_user" value="{#id}"><select name="rights"><option value="100">чтение</option><option value="110">использование</option><option value="111">запись</option></select></td><td><input type="checkbox" name="id_dep" checked="checked"></td><td><select name="id_module">{#module_rows}</select></td><td><input type="submit" value="добавить"></td></tr>
{if admin_all}</table></form></div>

<div class="user-info">
	<div class="user-par">
		<div>
		{if show_ph1}{if image}<img src="/files/lk/photo/{#image}" width="200" id="my-photo{#id}" class="my-photo">
		{if show_ph1}{if !image}<img src="/files/lk/photo/{#id}.jpg" width="200" id="my-photo{#id}" class="my-photo">
        {if show_ph1}{if is_curator}<form action="/portfolio/{#id}" method="post"><input type="hidden" name="id_user" value="{#id}"><input type="submit" value="Удалить фотографию" name="del_photo" onclick="if(!confirm('Фотография пользователя будет удалена! Продолжить?')) return false;"></form>
        {if show_ph1}{if admin_all}<form action="/portfolio/{#id}" method="post"><input type="hidden" name="id_user" value="{#id}"><input type="submit" value="Удалить фотографию" name="del_photo" onclick="if(!confirm('Фотография пользователя будет удалена! Продолжить?')) return false;"></form>
		{if !show_ph1}фотография не загружена

		</div>
		{if my}<div class="user-btn option"><form action="/portfolio/saveph1/{#id}" method="post" enctype="multipart/form-data" id="sendform1" name="sendform1"><input type="file" name="upload_photo1" value="Выбрать файл для загрузки" onchange="sendform1.submit();"></form></div>
		<div class="img-sphinx">		
		{if show_ph2}{if admin}<img src="/files/sphinx/{#id}.jpg" title="Фотоизображение с камеры КПП ПГУ">
		{if !show_ph2}фотография для КПП не загружена
		</div>
		{if admin}<div class="user-btn option"><form action="/portfolio/saveph2/{#id}" method="post" enctype="multipart/form-data" id="sendform2" name="sendform2"><input type="file" name="upload_photo2" value="Выбрать файл для загрузки" onchange="sendform2.submit();"></form></div>		
		{if auth}{if card}<div class="user-btn resume"><a href="/portfolio/{#id}/resume" target="_blank">Резюме</a></div>
		{if auth}{if card}<div class="user-btn resume"><a href="/work" target="_blank">ВУЗ + РАБОТОДАТЕЛЬ</a></div>
	</div>
	<div class="user-par">
		{if code}		<div class="user-row">Табельный/регистрационный номер: {#code} </div>
		{if date_birth}	<div class="user-row">Дата рождения: {#date_birth}</div>
		{if exp}		<div class="user-row">Стаж: {#exp}</div>
		{if exp_pgu}	<div class="user-row">Педагогический стаж: {#exp_pgu}</div>
		{if biography}	<div class="user-row">Биография: {#biography}</div>
        {if my} <div class="user-row">
        {if my}     <span class="bio-edit" onclick="setBio();">Добавить/Изменить биографию</span>
        {if my}     <form action="/portfolio/{#id}"><div class="biography"><textarea cols="30" rows="10" name="biography">{#biography}</textarea><br>
        {if my}            <input type="hidden" name="id_user" value="{#id}"><input type="submit" value="Сохранить" name="save_bio"></form></div>
        {if my} </div>
		{if my}<div class="user-row">Телефон: {#tel} 
		{if my}	<b><a style="cursor: pointer;" onclick="toggle_tree('new_tel', '');">Изменить</a></b>
		{if my}	<div id="new_tel" style="display: none;">
		{if my}		<form action="/portfolio/{#id}/savetel" method="post">
		{if my}			<input type="text" name="tel" value="{#tel}" style="width: 160px;">
		{if my}			<input type="submit" value="Сохранить">
		{if my}		</form>
		{if my}	</div>
		{if my}</div>
		{if my}<div class="user-row">E-mail: {#email} 
		{if my}	<b><a style="cursor: pointer;" onclick="toggle_tree('new_mail', '');">Изменить</a></b>
		{if my}	<div id="new_mail" style="display: none;">
		{if my}		<form action="/portfolio/{#id}/saveemail" method="post">
		{if my}			<input type="text" name="email" value="{#email}" style="width: 160px;">
		{if my}			<input type="submit" value="Сохранить">
		{if my}		</form>
		{if my}	</div>
		{if my}</div>
		{if code}{if contract_list}<div class="msg-grey" style="margin-top: 15px; cursor: pointer;" onclick="toggle_tree('listcontr', '');">Договора:</div>
		{if code}{if contract_list}<div id="listcontr" style="display: none;"><table class="ispgut">{#contract_list}</table></div>
		<div class="user-row">{#list_profile}</div>
	</div>
</div>
<div class="user-menu">
	{if my}<div class="user-btn option">Добавить профили соцсетей 
	{if my}	<form action="/portfolio/{#id}/showdopinfo" method="post">
	{if my}		<div id="div0"></div>
	{if my}		<button onclick="addInput();return false;">Добавить профиль</button>
	{if my}	</div>
	{if my}<div class="user-btn option">Показывать доп. информацию 
	{if my}	<select name="is_show">
	{if my}		<option value="1" {if is_show_user}selected="selected"{/if}{if my}>Да</option>
	{if my}		<option value="0" {if !is_show_user}selected="selected"{/if}{if my}>Нет</option>
	{if my}	</select>
	{if my}	<input type="submit" name="savedop" value="Сохранить">
	{if my}	</form>
	{if my}</div>
	{if my}{if is_owner}<div class="user-btn option"><a href="/portfolio/addconf">Добавить доп. информацию</a></div>	
</div>

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

