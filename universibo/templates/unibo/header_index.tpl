{config_load file="main.conf"}
{* #docType# *}
{*<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml">*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" lang="it">
<head>
<title>{$common_title|escape:"htmlall"}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta lang="it" name="keywords" content="{$common_metaKeywords|escape:"htmlall"}" />
<meta lang="it" name="description" content="{$common_metaDescription|escape:"htmlall"}" />
{#styleSheet#}
{#favIcon#}
</head> 
<body>
{* inizio tabella di impaginazione GENERALE  *}
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td colspan="3"> {* barra in alto, gif di sinistra LOGO a sfondo BIANCO di dimensioni 150x92,gif per il TITOLO a sfondo del colore della tabella con data e menu di navigazione di dimensioni 600x100 *}
		<div id="header">
			<a href="https://www.universibo.unibo.it/"><img alt="www.universibo.unibo.it" src="tpl/unibo/logo.gif" width="200" height="92" /></a>
			<img id="logo" src="tpl/unibo/logo_{$common_logoType}.gif" alt="Logo UniversiBO" height="92" width="600" /><p class="TimeInfo">{$common_longDate|escape:"htmlall"} &nbsp;-&nbsp;{$common_time|escape:"htmlall"}</p><a href="#content" class="hide">Salta la navigazione</a><p id="Info">|&nbsp;<a href="{$common_contactsUri|escape:"htmlall"}">{$common_contacts|lower|capitalize|escape:"htmlall"|ereg_replace:" ":"&nbsp;"}</a>&nbsp;|&nbsp;<a href="{$common_contributeUri|escape:"htmlall"}">{$common_contribute|lower|capitalize|escape:"htmlall"}</a></p>
		</div> {* /header *}
		<div id="menubar">
			<p id="Menu">|&nbsp;<a href="{$common_helpByTopicUri|escape:"htmlall"}">{$common_help|lower|capitalize|escape:"htmlall"}</a>&nbsp;{if $common_userLoggedIn == 'true'}|&nbsp;<a href="{$common_settingsUri|escape:"htmlall"}">{$common_settings|lower|capitalize|escape:"htmlall"}</a>&nbsp;{/if}|&nbsp;<a href="{$common_forumUri|escape:"htmlall"}">{$common_forum|lower|capitalize|escape:"htmlall"}</a>&nbsp;|&nbsp;<a href="{$common_chatUri|escape:"htmlall"}" target="_blank" title="Apre la finestra di Azzurra.net">{$common_chat|lower|capitalize|escape:"htmlall"|ereg_replace:" ":"&nbsp;"}</a></p>
		</div> {* /menubar *}
</td></tr>
<tr valign="top"> {* INIZIO DEL CORPO CENTRALE DELLA PAGINA (MENU DX E SX E PAG CENTRO) *}
	<td class="evidenzia" rowspan="2" width="200px">
		<div id="leftmenu">
			<ul>
				<li><a href="{$common_homepageUri|escape:"htmlall"}">{$common_homepage|lower|capitalize|escape:"htmlall"}</a></li>
				<li>{$common_fac|lower|capitalize|escape:"htmlall"}
					<ul>{foreach from=$common_facLinks item=temp_currLink}<li><a href="{$temp_currLink.uri|escape:"htmlall"}" >-&nbsp;{$temp_currLink.label|lower|capitalize|escape:"htmlall"}</a></li>{/foreach}</ul>
				</li>
			</ul>
			<ul>
				<li>Servizi
					<ul>{foreach from=$common_servicesLinks item=temp_link}<li><a href="{$temp_link.uri|escape:"htmlall"}" >-&nbsp;{$temp_link.label|lower|capitalize|escape:"htmlall"}</a></li>{/foreach}</ul>
				</li>
			</ul>
			<ul class="lastElemento">
				<li>Informazioni
					<ul>{*<li>-&nbsp;<a href="{$common_helpByTopicUri}" >{$common_help|lower|capitalize|escape:"htmlall"}</a></li>*}<li><a href="{$common_rulesUri}" >-&nbsp;{$common_rules|lower|capitalize|escape:"htmlall"}</a></li>{*<li>-&nbsp;<a href="{$common_contactsUri}" >-&nbsp;{$common_contacts|lower|capitalize|escape:"htmlall"}</a></li>*}{*<li>-&nbsp;<a href="{$common_contributeUri}" >-&nbsp;{$common_contribute|lower|capitalize|escape:"htmlall"}</a></li>*}<li><a href="{$common_manifestoUri}" >-&nbsp;{$common_manifesto|lower|capitalize|escape:"htmlall"}</a></li><li><a href="{$common_creditsUri}" >-&nbsp;{$common_credits|lower|capitalize|escape:"htmlall"}</a></li><li><a href="{$common_docSfUri|escape:"htmlall"}" target="_blank"  title="Apre in un altra finestra" >-&nbsp;{$common_docSf|lower|capitalize|escape:"htmlall"}</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<hr class="hide" />
		{* MyUniversiBO *}
		{if $common_myLinksAvailable=="true"}
		<div class="box">
			<h3><a href="{$common_myUniversiBOUri|escape:"htmlall"}">MyUniversiBO</a></h3>
			<div class="contenuto">
				{foreach name=myuniversibo from=$common_myLinks item=temp_currLink}
				<p><a href="{$temp_currLink.uri|escape:"htmlall"}">{$temp_currLink.label|escape:"htmlall"}</a>
				{if $temp_currLink.ruolo=="R"}&nbsp;<img src="tpl/unibo/icona_r.gif" width="9" height="9" alt="Referente" />{/if}
				{if $temp_currLink.ruolo=="M"}&nbsp;<img src="tpl/unibo/icona_m.gif" width="9" height="9" alt="Moderatore" />{/if}
				{if $temp_currLink.new=="true"}&nbsp;<img src="tpl/unibo/icona_new.gif" width="21" height="9" alt="!NEW!" />{/if}</p>
				{/foreach}
				{if $smarty.foreach.myuniversibo.total == 0}<p>Non hai pagine in MyUniversiBO</p>{/if}
			</div>
		</div>
		{/if}
	  {* FINE MENù DI SINIStrA*}	
</td>
<td>
	{*<p id="seiIn">sei in: <a href="">Home</a></p>*}
	<div id="content"> {* COLONNA MENU CENtrALE *}
	{if $common_alert != ""}
	<div id="alert">{$common_alert|escape:"htmlall"}</div>
	{/if}