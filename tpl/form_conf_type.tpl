<script type="text/javascript">
function SendRequest($var){
    $.ajax({
        type: "POST",
        url: "/ajax/portfolio/addconf",
        data: "id_type="+document.getElementById('id_type').value,
        success: function(response){
		$('#response').html(response);
	}
    });
};
</script>
<form action="/portfolio/addconf" method="post" enctype="multipart/form-data">
Добавить информацию:
<table>
<tr><td>Тип:</td><td><select id="id_type" name="id_type" onchange="SendRequest()"><option value="0">-- Выберите тип информации --</option>{#list_type}</select></td>
</table>
<div id="response"></div>
</form>
