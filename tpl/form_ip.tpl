<script type="text/javascript" language="javascript">
$(function() {
	$("#work_date_begin").datepicker();
	$("#work_date_begin").datepicker("option", "dateFormat", "dd.mm.yy");
	$("#work_date_begin").datepicker("setDate", "{#work_date_begin}");
	$("#dpo_date_begin").datepicker();
	$("#dpo_date_begin").datepicker("option", "dateFormat", "dd.mm.yy");
	$("#dpo_date_begin").datepicker("setDate", "{#dpo_date_begin}");
    $("#work_date_begin2").datepicker();
    $("#work_date_begin2").datepicker("option", "dateFormat", "dd.mm.yy");
    $("#work_date_begin2").datepicker("setDate", "{#work_date_begin2}");
    $("#dpo_date_begin2").datepicker();
    $("#dpo_date_begin2").datepicker("option", "dateFormat", "dd.mm.yy");
    $("#dpo_date_begin2").datepicker("setDate", "{#dpo_date_begin2}");
});
var id=0;
function addInput() {
	var newTR = document.createElement('tr');
  	newTR.innerHTML = '<td><input class="irrp_plan_input" type="text" name="plan_event[]" placeholder="Наименование мероприятия"></td><td><input class="irrp_plan_input" type="text" name="plan_period[]" placeholder="Период осуществления"></td><td><input class="irrp_plan_input" type="text" name="plan_res[]" placeholder="Ожидаемый результат"></td><td><input class="irrp_plan_input" type="text" name="plan_done[]" placeholder="Отметка о выполнении"></td><td><input class="irrp_plan_input" type="text" name="plan_reason[]" placeholder="Достижения или причины не выполнения"></td>';
	tbl_plan.appendChild(newTR);	
}
</script>
<form action="/portfolio/{#id_user}/ippr/{#id_exec}" method="post" enctype="multipart/form-data">
    <table class="ispgut">
        <tr class="ispguth"><td colspan="2">1. Основные сведения о выпускнике</td></tr>
        <tr><td class="irrp_td_first">Наименование кафедры, факультета, отделения</td><td>{#dep}</td></tr>
        <tr><td class="irrp_td_first">Имя, отчество, фамилия, год рождения</td><td>{#name}</td></tr>
        <tr><td class="irrp_td_first">Наименование осваиваемой ОП</td><td>{#programmitem}</td></tr>
        <tr><td class="irrp_td_first">Дополнительные квалификации (указать год обучения; наименование квалификации, количество часов обучения) </td><td><input class="irrp_input" type="text" name="dopprogramm" value="{#dopprogramm}"></td></tr>
        <tr><td class="irrp_td_first">Место прохождения производственной практики</td><td><input class="irrp_input" type="text" name="prpractice" value="{#prpractice}" required></td></tr>
        <tr><td class="irrp_td_first">Место прохождения преддипломной практики</td><td><input class="irrp_input" type="text" name="dpractice" value="{#dpractice}" required></td></tr>
        <tr><td class="irrp_td_first">Наличие договора о целевой контрактной подготовке</td><td><input type="checkbox" name="is_goal" {if is_goal} checked="checked" {/if}></td></tr>
        <tr><td class="irrp_td_first">Контактные данные</td><td>{#contact}</td></tr>
    </table>
    <table class="ispgut">
        <tr class="ispguth"><td colspan="2">2. Планируемая трудовая деятельность выпускника</td></tr>
        <tr><td class="irrp_td_first">Сфера деятельности</td><td><input class="irrp_input" type="text" name="activity" value="{#activity}" required></td></tr>
        <tr><td class="irrp_td_first">Трудовые функции</td><td><input class="irrp_input" type="text" name="function" value="{#function}" required></td></tr>
        <tr><td class="irrp_td_first">График работы</td><td><input class="irrp_input" type="text" name="graf" value="{#graf}" required></td></tr>
        <tr><td class="irrp_td_first">Тип занятости</td><td><input class="irrp_input" type="text" name="type" value="{#type}" required></td></tr>
        <tr><td class="irrp_td_first">Условия труда</td><td><input class="irrp_input" type="text" name="work_condition" value="{#work_condition}" required></td></tr>
        <tr><td class="irrp_td_first">Зарплата</td><td><input class="irrp_input" type="text" name="cash" value="{#cash}"></td></tr>
    </table>
    <table class="ispgut plan" id="tbl_plan">
        <tr class="ispguth"><td colspan="5">3-4. План достижения выпускником поставленных целей и анализ выполнения плана</td></tr>
        <tr><td class="irrp_td_plan">Наименование мероприятия</td><td class="irrp_td_plan">Период осуществления</td><td class="irrp_td_plan">Ожидаемый результат</td><td class="irrp_td_plan">Выполнено/не выполнено</td><td class="irrp_td_plan">Достижения или причины не выполнения</td></tr>
        {#add_plan_list}
        <tr><td colspan="5"><button style="float: right;" onclick="addInput();return false;">Добавить дополнительное мероприятие плана</button></td></tr>
    </table>
    <table class="ispgut">
        <tr class="ispguth"><td colspan="2">5. Сведения о трудоустройстве выпускника</td></tr>
        <tr><td class="irrp_td_first">Дата трудоустройства</td><td><input class="irrp_input" type="text" id="work_date_begin" name="work_date_begin" value="{#work_date_begin}"></td></tr>
        <tr><td class="irrp_td_first">Предприятие (организация)</td><td><input class="irrp_input" type="text" name="work_org" value="{#work_org}"></td></tr>
        <tr><td class="irrp_td_first">Должность (место работы)</td><td><input class="irrp_input" type="text" name="work_position" value="{#work_position}"></td></tr>
        <tr><td class="irrp_td_first">Необходимость обучения, переподготовки</td><td><input class="irrp_input" type="text" name="work_need_edu" value="{#work_need_edu}"></td></tr>
        <tr><td class="irrp_td_first">Условия трудоустройства (постоянная или временная работа)</td><td><input class="irrp_input" type="text" name="work_type" value="{#work_type}"></td></tr>
        <tr><td class="irrp_td_first">Другие характеристики</td><td><input class="irrp_input" type="text" name="work_other" value="{#work_other}"></td></tr>
    </table>
    <table class="ispgut">
        <tr class="ispguth"><td colspan="2">6. Сведения о продолжении образования выпускника</td></tr>
        <tr><td class="irrp_td_first">Дата поступления</td><td><input class="irrp_input" type="text" id="dpo_date_begin" name="dpo_date_begin" value="{#dpo_date_begin}"></td></tr>
        <tr><td class="irrp_td_first">Наименование ОО</td><td><input class="irrp_input" type="text" name="dpo_org" value="{#dpo_org}"></td></tr>
        <tr><td class="irrp_td_first">Специальность/наименование программы ДПО</td><td><input class="irrp_input" type="text" name="dpo_spec" value="{#dpo_spec}"></td></tr>
        <tr><td class="irrp_td_first">Форма обучения</td><td><input class="irrp_input" type="text" name="dpo_form" value="{#dpo_form}"></td></tr>
        <tr><td class="irrp_td_first">Другие характеристики</td><td><input class="irrp_input" type="text" name="dpo_other" value="{#dpo_other}"></td></tr>
    </table>
	<table class="ispgut">
		<tr class="ispguth"><td colspan="2">7. Оценка уровня готовности выпускника к трудовой деятельности</td></tr>
		<tr><td class="irrp_td_first"><textarea name="ready" rows="2" cols="120">{#ready}</textarea></td></tr>
	</table>
    <div>Прикрепить файл:<input type="file" name="upload_file" value="" maxlength="65"><br></div>
    <div class="msg-neutral" onclick="toggle_tree('new-year', '');" style="cursor: pointer">Заполняется через год после выпуска</div>
    <div id="new-year"  style="display: none;">
        <table class="ispgut">
            <tr class="ispguth"><td colspan="2">8. Сведения о трудоустройстве выпускника</td></tr>
            <tr><td class="irrp_td_first">Дата трудоустройства</td><td><input class="irrp_input" type="text" id="work_date_begin2" name="work_date_begin2" value="{#work_date_begin2}"></td></tr>
            <tr><td class="irrp_td_first">Предприятие (организация)</td><td><input class="irrp_input" type="text" name="work_org2" value="{#work_org2}"></td></tr>
            <tr><td class="irrp_td_first">Должность (место работы)</td><td><input class="irrp_input" type="text" name="work_position2" value="{#work_position2}"></td></tr>
            <tr><td class="irrp_td_first">Необходимость обучения, переподготовки</td><td><input class="irrp_input" type="text" name="work_need_edu2" value="{#work_need_edu2}"></td></tr>
            <tr><td class="irrp_td_first">Условия трудоустройства (постоянная или временная работа)</td><td><input class="irrp_input" type="text" name="work_type2" value="{#work_type2}"></td></tr>
            <tr><td class="irrp_td_first">Другие характеристики</td><td><input class="irrp_input" type="text" name="work_other2" value="{#work_other2}"></td></tr>
        </table>
        <table class="ispgut">
            <tr class="ispguth"><td colspan="2">9. Сведения о продолжении образования выпускника</td></tr>
            <tr><td class="irrp_td_first">Дата поступления</td><td><input class="irrp_input" type="text" id="dpo_date_begin2" name="dpo_date_begin2" value="{#dpo_date_begin2}"></td></tr>
            <tr><td class="irrp_td_first">Наименование ОО</td><td><input class="irrp_input" type="text" name="dpo_org2" value="{#dpo_org2}"></td></tr>
            <tr><td class="irrp_td_first">Специальность/наименование программы ДПО</td><td><input class="irrp_input" type="text" name="dpo_spec2" value="{#dpo_spec2}"></td></tr>
            <tr><td class="irrp_td_first">Форма обучения</td><td><input class="irrp_input" type="text" name="dpo_form2" value="{#dpo_form2}"></td></tr>
            <tr><td class="irrp_td_first">Другие характеристики</td><td><input class="irrp_input" type="text" name="dpo_other2" value="{#dpo_other2}"></td></tr>
        </table>
    </div>

<input type="submit" value="Сохранить" name="save_ippr">

<input type="hidden" name="id_user" value="{#id_user}">
<input type="hidden" name="id_exec" value="{#id_exec}">
<input type="hidden" name="id" value="{#id}">

</form>