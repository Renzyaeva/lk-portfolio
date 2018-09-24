{if field1}</table><br><table class="ispgut" style="padding: 5px; border-collapse: collapse;" cellpadding="5" cellspacing="0" border="1"><tr class="ispguth"><td>Название</td><td>Серия</td><td>Номер</td>{if field1}<td>{#field1}</td>{/if}{if field2}<td>{#field2}</td>{/if}{if field3}<td>{#field3}</td>{/if}{if field4}<td>{#field4}</td>{/if}{if field5}<td>{#field5}</td>{/if}{if field6}<td>{#field6}</td>{/if}{if field7}<td>{#field7}</td>{/if}{if field8}<td>{#field8}</td>{/if}{if field1}<td>Дата выдачи/действия</td><td>Дата внесения</td></tr>
<tr>
<td>{if file_name}<a title="Просмотреть" href="/files/lk/docs/{#id}{#file_name}">{/if}{#name}{if file_name}</a>{/if}</td>
<td>{#series}</td>
<td>{#number}</td>
{if dop_info1}<td>{#dop_info1}</td>
{if dop_info2}<td>{#dop_info2}</td>
{if dop_info3}<td>{#dop_info3}</td>
{if dop_info4}<td>{#dop_info4}</td>
{if dop_info5}<td>{#dop_info5}</td>
{if dop_info6}<td>{#dop_info6}</td>
{if dop_info7}<td>{#dop_info7}</td>
{if dop_info8}<td>{#dop_info8}</td>
<td>с {#date_begin_date}
{if date_end_unix} по {#date_end_date}
</td>
<td>{#date_date}</td>
{if my}<td><a href="/portfolio/deldoc/{#id}" onclick="if(!confirm('Информация удаляется без возможности восстановления! Продолжить?')) return false;">Удалить</a></td> 
</tr>