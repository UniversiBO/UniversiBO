{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table width="90%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td class="Normal">
<p align="center">
&nbsp;<br />
<img src="{$manifesto_langTitleImg}" width="171" height="39" alt="Manifesto" /><br />
</p>
<p align="center">
<img src="{$manifesto_langQuoteImg}" width="357" height="185" alt="{$manifesto_langQuoteAlt|escape:html}" />
</p>
<p>
{$manifesto_langWhatIsIt|escape:html_all|nl2br}
<p align="right" class="NormalC">{$manifesto_langAuthor|capitalize}</p>
&nbsp;<br /></td></tr></table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}
