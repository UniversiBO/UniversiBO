{config_load file="main.conf"}
{#docType#}
<html>
<head>
<title>{$common_title|escape:"html"}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta lang="it" name="keywords" content="{$common_metaKeywords|escape:"htmlall"}">
<meta lang="it" name="description" content="{$common_metaDescription|escape:"htmlall"}">
{#styleSheet#}
{#favIcon#}
</head>
 
<body>
{* inizio tabella di impaginazione GENERALE  *}
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
	<colgroup>
		<col width="200px" />
		<col />
		<col width="168px" />
	</colgroup>
{* barra in alto, gif di sinistra LOGO a sfondo BIANCO di dimensioni 150x92,gif per il TITOLO a sfondo del colore della tabella con data e menu di navigazione di dimensioni 600x100 *}
<tr>
 	<td colspan="3">
		<div id="header">
			<a href="https://www.universibo.unibo.it/"><img alt="www.universibo.unibo.it" src="tpl/unibo/logo.gif" width="200" height="92"/></a>
			<img src="tpl/unibo/logo_{$common_logoType}" alt="Logo UniversiBO" />
			<p class="TimeInfo">{$common_longDate|escape:"htmlall"} &nbsp;-&nbsp;{$common_time|escape:"htmlall"}</p>
			<a href="#content" class="hide">Salta la navigazione</a>
			<p id="Info">|&nbsp;<a href="{$common_manifestoUri|escape:"htmlall"}">{$common_manifesto|lower|capitalize|escape:"htmlall"}</a>&nbsp;|&nbsp;<a href="{$common_rulesUri|escape:"htmlall"}">{$common_rules|lower|capitalize|escape:"htmlall"}</a>&nbsp;|&nbsp;<a href="{$common_contactsUri|escape:"htmlall"}">{$common_contacts|lower|capitalize|escape:"htmlall"}</a>&nbsp;|&nbsp;<a href="{$common_contributeUri|escape:"htmlall"}">{$common_contribute|lower|capitalize|escape:"htmlall"}</a></p>
		</div> {* /header *}
		<div id="menubar">
			<p id="Menu">|&nbsp;<a href="{$common_helpByTopicUri|escape:"htmlall"}">{$common_help|lower|capitalize|escape:"htmlall"}</a>&nbsp;|&nbsp;<a href="{$common_settingsUri|escape:"htmlall"}">{$common_settings|lower|capitalize|escape:"htmlall"}</a>&nbsp;|&nbsp;<a href="{$common_forumUri|escape:"htmlall"}">{$common_forum|lower|capitalize|escape:"htmlall"}</a></p>
			{* spazio per il login *}

		</div> {* /menubar *}
	</td>
</tr>
{* INIZIO DEL CORPO CENTRALE DELLA PAGINA (MENU DX E SX E PAG CENTRO) *}
<tr valign="top">
	<td class="evidenzia" rowspan="2">
		<div id="leftmenu">
			<ul>
				<li><a href="{$common_homepageUri|escape:"htmlall"}">{$common_homepage|lower|capitalize|escape:"htmlall"}</a></li>
				<li>{$common_fac|lower|capitalize|escape:"htmlall"}
					<ul>
						{foreach from=$common_facLinks item=temp_currLink}
						<li>-&nbsp;<a href="{$temp_currLink.uri|escape:"htmlall"}" >{$temp_currLink.label|lower|capitalize|escape:"htmlall"}</a></li>
						{/foreach}
					</ul>
				</li>
			</ul>
			<ul class="lastElemento">
				<li>Servizi
					<ul>	
					{foreach from=$common_servicesLinks item=temp_link}
						<li>-&nbsp;<a href="{$temp_link.uri}" >{$temp_link.label|lower|capitalize|escape:"htmlall"}</a></li>
					{/foreach}
					<li>-&nbsp;<a href="{$common_helpByTopicUri}" >{$common_helpByTopic|lower|capitalize|escape:"htmlall"}</a></li>
					<li>-&nbsp;<a href="{$common_creditsUri}" >{$common_credits|lower|capitalize|escape:"htmlall"}</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<hr class="hide" />
		{* MyUniversiBO *}
		{if $common_myLinksAvailable=="true"}
		<div class="box">
			<h3>MyUniversiBO</h3>
				{foreach from=$common_myLinks item=temp_currLink}
				<p><a href="{$temp_currLink.uri}">{$temp_currLink.label|lower|capitalize|escape:"htmlall"}</a>
				{if $temp_currLink.ruolo=="R"}&nbsp;<img src="tpl/unibo/icona_3_r.gif" width="9" height="9" alt="Referente" />{/if}
				{if $temp_currLink.ruolo=="M"}&nbsp;<img src="tpl/unibo/icona_3_m.gif" width="9" height="9" alt="Moderatore" />{/if}
				{if $temp_currLink.new=="true"}&nbsp;<img src="tpl/unibo/icona_new.gif" width="21" height="9" alt="!NEW!" />{/if}</p>
				{/foreach}
				<div class="backlink"><a href="http://www.ing.unibo.it/Ingegneria/Eventi/">Tutti gli eventi</a></div>
		</div>
		{/if}
		
</td> {* FINE MENù DI SINIStrA*}
<td>
	{*<p id="seiIn">sei in: <a href="">Home</a></p>*}
	<div id="content"> {* COLONNA MENU CENtrALE *}
	{if $common_alert != ""}
	<div id="alert">{$common_alert|escape:"htmlall"}</div>
	{/if}
	





 


