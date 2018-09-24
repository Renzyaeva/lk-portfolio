<script type="text/javascript" language="javascript">

function startau() {
	 $.ajax({
 		type: "POST",
 		url: "http://lk.pnzgu.ru/portfolio/au/",
 		dataType: 'JSON',
 		data: { date: "2018-01-29 17:15:30",
			interval: 30,
 			messages: [
 				{
 				id: 10,
 				operation: "set_active",
 				active: 1,
 				online: 1
 				}
 			]
	  },
 		success: function(data) {
 			alert(data);
 		},
 		error:  function(xhr, str) {
 			alert("Ошибка! Повторите попытку "+xhr.readyState);
 		}
 });
}

</script>

<input type="button" onclick="startau();" value="start">