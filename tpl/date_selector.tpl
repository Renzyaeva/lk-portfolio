<script type="text/javascript" language="javascript">
$(function() {
	$("#datepicker").datepicker();
	$("#datepicker").datepicker("option", "dateFormat", "yy-mm-dd");
	$("#datepicker").datepicker("setDate", "{#date_err}");
});
</script>
<form method="post" name="personal">
	Выберите дату для сортировки:&nbsp;<input id="datepicker" type="text" placeholder="ГГГГ-ММ-ДД" name="date_err" value="{#date_err}" onchange="location.href='/portfolio/err/'+this.value">
</form>