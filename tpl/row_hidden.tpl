if(val == '{#id}') {
	document.getElementById(id2).innerHTML = '<table class="ispgut">\
	<tr><td><b>Серия: </b></td><td><input type="text" name="series"></td></tr>\
	<tr><td><b>Номер: </b></td><td><input type="text" name="number" required="required"></td></tr>\
	<tr><td><b>Дата начала действия (выдачи): </b></td><td><input required="required" placeholder="ДД.ММ.ГГГГ" type="text" id="date_begin" name="date_begin"></td></tr>\
	<tr><td><b>Дата окончания действия (если есть): </b></td><td><input placeholder="ДД.ММ.ГГГГ" type="text" id="date_end" name="date_end"><input type="hidden" name="doc_type_js" id="{#doc_type_value_js}" value="{#doc_type_value_js}"></td></tr>\
	{if field1}<tr><td><b>{#field1}</b></td><td><input type="text" name="dop_info1"></td></tr>\
	{if field2}<tr><td><b>{#field2}</b></td><td><input type="text" name="dop_info2"></td></tr>\
	{if field3}<tr><td><b>{#field3}</b></td><td><input type="text" name="dop_info3"></td></tr>\
	{if field4}<tr><td><b>{#field4}</b></td><td><input type="text" name="dop_info4"></td></tr>\
	{if field5}<tr><td><b>{#field5}</b></td><td><input type="text" name="dop_info5"></td></tr>\
	{if field6}<tr><td><b>{#field6}</b></td><td><input type="text" name="dop_info6"></td></tr>\
	</table>';
}
