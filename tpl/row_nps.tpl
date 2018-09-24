{if i}<tr class="nps-row-th"><td style="text-align: center;">{#i}</td><td><a href="http://lk.pnzgu.ru/portfolio/{#id_user}" itemprop="fio" target="_blank">{#name}</a></td><td>{#education}</td></tr>{/if}
<tr style="font-size: 10px;" class="nps-row-title"><td style="text-align: center;"><img src="/images/triangle_dwn.png" width="12px;" /></td><td colspan="3"><span itemprop="Post">{#name_position}</span>, <a href="/employees/dep/{#id_department}{#all}">{#name_department}</a>, <a href="/employees/pardep/{#id_parentdep}{#all}">{#name_parentdep}</a>, в должности с {#date_begin_date}</tr></td>
<tr style="font-size: 10px; background: #eee; padding-left: 5%;" class="nps-row-body"><td colspan="4">
<div>{#exp}</div>
{if site}<div><b>Контакты подразделения:</b> {#site}</div>{/if}
{if subject_list}<div><b>Список преподаваемых дисциплин:</b></div>{#subject_list}{/if}
</td></tr>