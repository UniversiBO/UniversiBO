{include file=header_index.tpl}

{include file=avviso_notice.tpl}
<h2>{$contacts_langAltTitle|escape:"htmlall"|bbcode2html}</h2>
<p>{$contacts_langIntro|escape:"htmlall"|bbcode2html}</p>
<hr />
{foreach from=$contacts_langPersonal item=temp_curr_people}
	{include file=tabellina_contatto.tpl collaboratore=$temp_curr_people}	
{/foreach}
{include file=footer_index.tpl}