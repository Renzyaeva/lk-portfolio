<script type="text/javascript" language="javascript">
$(function() {
	$("#date_begin").datepicker();
	$("#date_begin").datepicker("option", "dateFormat", "dd.mm.yy");
	$("#date_end").datepicker();
	$("#date_end").datepicker("option", "dateFormat", "dd.mm.yy");
});
</script>

<table class="ispgut">
{if field1}<tr><td width="400">{#field1}:</td><td><input required="required" type="text" name="name" style="width: 450px;"></td></tr>
{if field2}<tr><td>{#field2}:</td><td><input required="required" type="text" name="organization" style="width: 450px;"></td></tr>
{if field3}<tr><td>{#field3}:</td><td><input type="text" name="topic" style="width: 450px;"></td></tr>
{if field4}<tr><td>{#field4}:</td><td><input type="text" name="mentor" style="width: 450px;"></td></tr>
{if field5}<tr><td>{#field5}:</td><td><input type="text" name="financing" style="width: 450px;"></td></tr>
{if field6}<tr><td>{#field6} (без http):</td><td><input type="text" name="url" style="width: 450px;"></td></tr>
{if field7}<tr><td>{#field7}:</td><td><input required="required" type="text" id="date_begin" name="date_begin" placeholder="ДД.ММ.ГГГГ"></td></tr>
{if field8}<tr><td>{#field8}:</td><td><input type="text" id="date_end" name="date_end" placeholder="ДД.ММ.ГГГГ"></td></tr>
{if field9}<tr><td>{#field9}:</td><td><select name="id_doc" style="width: 300px;"><option value="0">-- Выберите документ --</option>{#list_doc}</select></td></tr>
{if field10}<tr><td>{#field10}:</td><td><select name="id_level" style="width: 300px;"><option value="0">Прочее</option><option value="1">ВАК</option><option value="2">РИНЦ</option><option value="3">Scopus</option><option value="4">Web of Science</option></select></td></tr>
{if field11}<tr><td>{#field11} (без http):</td><td><input type="text" name="url_eb" style="width: 450px;"></td></tr>
</table>
<input type="submit" value="Сохранить" name="save">
