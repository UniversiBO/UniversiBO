{* showTopic_topic array di un reference seguito da array di argomenti (id, titolo, contenuto) passato da ShowHelpId, *}
{* idsu			stringa contenente l'id dell'ancora a inizio pagina [campo obbligatorio] *}
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
    <tr><td id="{$showTopic_topic.reference|escape:"htmlall"|bbcode2html|nl2br}" class="Titolo">{$showTopic_topic.reference|escape:"htmlall"|bbcode2html|nl2br}</td></tr>	
	
	<tr><td>{include file=Help/help_id.tpl showHelpId_langArgomento=$showTopic_topic.argomenti indice=false idsu=$idsu}</td></tr>
	
	<tr><td>&nbsp;</td></tr>
</table>