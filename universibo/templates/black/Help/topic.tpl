{*   idsu			stringa contenente l'id dell'ancora a inizio pagina [campo obbligatorio] *}
<table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
    <tr><td id="{$showTopic_langReference|escape:"htmlall"|bbcode2html|nl2br}" class="Titolo">{$showTopic_langReference|escape:"htmlall"|bbcode2html|nl2br}</td></tr>	
	
	<tr><td>{include file=Help/help_id.tpl indice=false idsu=$idsu}</td></tr>
	
	<tr><td>&nbsp;</td></tr>
</table>