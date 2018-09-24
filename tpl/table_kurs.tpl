{if rows_exist}{if rows_exist}<div class="msg-good" style="margin-top: 15px; cursor: pointer;" onclick="toggle_tree('listkurs', '');"><b>Студенческие работы</b>&nbsp;<img src="/images/sort1.png"></div>
{if rows_exist}{if rows_exist}<div id="listkurs" style="display: none;">

{if rows_exist}{if rows}<table class="ispgut">
{if rows_exist}{if rows}	<tr class="ispguth"><td>Тип</td><td>Предмет</td><td>Тема работы</td><td>Оценка</td><td>Отзыв</td><td>Файл</td></tr>
{if rows_exist}{if rows}	{#rows}
{if rows_exist}{if rows}</table>

{if rows_exist}{if rows_mdl}<table class="ispgut">
{if rows_exist}{if rows_mdl}	<tr class="ispguth"><td>Наименование дисциплины</td><td>Тема работы</td></tr>
{if rows_exist}{if rows_mdl}	{#rows_mdl}
{if rows_exist}{if rows_mdl}</table>
{if rows_exist}</div>
