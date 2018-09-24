<script>
$(document).ready(function(){
$('.nps-row-body').hide();
$('.nps-row-title').click(function(){
$(this).toggleClass('opened').toggleClass('closed').next().toggle();
});
});
</script>

<style>
.nps-row-body {
display:none;
}

.ispgut tr:hover {
background: #fff;
}

.nps-row-title {
cursor: pointer;
background: #eee;
}

.nps-row-title:hover {
background: #f00;
}

.nps-row-body div {
width: 95%;
padding: 3px 0;
border-bottom: 1px solid #ccc;
margin-left: 5%;
}

.imgafter::after {
content: url('/images/ico/dep/ico_dep_phone.png');
position: absolute;
}

.ico-d-p::before {
content:url('/images/ico/dep/ico_dep_phone.png');
padding-right: 4px;
}

.ico-d-lnk::before {
content:url('/images/ico/dep/ico_dep_link2.png');
padding-right: 4px;
}

.ico-d-a::before {
content:url('/images/ico/dep/ico_dep_all.png');
padding-right: 4px;
}

.ico-d-m::before {
content:url('/images/ico/dep/ico_dep_mail.png');
padding-right: 4px;
}

.ico-d-n::before {
content:url('/images/ico/dep/ico_dep_nps.png');
padding-right: 4px;
}

.ico-d-l::before {
content:url('/images/ico/dep/ico_dep_loc.png');
padding-right: 4px;
}
</style>
<table class="ispgut" style="text-align: left;">
<tr class="ispguth2">

<td width="5%">
№
</td>

<td width="35%">
Ф.И.О.
</td>

<td width="60%">
Ученая степень, учёное звание, образование
</td>

</tr>
{#rows}
</table>