<tr><td style="padding: 4px; width: 40%" >
{if auth}{if card}<a href="/card/{#id_user}" title="Личная карточка учащегося"><img src="/images/card.png" align="absmiddle"></a>&nbsp;{/if}
{if auth}{if !card}<img src="/images/card1.png" align="absmiddle"  title="Личная карточка сотрудника">&nbsp;{/if}
{#i}<a href="/portfolio/{#id_user}">{#name} {#name_group} {#name_department} {if is_deleted}[ЗАБЛОКИРОВАН]{/if}{if is_praepostor}&nbsp;<span style="color: #039660;" title="Староста">&bull;</span>{/if}</a>
{if is_dop}{#rate}
{if is_dop}{if anketa} - <img src="/images/qred.png" width="20" align="bottom" title="Оценен в анкетах: {#anketa} ">{#anketa_url}{/if}
{if is_dop}{if anketa_user} - <img src="/images/qred.png" width="20" align="bottom" title="Учестие в опросах: {#anketa_user}">{#anketa_url_user}{/if}
{if is_dop}{if presence} <font size="-2">(последний проход: {#presence})</font> {/if}
{if is_dop}{if nomark} - <span title="{#nomark}">не выставлены оценки</span>{/if}
{if is_dop}{if noippr} - не заполнен ИППР{/if}
</td><td  style="padding: 4px;">
{if pass}"{#login}" - "{#password}"
{if number}{#id_user}
</td><td></td style="padding: 4px; width: 20%"></tr>

