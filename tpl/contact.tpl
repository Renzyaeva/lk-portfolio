<style>
.dep-contacts span {
margin: 6px;
display: block;
}

.ico-d-p::before {
content:url('/images/ico/dep/ico_dep_phone.png');
padding-right: 4px;
}

.ico-d-f::before {
content:url('/images/ico/dep/ico_dep_file.png');
padding-right: 4px;
}

.ico-d-b::before {
content:url('/images/ico/dep/ico_dep_boss.png');
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

<div class="dep-contacts">
<span class="ico-d-f"><a href="/files/docs/pologenie{#id}.pdf" target="_blank">Положение подразделения</a></span>
<span class="ico-d-m"><a href="mailto:{#email}">{#email}</a></span>
<span class="ico-d-p">{#tel}</span>
<span class="ico-d-l">{#addres}</span>
<span class="ico-d-lnk"><a href="http://{#link}">{#link}</a></span>
<span class="ico-d-b">Руководитель: {#boss}</span>
</div>