{if rows}<div class="msg-good" style="margin-top: 15px; cursor: pointer;" onclick="toggle_tree('listeb', '');"><b>Электронная библиотека</b>&nbsp;<img src="/images/sort1.png"></div>
{if rows}<div id="listeb" style="display: none;">

{if rows}<table class="ispgut">
{if rows}<tr class="ispguth"><td colspan="3">Спискок публикаций в ЭБС ПГУ</td></tr>
{if rows}	<tr class="ispguth"><td>Наименование</td><td>Вид</td><td>Тип</td></tr>
{if rows}	{#rows}
{if rows}</table>
{if rows}</div>