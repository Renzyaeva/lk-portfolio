{if name_department}<br><b>{#name_department}</b><br>
{if course}<br><b>{#course} курс</b><br>  
<a href="{if !is_hidden}/portfolio/study_group/{#id}{/if}{if is_dop}/dop{/if}" {if is_hidden}onclick="alert('За информацией о группе следует обращаться в деканат'); return false;"{/if}>{#name}</a>