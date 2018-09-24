{if rows}<div class="msg-good" style="margin-top: 15px; cursor: pointer;" onclick="toggle_tree('listpos', '');"><b>Посещаемость</b>&nbsp;<img src="/images/sort1.png"></div>
{if rows}<div id="listpos" style="display: {if id}block;{/if}{if rows}{if !id}none;{/if}{if rows}">
{if meet}<select name="id_meet" onchange="location.href='/portfolio/room/{#id}/id_meet/'+this.value"><option value="0">выберите встречу</option>{#meet}</select>
{if !id_meet}{if id}<form action="/portfolio/room/{#id}" method="post"><input type="text" name="date_begin" value="{#date_begin}"><input type="text" name="date_end" value="{#date_end}"><input type="submit" value="ОК"></form>
{if meet}<br><b>Присутствуют: {#count_pres} из {#count_user}</b><br>
{if rows}<table class="ispgut">
{if !meet}{if rows}<tr class="ispguth"><td colspan="3">Список посещенных занятий/проходов на территорию</td></tr>
{if rows}	<tr class="ispguth"><td>Дата</td><td>{if !meet}№ пары{/if}{if rows}</td><td>{if !meet}Аудитория/проходная{/if}{if rows}{if meet}ФИО{/if}{if rows}</td></tr>
{if rows}	{#rows}
{if rows}</table>
{if rows}{if url}<button type="button" onclick="window.open('{#url}/print', '_blank');">Печать</button>
{if rows}</div>
{if meet}{if url}Скопировать участников из <select name="id_meet1" onchange="if(!confirm('Скопировать список?')) return false; else location.href='/portfolio/room/{#id}/id_meet/{#id_meet}/addusr/'+this.value"><option value="0">выберите встречу</option>{#meet}</select>
