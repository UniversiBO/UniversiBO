{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}
&nbsp;<br />
<table width="90%" border="0" cellspacing="0" cellpadding="0">
<td class="titoloHome">{$manifesto_TitleAlt}</td>
</tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td align="center" >
<img src="tpl/unibo/galileo_galilei.gif" width="357" height="185" alt="{$manifesto_langQuoteAlt|escape:"htmlall"|bbcode2html}" /></td>
</tr>
</table>
</td></tr>
<tr><td class="testoOcchiello">
&nbsp;<br />
&nbsp;<br />
{$manifesto_langWhatIsIt|escape:"htmlall"|nl2br|bbcode2html}
<p align="right">{$manifesto_Author|escape:"htmlall"|capitalize}</p>
<p>&nbsp;</p>
</td></tr>
</table>
                
{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}