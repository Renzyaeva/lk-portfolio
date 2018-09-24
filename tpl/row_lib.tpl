{if row_lib}<tr><td><a href="http://elib.pnzgu.ru/library/{#code}" target="_blank">{#title}</a></td><td>ИР</td><td>{#irtype}</td></tr>

{if row_libdoc}<tr><td><a href="http://elib.pnzgu.ru/library_doc/{#id}" target="_blank">{#name}</a></td><td>ДОК</td><td>{#doctype}</td></tr>
<tr><td colspan="3">
    {if list_comment}{if is_show}<div class="comment_list">Комментарии:<br>{#list_comment}</div>
    <div onclick="toggle_tree('comment_doc{#id}', 'img_comment_doc{#id}')" style="float: right; cursor: pointer;"><img id="img_comment_doc{#id}" src="/images/triangle.png">&nbsp;Комментировать</div>
    <div id="comment_doc{#id}" style="display: none;">
	<form method="post">
	    <textarea name="text_comment" cols="100" placeholder="Оставьте Ваш отзыв на данную работу"></textarea><br>
	    <input type="hidden" name="id_item" value="{#id}">
	    <input type="hidden" name="id_type" value="2">
	    <input type="submit" name="save_comment_doc" value="Отправить" onclick="if(!confirm('Вы уверены, что хотите навсегда удалить комментарий?')) return false;">
	</form>
    </div>
</td>
</tr>