<tr><td align="center">{#name}</td><td align="center">{#discipline_index}. {#coursename}</td><td>{#theme}</td><td align="center">{#grade}</td><td>{if commenttext}{#commenttext}{/if}</td><td align="center">{if filename}<a href="http://moodle.pnzgu.ru/pluginfile.php/{#contextid}/assignsubmission_file/submission_files/{#submission}/{#filename}?forcedownload=1">Скачать</a>{/if}</td></tr>
<tr><td colspan="6">
    {if list_comment}{if is_show}<div class="comment_list">Комментарии:<br>{#list_comment}</div>
    <div onclick="toggle_tree('comment_kurs{#contextid}', 'img_comment{#contextid}')" style="float: right; cursor: pointer;"><img id="img_comment{#contextid}" src="/images/triangle.png">&nbsp;Комментировать</div>
    <div id="comment_kurs{#contextid}" style="display: none;">
	<form method="post">
	    <textarea name="text_comment" cols="100" placeholder="Оставьте Ваш отзыв на данную работу"></textarea><br>
	    <input type="hidden" name="id_item" value="{#contextid}">
	    <input type="hidden" name="id_type" value="1">
	    <input type="submit" name="save_comment_kurs" value="Отправить" onclick="if(!confirm(\'Вы уверены, что хотите навсегда удалить комментарий?\')) return false;">
	</form>
    </div>
</td>
</tr>