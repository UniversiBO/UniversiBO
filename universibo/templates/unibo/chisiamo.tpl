{include file=header_index.tpl}

{include file=avviso_notice.tpl}
<h2>{$contacts_langAltTitle|escape:"htmlall"|bbcode2html}</h2>
<hr />
<p>{$contacts_langIntro|escape:"htmlall"|bbcode2html}</p>
<div class="casellacontatto">
{foreach from=$contacts_langPersonal item=temp_curr_people}
	<p class="{cycle values="even,odd"}">{include file=tabellina_contatto.tpl collaboratore=$temp_curr_people}</p>	
{/foreach}
</div>
<hr />
{include file=footer_index.tpl}