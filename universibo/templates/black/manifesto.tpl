{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table width="90%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td class="Normal">
<p align="center">
&nbsp;<br />
<img src="tpl/black/manifesto_30.gif" width="171" height="39" alt="{$manifesto_TitleAlt}" /><br />
</p>
<p align="center">
<img src="tpl/black/galileo_galilei.gif" width="357" height="185" alt="{$manifesto_langQuoteAlt|escape:html}" />
</p>
<p>
{$manifesto_langWhatIsIt|escape:"html"|nl2br}
</p>
<p align="right" class="NormalC">{$manifesto_Author|capitalize}</p>
&nbsp;<br /></td></tr></table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}
