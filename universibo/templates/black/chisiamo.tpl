{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

{include file=avviso_notice.tpl}

<table summary="chi siamo" width="90%" border="0" cellspacing="0" cellpadding="0">
<tr><td class="Normal" align="left">
		<div align="center">&nbsp;<br /><img src="tpl/black/chi_siamo_30.gif" width="179" height="39" alt="{$contacts_altTitle|escape:"html"}" /></div>
        
      <p>
      {$contacts_intro|escape:"html"}      
      </p>
      

	
{foreach from=$contacts_personal item=temp_curr_people}
	{include file=tabellina_contatto.tpl username=$temp_curr_people.username intro=$temp_curr_people.intro ruolo=$temp_curr_people.ruolo email=$temp_curr_people.email recapito=$temp_curr_people.recapito obiettivi=$temp_curr_people.obiettivi foto=$temp_curr_people.foto id_utente=$temp_curr_people.id_utente}
		<p>&nbsp;</p>	

	
{/foreach}

</td></tr></table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}