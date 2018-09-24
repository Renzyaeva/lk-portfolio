<tr>
{if field1}<td>{#name}</td>
{if field2}<td>{#organization}</td>
{if field3}<td>{#topic}</td>
{if field4}<td>{#mentor}</td>
{if field5}<td>{#fonancing}</td>
{if field6}<td>{if url}<a href="{#url}" target="_blank">Перейти на сайт</a>{/if}</td>
{if field7}<td>{if date_begin_unix}{#date_begin_date}</td>
{if field8}<td>{if date_end_unix}{#date_end_date}{/if}</td>
{if field9}<td>{if file_name}<a href="/files/lk/docs/{#id_doc}{#file_name}">файл</a>{/if}</td>
{if field10}<td align="center">{#level}</td>
{if field11}<td>{if url_eb}<a href="{#url_eb}" target="_blank">Посмотреть документ</a>{/if}</td>
{if my}<td><a href="/portfolio/delconf/{#id}"  onclick="if(!confirm('Информация удаляется без возможности восстановления! Продолжить?')) return false;">Удалить</a></td> 
</tr>
