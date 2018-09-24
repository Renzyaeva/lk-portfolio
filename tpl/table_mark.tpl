{if rows}<div class="msg-good" style="margin-top: 15px; cursor: pointer;" onclick="toggle_tree('listmark', '');"><b>Студенческая успеваемость</b>&nbsp;<img src="/images/sort1.png"></div>
{if rows}<div id="listmark" style="display: none;">

{if rows}<table class="ispgut">
{if rows}<tr class="ispguth"><td {if is_show}colspan="6"{/if}{if rows}{if !is_show}colspan="4"{/if}{if rows}>Списки изученных дисциплин</td></tr>
{if rows}	<tr class="ispguth"><td>Группа</td><td>Семестр/Курс</td><td>Предмет</td><td>Компетенции</td><td>Тип отчетности</td>{if is_show}<td>Оценка</td>{/if}{if rows}</tr>
{if rows}	{#rows}
{if rows}</table>
{if rows}</div>
