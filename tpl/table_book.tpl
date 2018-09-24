{if rows}<div class="msg-good" style="margin-top: 15px; cursor: pointer;" onclick="toggle_tree('listlib', '');"><b>Библиотека ПГУ</b>&nbsp;<img src="/images/sort1.png"></div>
{if rows}<div id="listlib" style="display: none;">

{if rows}<table class="ispgut">
{if rows}<tr class="ispguth"><td colspan="4">Список выданных изданий</td></tr>
{if rows}	<tr class="ispguth"><td>Назавние</td><td>дата выдачи</td><td>дата возврата</td><td>статус</td></tr>
{if rows}	{#rows}
{if rows}</table>
{if rows}</div>