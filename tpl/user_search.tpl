<script type="text/javascript" language="javascript">
{if !noshow}	window.onload = function() {
{if !noshow}		setTimeout("document.getElementById('search_all').style.display = 'none';", 100);
{if !noshow}	}
</script>
<link rel="stylesheet" type="text/css" href="/js/chosen/chosen.css">
<div class="no-print">
	<b>Фильтр: </b>
	<div class="item_nav"><a href="/portfolio/{#url1}">{if student}<b>{/if}Учащиеся{if student}</b>{/if}</a></div>
	<div class="item_nav"><a href="/portfolio/{#url2}">{if empl}<b>{/if}Сотрудники{if empl}</b>{/if}</a></div>
{if u15}	<div class="item_nav"><a href="/portfolio/{#url15}">{if abt}<b>{/if}{if u15}Абитуриенты{if abt}</b>{/if}{if u15}</a></div>
{if u16}	<div class="item_nav"><a href="/portfolio/{#url16}">{if zach}<b>{/if}{if u16}Зачисленные{if zach}</b>{/if}{if u16}</a></div>
{if u18}	<div class="item_nav"><a href="/portfolio/{#url18}">{if goal}<b>{/if}{if u18}Целевой прием{if goal}</b>{/if}{if u18}</a></div>
{if u3}	<div class="item_nav"><a href="/portfolio/{#url3}">{if active}<b>{/if}{if u3}Активные{if active}</b>{/if}{if u3}</a></div>
{if u4}	<div class="item_nav"><a href="/portfolio/{#url4}">{if deleted}<b>{/if}{if u4}Заблокированные{if deleted}</b>{/if}{if u4}</a></div>
	<div class="item_nav"><a href="/portfolio/{#url5}">{if male}<b>{/if}Мужчины{if male}</b>{/if}</a></div>
	<div class="item_nav"><a href="/portfolio/{#url6}">{if female}<b>{/if}Женщины{if female}</b>{/if}</a></div>
{if u12}	<div class="item_nav"><a href="/portfolio/{#url12}">{if russian}<b>{/if}{if u12}РФ{if russian}</b>{/if}{if u12}</a></div>
{if u13}	<div class="item_nav"><a href="/portfolio/{#url13}">{if foreign}<b>{/if}{if u13}Иностранцы{if foreign}</b>{/if}{if u13}</a></div>
	<div class="item_nav"><a href="/portfolio">Полный список</a></div>
	<form action="/portfolio/{#url9}" method="get">
	<div class="item_nav" style="width: 100%" align="left">
		Введите фамилию и/или имя и/или отчество: <input type="text" name="search_text" value="{#search_text}" size="60">
		<span id="search_all" >
	<div class="item_nav" style="width: 100%">
		Подразделение: <select name="dep" class="chosen-select" data-placeholder="Выберите подразделение"><option value="">Все подразделения</option>{#dep_list}</select>
	</div>
	<div class="item_nav" style="width: 100%">
		Категория/форма образования: <select name="category" class="chosen-select" data-placeholder="Выберите категорию"><option value="">Все категории</option>{#category_list}</select>
	</div>
	<div class="item_nav" style="width: 100%">
		Курс обучения: <select name="course" class="chosen-select" data-placeholder="Выберите курс обучения"><option value="">Курс обучения</option>{#course_list}</select>
	</div>
		</span>
		<input type="submit" value="Найти">
		<a onclick="toggle_tree('search_all', '');"  style="cursor: pointer;">Расширенный поиск</a>
	</div>
	{if u11}<div class="item_nav" style="width: 100%"><input type="checkbox" name="full_list" id="all" onchange="location.href='/portfolio/{#url11}'" {if full_list} checked {/if}{if u11}><label for="all">&nbsp;Показать всех</label></div>
	{if u14}<div class="item_nav" style="width: 100%"><input type="checkbox" name="dop" id="dop" onchange="location.href='/portfolio/{#url14}'" {if dop} checked {/if}{if u14}><label for="dop">&nbsp;Вывести дополнительную информацию</label></div>
	{if u17}<div class="item_nav" style="width: 100%"><input type="checkbox" name="pass" id="pass" onchange="location.href='/portfolio/{#url17}'" {if pass} checked {/if}{if u17}><label for="pass">&nbsp;Показать логин/пароль</label></div>
	{if u19}<div class="item_nav" style="width: 100%"><input type="checkbox" name="number" id="number" onchange="location.href='/portfolio/{#url19}'" {if number} checked {/if}{if u19}><label for="number">&nbsp;Показать индивидуальный номер</label></div>
	</form>
</div>
<script type="text/javascript" src="/js/chosen/chosen.jquery.js"></script>
<script src="/js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/chosen/docsupport/init.js" type="text/javascript" charset="utf-8"></script>