{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table width="100%" border="0" summary="">
<tr><td class="testoOcchiello" align="left">sei in: <span class="sei_in">Home</span></td></tr>
<tr><td class="testoOcchiello" align="left" width="100%">
	<table width="90%" border="0" align="center">
	<tr><td>
    	<table width="100%" align="center" border="0 "vAlign="top" summary="">
        <tr>&nbsp;<br/><td colspan="2" class="titoloHome">{$home_langWelcome|escape:"htmlall"}</td></tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr><td class="testoOcchiello">{$home_langWhatIs|escape:"htmlall"}<br />{$home_langMission|escape:"htmlall"}</td>
         <td align="right" rowspan="2"><img height="252" alt="gif da fare" src="centrale/centrale_1.gif" width="168" border="0"></td>
        </tr>
        </table>
    </td></tr>
    <tr><td>&nbsp;</td></tr>
<tr><td align="center">

{include file=News/latest_news.tpl}

</td></tr></table>
</td></tr></table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}
