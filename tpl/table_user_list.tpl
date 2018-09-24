<link rel="stylesheet" type="text/css" href="/js/chosen/chosen.css">

<script type="application/javascript">
    $(function () {

    });
    $(document).ready(function() {
        $('#item-curator').change(function () {
            let item_exec = $('#item-curator').val();
            //alert(item_exec);
            let id_group = {#id_group};
            if(!id_group) id_group = 0;
            if(!item_exec) item_exec = 0;
            $(location).attr('href', '/portfolio/study_group/' + id_group + '/set_curator/' + item_exec);
        });
    });
</script>

<table class='ispgut' {if print} style='font-size: 18px !important;'{/if}>
    {if print}<tr align='center'><td>ФИО</td><td>"Логин" - "Пароль"</td><td>Подпись</td></tr>
    {if !print}<tr>
    {if !print}    <td>
            {if !print}{if is_pass}         Куратор: <select name="curator" id="item-curator" class="chosen-select" ><option value="">Выберите куратора группы</option>{#list_curator}</select>
    {if !print}    </td>
    {if !print}<td colspan="2" align="right">{#select_dop}</td>
    </tr>
    {#rows}
</table>

<script type="text/javascript" src="/js/chosen/chosen.jquery.js"></script>
<script src="/js/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/chosen/docsupport/init.js" type="text/javascript" charset="utf-8"></script>

