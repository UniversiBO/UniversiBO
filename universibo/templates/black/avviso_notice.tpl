{if $error_notice_present=='true'}

<table width="70%" border="0" cellspacing="1" cellpadding="3" summary="">
{ foreach from=$error_notice|default:'' item=temp_error_notice }
<tr><td class="Normal" bgcolor="#FF0000">
{* $error_notice|escape:"html" * }
{ $temp_error_notice|escape:"htmlall" }</td></tr>
{ /foreach } 
</table>

{/if}