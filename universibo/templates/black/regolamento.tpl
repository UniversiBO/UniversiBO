{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table width="90%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td class="Normal">
<p>
&nbsp;<br />
<p align="center">
<img src="tpl/black/regolamento_30.gif" width="234" height="39" alt="{$rules_langTitleAlt}" /><br />
</p>
<p>{$rules_langIntro} <br /></p>
<font class="NormalC">{$rules_langTitle}</font> <br />
{$rules_langFacSubtitle} <br />
{$rules_langPrivacy} <br />
{$rules_langServicesRules|nl2br} <br />
{$rules_langForumRules} <br />

</td></tr></table>
{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}
