<br><div class="msg-warning" style="cursor:pointer;"  onclick="if(document.getElementById('confh{#id}').value=='0') { document.getElementById('conf{#id}').style='border-collapse: collapse;'; document.getElementById('confh{#id}').value='1' } else { document.getElementById('conf{#id}').style='visibility: hidden; position: absolute;'; document.getElementById('confh{#id}').value='0'}"><b><a style="cursor: pointer;" >{#name}&nbsp;<img src="/images/sort1.png"></a></b></div>
<input type="hidden" id=confh{#id} value="0">
<table border="1" id="conf{#id}" class="ispgut" style="visibility: hidden; position: absolute; border-collapse: collapse;" cellpadding="3" cellspacing="0">
<tr align="center" class="ispguth">{#header}</tr>
{#rows}
</table>