{config_load file="main.conf"}
{#docType#}
<html>
<head>
<title>{$common_title|escape:"html"}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta lang="it" name="keywords" content="{$common_metaKeywords|escape:"htmlall"}">
<meta lang="it" name="description" content="{$common_metaDescription|escape:"htmlall"}">
{#styleSheet#}
</head>
 
<body leftmargin="0" topmargin="0">
{* inizio tabella di impaginazione GENERALE  *}
<table cellspacing="0" cellpadding="0" width="100%" border="0" summary="">
{* barra in alto, gif di sinistra LOGO a sfondo BIANCO di dimensioni 150x92,gif per il TITOLO a sfondo del colore della tabella con data e menu di navigazione di dimensioni 600x100 *}
 <tr>
      <td width="150" align="center"><img border="0" src="tpl/unibo/spacer.gif" width="150" height="1" /><img align="center" border="0" alt="" src="tpl/unibo/logo.gif" /></td>
      <td colspan="4" bgcolor="#0006C2"> <table width="100%" height="92" border="0" background="tpl/unibo/logo_{$common_logoType}.gif" class="table_bg">
          <tr>
            <td><div align="right" class="databar">{$common_longDate} - {$common_time}</div></td>
          </tr>
          <tr>
            <td height="45">&nbsp;</td>
          </tr>
          <tr>
            <td height="19" valign="bottom" class="navbarwhite" >| <a class="navbarHead" href="{$common_manifestoUri}">{$common_manifesto}
              </a> | <a class="navbarHead" href="{$common_rulesUri}" >{$common_rules}</a>
              | <a class="navbarHead" href="{$common_contactsUri}" >{$common_contacts}</a>
              | <a class="navbarHead" href="{$common_contributeUri}" >{$common_contribute}</a></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td bgcolor="#666666" width="150"></td>
      <td colspan="4" bgcolor="#666666" width=""> <table width="100%" align="center" cellspacing="0" bgcolor="#666666" summary="">
            <tr>
              <td width="37%" class="navbarwhite"><div align="left"> |  <a class="navbarHead" href="{$common_helpUri}" >{$common_help}</a> | 
			  <a class="navbarHead" href="{$common_settingsUri}">{$common_settings}</a> |  <a class="navbarHead" href="{$common_forumUri}">{$common_forum}</a> | <a class="navbarHead" href="">Cerca</a></div></td>
              {* spazio per il login *}
              <td width="57%" align="right" class="navbar ">
{if $common_userLoggedIn=='false'}
<form action="{$common_receiverUrl}?do=Login" name="form1_a" method="post">
<div align="right">username <input name="f1_username" maxlength="25" type="text" class="navbarForm" size="15" />
                  password <input name="f1_password" maxlength="25" type="password" class="navbarForm" size="15" />
</div></td><td width="6%" align="right"><div align="left"><input name="f1_submit" type="submit" value="Login" onclick="document.form1_a.f1_resolution.value = screen.width;" /></div></form>
{else}
bevenuto username
{/if}
</td></tr>
        </table></td>
    </tr>
    {* INIZIO DEL CORPO CENTRALE DELLA PAGINA (MENU DX E SX E PAG CENTRO) *}
    <tr>
      {* SECONDA RIGA *}
      <td class="Normal" valign="top" align="left" width="150">
        {* COLONNA MENù DI SINISTRA *}
        <table cellspacing="0" cellpadding="2" border="0" summary="" background="tpl/unibo/pixel_2.gif">
            <tr valign="top">
              <td valign="top"> <table cellspacing="0" cellpadding="1" width="100%" align="center" border="0" summary="">
                  {* primo blocchetto *}
                    <tr><br/>
                      <td class="BgMenu1livOn" width="18"><img height="9" alt=""  src="tpl/unibo/navig_freccia3.gif" width="18" /></td>
                      <td class="BgMenu1livOn" width="100%" colspan="2"><span class="menu">{$common_homepage}</span></td>
                    </tr>
                    <tr>
                      <td width="18"><img height="9" alt="" src="tpl/unibo/spacer.gif" width="18" /></td>
                      <td class="menu">Facoltà</a></td>
                    </tr>
{foreach from=$common_facLinks item=temp_currLink}
<tr>
	<td width="18"><img height="9" width="1" alt="" src="tpl/unibo/spacer.gif" width="18" /></td>
	<td colspan="2"><a class="menu_piccolo" href="{$temp_currLink.uri}">- {$temp_currLink.label|lower|capitalize|escape:"htmlall"}</a></td>
</tr>
{/foreach}
                </table></td>
            </tr>
            <tr>
              {*linea - separatore*}
              <td bgcolor="#999999" height="1" colspan="3"></td>
            </tr>
            <tr>
              <td><table cellspacing="0" cellpadding="1" width="100%" align="center" border="0" summary="">
                  {* secondo blocchetto *}
{foreach from=$common_servicesLinks item=temp_link}
<tr>
  <td width="18"><img height="9" alt="" src="tpl/unibo/spacer.gif" width="18" /></td>
  <td colspan="2"><a class="menu" href="{$temp_link.uri}">{$temp_link.label}</a></td>
</tr>
{/foreach}
                </table></td>
            </tr>
              {*linea - separatore*}
            <tr> 
              <td bgcolor="#999999" height="1" colspan="3" width="150"></td>
            </tr>
            <tr> 
              <td> <table cellspacing="0" cellpadding="1" width="100%" align="center" border="0" summary="">
                  {* quarto blocchetto *}
                    <tr> 
                      <td width="18"><img height="9" alt="" src="tpl/unibo/spacer.gif" width="18" /></td>
                      <td colspan="2"><a class="menu" href="">My UniversiBO</a></td>
                    </tr>
                    <tr> 
                      <td width="18"><img height="9" alt="" src="tpl/unibo/spacer.gif" width="18" /></td>
                      <td colspan="2"><a class="menu" href="">I miei Link</a></td>
                    </tr>
                </table></td>
            </tr>
        </table>
        {* FINE MENù DI SINIStrA*}
      <td class="Normal" valign="top" align="center" width="90%"> 






 


