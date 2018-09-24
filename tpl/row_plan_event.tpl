<tr>
{if is_edit}<td><input class="irrp_plan_input" type="text" name="plan_event[]" value="{#plan_event}" placeholder="Наименование мероприятия"></td>
{if is_edit}<td><input class="irrp_plan_input" type="text" name="plan_period[]" value="{#plan_period}" placeholder="Период осуществления"></td>
{if is_edit}<td><input class="irrp_plan_input" type="text" name="plan_res[]" value="{#plan_res}" placeholder="Ожидаемый результат"></td>
{if is_edit}<td><input class="irrp_plan_input" type="text" name="plan_done[]" value="{#plan_done}" placeholder="Отметка о выполнении"></td>
{if is_edit}<td><input class="irrp_plan_input" type="text" name="plan_reason[]" value="{#plan_reason}" placeholder="Достижения или причины не выполнения"></td>

{if !is_edit}<td>{#plan_event}</td>
{if !is_edit}<td>{#plan_period}</td>
{if !is_edit}<td>{#plan_res}</td>
{if !is_edit}<td>{#plan_done}</td>
{if !is_edit}<td>{#plan_reason}</td>
</tr>