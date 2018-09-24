{if category}<tr><td><a href="/portfolio/{#id_user}/study_cource/{#id}">{#name}</a></td></tr>
{if !category}<tr><td onclick="toggle_tree('mark{#id}', '');">{#name}<div id="mark{#id}" style="display: none;">1{#mark_list}</div></td><td>Преподаватель: <a href="/portfolio/{#id_teacher}">{#name_teacher}</a></td></tr>
