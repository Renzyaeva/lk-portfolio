<script>
$(document).ready(function(){
$('.spoiler-body').hide();
$('.spoiler-title').click(function(){
$(this).toggleClass('opened').toggleClass('closed').next().toggle();
});
});
</script>


<style>
.spoiler-body {
	display:none;
}

.spoiler-title {
	background: #eee;
}

.spoiler-body span {
width: 95%;
padding: 3px 0;
border-bottom: 1px solid #ccc;
margin-left: 5%;
display: block;
}

.spoiler-body td:hover {
background: #fff;
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

.ico-d-b::before {
	content:url('/images/ico/dep/ico_dep_boss.png'); 
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
{#rows}
</table>