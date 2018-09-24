<script type="text/javascript" language="javascript">
var id=0, id1=0, id2=0;
$( function() {
	$( "#datepicker" ).datepicker();
	$( "#datepicker" ).datepicker( "option", "dateFormat", "dd.mm.yy" );
	$( "#datepicker" ).datepicker( "setDate", "{#date_birth}" );
} );
function lifeSelect(id, id2) {
	var selind = document.getElementById(id).options.selectedIndex;
	var val= document.getElementById(id).options[selind].value;
	{#row_hidden}
	$( "#date_begin" ).datepicker();
	$( "#date_begin" ).datepicker( "option", "dateFormat", "dd.mm.yy" );
	$( "#date_end" ).datepicker();
	$( "#date_end" ).datepicker( "option", "dateFormat", "dd.mm.yy" );	
}
</script>
Добавить документ:
<form action="/portfolio/adddoc" method="post" enctype="multipart/form-data">
<table>
<tr><td>Тип документа:</td><td><select required="required" name="id_type" id="doc_type" onchange="lifeSelect('doc_type','doc_div'); return false;"><option value="0">-- Выберите тип документа --</option>{#list_type}</select></td>
</table>


		<form action="/portfolio/adddoc" method="post" enctype="multipart/form-data">
		<div id="doc_div">
		</div>
Прикрепить файл:<input type="file" name="upload_file" value="" maxlength="65" style="width: 400px;"><br>  		
<input type="submit" value="Сохранить" name="save">
</form>	
