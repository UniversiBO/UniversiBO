{$config_docType}
<html>
<head>
<title>{$common_title|escape:"html"}</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta lang="it" name="keywords" content="{$common_metaKeywords|escape:"htmlall"}">
<meta lang="it" name="description" content="{$common_metaDescription|escape:"htmlall"}">
{$config_styleSheet}
</head>
 
<body text="#FFFFFF" bgcolor="#000000" > <!--leftmargin="0" rightmargin="0" topmargin="0" marginwidth="0" marginheight="0"-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td align="center">
<!-- Inizio Testa -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
{if $common_alert != ""}
<tr><td class="Normal" align="center"><font color="#FF0000">{$common_alert|escape:"htmlall"}</font></td></tr>
{/if}
<tr><td bgcolor="#000099"><img src="tpl/black/rule_grande.gif" width="625" height="4" alt="" /></td></tr>
<tr><td bgcolor="#000099"><img src="tpl/black/universibo_45_{$common_logoType}.gif" width="516" height="54" alt="{$common_logo}" /></td></tr>
<tr><td bgcolor="#000099"><img src="tpl/black/rule_grande.gif" width="625" height="4" alt="" /></td></tr>
<tr><td bgcolor="#000050">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
 <tr>
 <td valign="middle" align="left" class="Navbar">&nbsp;&nbsp;<a href="forum/" target="_blank">&nbsp;<img src="tpl/black/forum_omini.gif" width="16" height="20" border="0" alt="" />&nbsp;Forum&nbsp;</a>&nbsp;&nbsp;&nbsp;</td><td width="100%">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
	<tr><td class="Titolo" align="right">{$common_longDate} - {$common_time}&nbsp;&nbsp;</td></tr>
	<tr><td bgcolor="#000099"><img src="tpl/black/rule_darkL.gif" width="100" height="2" alt="" /></td></tr>
 	<tr><td class="PiccoloC" align="right">
 <a style="cursor:hand" onclick="this.style.behavior='url(#default#homepage)';this.setHomePage('{$common_rootUrl}');" ><img src="tpl/black/add_home.gif" width="13" height="12" alt="" border="0" />&nbsp;<font style='COLOR: #55A0D0; text-decoration:underline' >{$common_setHomepage|escape:"htmlall"|replace:" ":"&nbsp;"}</font></a>&nbsp;&nbsp;
 <a href="javascript:window.external.AddFavorite('{$common_rootUrl}','{$common_universibo}')"><img src="tpl/black/add_preferiti.gif" width="14" height="12" alt="" border="0" />&nbsp;<font style='COLOR: #55A0D0; text-decoration:underline' >{$common_addBookmarks|escape:"htmlall"|replace:" ":"&nbsp;"}</font></a>&nbsp;&nbsp;
 </td>
 </tr>
 </table>

 </td>
 </tr>
 </table>
</td></tr>
<tr><td bgcolor="#000099"><img src="tpl/black/rule_grande.gif" width="625" height="4" alt="" /></td></tr>
</table>
<!-- Fine Testa --> </td></tr>
<tr><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td width="175" valign="top" align="center" class="Normal">&nbsp;<br />
<!-- Inizio MENU Left --><table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr valign="bottom"> 
<td height="12" width="12"><img src="tpl/black/menuTL.gif" width="12" height="12" alt="" /></td>
<td height="12" align="left"><img src="tpl/black/menuT.gif" width="67" height="12" alt="" /></td>
<td height="12" width="12"><img src="tpl/black/invisible.gif" width="1" height="12" alt="" /></td>
</tr>
<tr> 
<td width="12" valign="top"><img src="tpl/black/menuL.gif" width="12" height="67" alt="" /></td>
<td valign="top">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
<tr> 
    <td colspan="2"> <img src="tpl/black/facolta_di_ingegneria_18.gif" width="111" height="42" alt="Facolt&agrave;" /></td>
</tr>
<tr>
    <td class="Menu" colspan="2" align="center">&nbsp;<br />Lauree Triennali</td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
		<td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0046&amp;anno_accademico=2002" >0046 - delle Telecomunicazioni</a>
    </td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0047&amp;anno_accademico=2002" >0047 - Elettrica</a>
    </td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0048&amp;anno_accademico=2002" >0048 - Elettronica</a>
    </td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0049&amp;anno_accademico=2002" >0049 - Gestionale</a>
    </td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0050&amp;anno_accademico=2002" >0050 - dei Processi Gestionali</a>
    </td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0051&amp;anno_accademico=2002" >0051 - Informatica</a>
    </td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0055&amp;anno_accademico=2002" >0055 - dell'Automazione</a>
    </td>
</tr>


<tr>
    <td class="Menu" colspan="2" align="center">&nbsp;<br />Lauree Specialistiche</td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0231&amp;anno_accademico=2002" >0231 - delle Telecomunicazioni</a>
    </td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0232&amp;anno_accademico=2002" >0232 - Elettrica</a>
    </td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0233&amp;anno_accademico=2002" >0233 - Elettronica</a>
    </td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0234&amp;anno_accademico=2002" >0234 - Informatica</a>
    </td>
</tr>

<tr>
    <td class="Menu" colspan="2" align="center">&nbsp;<br />Vecchio Ordinamento</td>
</tr>

<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=2147&amp;anno_accademico=2002" >2147 - Gestionale</a>
    </td>
</tr>
<tr>
    <td class="Menu" colspan="2" align="middle">&nbsp;</td>
</tr>

<!--

<tr>
    <td class="Menu" colspan="2"><b><br />di Economia</b></td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0023&amp;anno_accademico=2002" >0023 - Economia e Professione</a>
    </td>
</tr>
<tr>
    <td valign="top"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td>
    <td class="Menu">
    <a href="index.php?pg=5&amp;cod_corso=0221&amp;anno_accademico=2002" >0221 - Economia e Professione</a>
    </td>
</tr>
-->

</table>

</td>
<td width="12" valign="bottom"><img src="tpl/black/menuR.gif" width="12" height="67" alt="" /></td>
</tr>
<tr valign="top"> 
<td height="12" width="12"><img src="tpl/black/invisible.gif" width="1" height="1" alt="" /></td>
<td height="12" align="right"><img src="tpl/black/menuB.gif" width="67" height="12" alt="" /></td>
<td height="12" width="12"><img src="tpl/black/menuBR.gif" width="12" height="12" alt="" /></td>
</tr>
</table>
&nbsp;<br /><table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr valign="bottom"> 
<td height="12" width="12"><img src="tpl/black/menuTL.gif" width="12" height="12" alt="" /></td>
<td height="12" align="left"><img src="tpl/black/menuT.gif" width="67" height="12" alt="" /></td>
<td height="12" width="12"><img src="tpl/black/invisible.gif" width="1" height="12" alt="" /></td>
</tr>
<tr> 
<td width="12" valign="top"><img src="tpl/black/menuL.gif" width="12" height="67" alt="" /></td>
<td valign="top">
 
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
<tr> 
<td colspan="2"><img src="tpl/black/servizi_18.gif" width="83" height="22" alt="Servizi" /></td>
</tr>
<tr><td valign="top" width="12"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td><td class="Menu"><a href="index.php?pg=20&amp;id_argomento=31" >Appunti - LaTeX</a></td></tr><tr><td valign="top" width="12"><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" /></td><td class="Menu"><a href="index.php?pg=20&amp;id_argomento=71" >Eventi</a></td></tr></table></td>
<td width="12" valign="bottom"><img src="tpl/black/menuR.gif" width="12" height="67" alt="" /></td>
</tr>
<tr valign="top"> 
<td height="12" width="12"><img src="tpl/black/invisible.gif" width="1" height="1" alt="" /></td>
<td height="12" align="right"><img src="tpl/black/menuB.gif" width="67" height="12" alt="" /></td>
<td height="12" width="12"><img src="tpl/black/menuBR.gif" width="12" height="12" alt="" /></td>
</tr>
</table>
&nbsp;<br /><table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr valign="bottom"> 
<td height="12" width="12"><img src="tpl/black/menuTL.gif" width="12" height="12" alt="" /></td>
<td height="12" align="left"><img src="tpl/black/menuT.gif" width="67" height="12" alt="" /></td>
<td height="12" width="12"><img src="tpl/black/invisible.gif" width="1" height="12" alt="" /></td>
</tr>
<tr> 
<td width="12" valign="top"><img src="tpl/black/menuL.gif" width="12" height="67" alt="" /></td>
<td valign="top">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
<tr> 
<td><img src="tpl/black/informazioni_18.gif" width="142" height="22" alt="Informazioni" /></td>
</tr>
<tr> 
<td class="Menu"><a href="index.php?pg=10" ><img border="0" src="tpl/black/pallino1.gif" width="12" height="11" alt="" />Manifesto</a></td>
</tr>
<tr> 
<td class="Menu"><a href="index.php?pg=11" ><img border="0" src="tpl/black/pallino1.gif" width="12" height="11" alt="" />Regolamento</a></td>
</tr>
<tr> 
<td class="Menu"><a href="index.php?pg=12" ><img border="0" src="tpl/black/pallino1.gif" width="12" height="11" alt="" />Chi siamo</a></td>
</tr>
<tr> 
<td class="Menu"><a href="index.php?pg=13" ><img border="0" src="tpl/black/pallino1.gif" width="12" height="11" alt="" />Help</a></td>
</tr>
<tr> 
<td class="Menu"><a href="index.php?pg=14" ><img border="0" src="tpl/black/pallino1.gif" width="12" height="11" alt="" />Collabora</a></td>
</tr>
<!--
<tr> 
<td class="Menu"><a href="index.php?pg=15" ><img border="0" src="tpl/black/pallino1.gif" width="12" height="11" alt="" />Ringraziamenti</a></td>
</tr>
-->
<tr> 
<td class="Menu"><a href="index.php?pg=16" ><img border="0" src="tpl/black/pallino1.gif" width="12" height="11" alt="" />Credits</a></td>
</tr>
<tr> 
<td class="Menu"><a href="http://nikita.ing.unibo.it/~eagleone/documentazione_progetto/" target="_blank"><img src="tpl/black/freccia_4.gif" width="12" height="11" border="0" alt="" />Documentazione</a></td>
</tr>
</table></td>
<td width="12" valign="bottom"><img src="tpl/black/menuR.gif" width="12" height="67" alt="" /></td>
</tr>
<tr valign="top"> 
<td height="12" width="12"><img src="tpl/black/invisible.gif" width="1" height="1" alt="" /></td>
<td height="12" align="right"><img src="tpl/black/menuB.gif" width="67" height="12" alt="" /></td>
<td height="12" width="12"><img src="tpl/black/menuBR.gif" width="12" height="12" alt="" /></td>
</tr>
</table>
&nbsp;<br /><table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr valign="bottom"> 
<td height="12" width="12"><img src="tpl/black/menuTL.gif" width="12" height="12" alt="" /></td>
<td height="12" align="left"><img src="tpl/black/menuT.gif" width="67" height="12" alt="" /></td>
<td height="12" width="12"><img src="tpl/black/invisible.gif" width="1" height="12" alt="" /></td>
</tr>
<tr> 
<td width="12" valign="top"><img src="tpl/black/menuL.gif" width="12" height="67" alt="" /></td>
<td valign="top">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
<tr> 
<td><img src="tpl/black/links_18.gif" width="62" height="22" alt="Links" /></td>
</tr>
<tr> 
<td class="Menu"><a href="http://www.unibo.it" target="_blank"><img src="tpl/black/freccia_4.gif" width="12" height="11" border="0" alt="" />Universit&agrave; di BO</a></td>
</tr>
<tr> 
<td class="Menu"><a href="http://www.ing.unibo.it" target="_blank"><img src="tpl/black/freccia_4.gif" width="12" height="11" border="0" alt="" />Facolt&agrave; di Ingegneria</a></td>
</tr>
<tr> 
<td class="Menu"><a href="https://uniwex.unibo.it" target="_blank"><img src="tpl/black/freccia_4.gif" width="12" height="11" border="0" alt="" />Uniwex</a></td>
</tr>
<tr> 
<td class="Menu"><a href="http://guida.ing.unibo.it" target="_blank"><img src="tpl/black/freccia_4.gif" width="12" height="11" border="0" alt="" />Guida dello Studente</a></td>
</tr>
<tr> 
<td class="Menu"><a href="http://www.ing.unibo.it/Ingegneria/dipartimenti.htm" target="_blank"><img src="tpl/black/freccia_4.gif" width="12" height="11" border="0" alt="" />Elenco Dipartimenti</a></td>
</tr>
<tr> 
<td class="Menu"><a href="http://www2.unibo.it/avl/org/constud/tutteass/tutteass.htm" target="_blank"><img src="tpl/black/freccia_4.gif" width="12" height="11" border="0" alt="" />Assoc. Studentesche</a></td>
</tr>
<tr> 
<td class="Menu"><a href="http://www.nettuno.it/bo/ordineingegneri/" target="_blank"><img src="tpl/black/freccia_4.gif" width="12" height="11" border="0" alt="" />Ordine Ingegneri</a></td>
</tr>
<tr> 
<td class="Menu"><a href="http://www.atc.bo.it/" target="_blank"><img src="tpl/black/freccia_4.gif" width="12" height="11" border="0" alt="" />ATC Bologna</a></td>
</tr>
<tr> 
<td class="Menu"><a href="http://www.trenitalia.com/" target="_blank"><img src="tpl/black/freccia_4.gif" width="12" height="11" border="0" alt="" />Trenitalia</a></td>
</tr>
</table></td>
<td width="12" valign="bottom"><img src="tpl/black/menuR.gif" width="12" height="67" alt="" /></td>
</tr>
<tr valign="top"> 
<td height="12" width="12"><img src="tpl/black/invisible.gif" width="1" height="1" alt="" /></td>
<td height="12" align="right"><img src="tpl/black/menuB.gif" width="67" height="12" alt="" /></td>
<td height="12" width="12"><img src="tpl/black/menuBR.gif" width="12" height="12" alt="" /></td>
</tr>
</table>
&nbsp;<br /><!-- Fine MENU Left -->
</td>
<td valign="top" align="center"> 