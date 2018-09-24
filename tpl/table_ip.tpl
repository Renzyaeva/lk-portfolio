{if admin}<div class="item_nav"><a href="/portfolio/{#id_user}/ippr/{#id_exec}/edit">Редактировать Индивидуальный план</a></div>
<table class="ispgut">
	<tr class="ispguth"><td colspan="2">1. Основные сведения о выпускнике</td></tr>
	<tr><td class="irrp_td_first ispgutd">Наименование кафедры, факультета, отделения</td><td>{#dep}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Имя, отчество, фамилия, год рождения</td><td>{#name}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Наименование осваиваемой ОП</td><td>{#programmitem}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Дополнительные квалификации (указать год обучения; наименование квалификации, количество часов обучения) </td><td>{#dopprogramm}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Место прохождения производственной практики</td><td>{#prpractice}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Место прохождения преддипломной практики</td><td>{#dpractice}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Наличие договора о целевой контрактной подготовке</td><td>{if is_goal}Есть{/if}{if !is_goal}Нет{/if}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Контактные данные</td><td>{#contact}</td></tr>
</table>
<table class="ispgut">
	<tr class="ispguth"><td colspan="2">2. Планируемая трудовая деятельность выпускника</td></tr>
	<tr><td class="irrp_td_first ispgutd">Сфера деятельности</td><td>{#activity}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Трудовые функции</td><td>{#function}</td></tr>
	<tr><td class="irrp_td_first ispgutd">График работы</td><td>{#graf}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Тип занятости</td><td>{#type}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Условия труда</td><td>{#work_condition}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Зарплата</td><td>{#cash}</td></tr>
</table>
<table class="ispgut">
	<tr class="ispguth"><td colspan="5">3-4. План достижения выпускником поставленных целей и анализ выполнения плана</td></tr>
	<tr><td class="irrp_td_plan ispgutd">Наименование мероприятия</td><td class="irrp_td_plan ispgutd">Период осуществления</td><td class="irrp_td_plan ispgutd">Ожидаемый результат</td><td class="irrp_td_plan ispgutd">Выполнено/не выполнено</td><td class="irrp_td_plan ispgutd">Достижения или причины не выполнения</td></tr>
	{#add_plan_list}
</table>
<table class="ispgut">
	<tr class="ispguth"><td colspan="2">5. Сведения о трудоустройстве выпускника</td></tr>
	<tr><td class="irrp_td_first ispgutd">Дата трудоустройства</td><td>{#work_date_begin}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Предприятие (организация)</td><td>{#work_org}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Должность (место работы)</td><td>{#work_position}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Необходимость обучения, переподготовки</td><td>{#work_need_edu}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Условия трудоустройства (постоянная или временная работа)</td><td>{#work_type}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Другие характеристики</td><td>{#work_other}</td></tr>
</table>
<table class="ispgut">
	<tr class="ispguth"><td colspan="2">6. Сведения о продолжении образования выпускника</td></tr>
	<tr><td class="irrp_td_first ispgutd">Дата поступления</td><td>{#dpo_date_begin}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Наименование ОО</td><td>{#dpo_org}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Специальность/наименование программы ДПО</td><td>{#dpo_other}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Форма обучения</td><td>{#dpo_form}</td></tr>
	<tr><td class="irrp_td_first ispgutd">Другие характеристики</td><td>{#dpo_other}</td></tr>
</table>
<table class="ispgut">
	<tr class="ispguth"><td>7. Оценка уровня готовности выпускника к трудовой деятельности</td></tr>
	<tr><td class="irrp_td_first ispgutd">{#ready}</td></tr>
</table>
<div class="msg-neutral" onclick="toggle_tree('new-year', '');">Заполненное через год после выпуска</div>
<div id="new-year">
	<table class="ispgut">
		<tr class="ispguth"><td colspan="2">8. Сведения о трудоустройстве выпускника</td></tr>
		<tr><td class="irrp_td_first ispgutd">Дата трудоустройства</td><td>{#work_date_begin2}</td></tr>
		<tr><td class="irrp_td_first ispgutd">Предприятие (организация)</td><td>{#work_org2}</td></tr>
		<tr><td class="irrp_td_first ispgutd">Должность (место работы)</td><td>{#work_position2}</td></tr>
		<tr><td class="irrp_td_first ispgutd">Необходимость обучения, переподготовки</td><td>{#work_need_edu2}</td></tr>
		<tr><td class="irrp_td_first ispgutd">Условия трудоустройства (постоянная или временная работа)</td><td>{#work_type2}</td></tr>
		<tr><td class="irrp_td_first ispgutd">Другие характеристики</td><td>{#work_other2}</td></tr>
	</table>
	<table class="ispgut">
		<tr class="ispguth"><td colspan="2">9. Сведения о продолжении образования выпускника</td></tr>
		<tr><td class="irrp_td_first ispgutd">Дата поступления</td><td>{#dpo_date_begin2}</td></tr>
		<tr><td class="irrp_td_first ispgutd">Наименование ОО</td><td>{#dpo_org2}</td></tr>
		<tr><td class="irrp_td_first ispgutd">Специальность/наименование программы ДПО</td><td>{#dpo_other2}</td></tr>
		<tr><td class="irrp_td_first ispgutd">Форма обучения</td><td>{#dpo_form2}</td></tr>
		<tr><td class="irrp_td_first ispgutd">Другие характеристики</td><td>{#dpo_other2}</td></tr>
	</table>
</div>
{if upload_file}<div><a href="/files/lk/ippr/{#upload_file}">Скачать загруженный файл</a></div>
<div><a href="/portfolio/{#id_user}/ippr/{#id_exec}/viewdoc">Сформировать документ из формы</a></div>