{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

{include file=avviso_notice.tpl}


<table width="95%" border="0" cellspacing="0" cellpadding="0" summary="">
<tr><td  align="center" class="Normal">
&nbsp;<br /><img src="tpl/black/mypage_30.gif" width="138" height="39" alt="MyPage" /><br />
{$mypage_intro|escape:"htmlall"}
 &nbsp;<br />
 &nbsp;<br />
 <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
 <tr bgcolor="#000099"> 
 <td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
 <td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
 </tr>
 </table>
 &nbsp;<br />
 &nbsp;<br />


 <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
 <tr><td>
  <img src="tpl/black/preferences_18.gif" width="131" height="22" alt="Preferences" /><br />
	&nbsp;<br />
  <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
  <tr bgcolor="#000099"> 
  <td colspan="1" align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
  <td colspan="2" align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
  <tr bgcolor="#000032">
  <td align="center"  class="Titolo">&nbsp;<br /><a href="#" onclick="window.open('popup.php?pg=4','','width=500,height=500,scrollbars=yes,resizable=yes,scrolling=yes,top=50,left=100')">{$mypage_preferences.pw|escape:"htmlall"}</a><br />&nbsp;<br /></td>
  <td bgcolor="#000099" width="1"><img src="tpl/black/invisible.gif" width="1" height="1" alt="" /></td>
  <td align="center" class="Titolo">&nbsp;<br /><a href="forum/profile.php?mode=editprofile" target="_blank">{$mypage_preferences.info|escape:"htmlall"}</a><br />&nbsp;<br /></td>
  </tr>
  <tr bgcolor="#000099"> 
  <td colspan="3" align="left"><img src="tpl/black/invisible.gif" width="1" height="1" alt="" /></td>
  </tr>
  <tr bgcolor="#000032">
  <td align="center" class="Titolo">&nbsp;<br /><a href="#" onclick="window.open('popup.php?pg=6','','width=500,height=500,scrollbars=yes,resizable=yes,scrolling=yes,top=50,left=100')">{$mypage_preferences.setting|escape:"htmlall"}</a><br />&nbsp;<br /></td>
  <td bgcolor="#000099" width="1"><img src="tpl/black/invisible.gif" width="1" height="1" alt="" /></td>
  <td align="center" class="Titolo">&nbsp;<br />&nbsp;<br />&nbsp;<br /></td>
  </tr>
  <tr bgcolor="#000099"> 
  <td colspan="3" align="left"><img src="tpl/black/invisible.gif" width="1" height="1" alt="" /></td>
  </tr>
  <tr bgcolor="#000032">
  <td align="center" class="Titolo">&nbsp;<br /><a href="https://posta.studio.unibo.it/horde/?username=" target="_blank">Posta di ateneo</a><br />&nbsp;<br /></td>
  <td bgcolor="#000099" width="1"><img src="tpl/black/invisible.gif" width="1" height="1" alt="" /></td>
  <td align="center" class="Titolo">&nbsp;<br />&nbsp;<br />&nbsp;<br /></td>
  </tr>
  <tr bgcolor="#000099"> 
  <td colspan="1" align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
  <td colspan="2" align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
  </table> 
 </td></tr>
 </table> 
 &nbsp;<br />
 &nbsp;<br />
 <table width="100%" border="0" cellspacing="0" cellpadding="0" summary="">
 <tr bgcolor="#000099"> 
 <td align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
 <td align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
 </tr>
 </table>
 &nbsp;<br />
 &nbsp;<br />
 
 <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
 <tr><td>
  <img src="img/admin_18.gif" width="76" height="22" alt="Admin" /><br />
	&nbsp;<br />
  <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
  <tr bgcolor="#000099"> 
  <td colspan="1" align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
  <td colspan="2" align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
  <tr bgcolor="#000032">
  <td align="center" class="Titolo">&nbsp;<br /><a href="https://www.universibo.unibo.it/phppgadmin242/" target="_blank">{$mypage_admin.postgre|escape:"htmlall"}</a><br />&nbsp;<br /></td>
  <td bgcolor="#000099" width="1"><img src="tpl/black/invisible.gif" width="1" height="1" alt="" /></td>
  <td align="center" class="Titolo">&nbsp;<br /><a href="https://www.universibo.unibo.it/phporacleadmin/" target="_blank">{$mypage_admin.oracle|escape:"htmlall"}</a><br />&nbsp;<br /></td>
  </tr>
  <tr bgcolor="#000099"> 
  <td colspan="3" align="left"><img src="tpl/black/invisible.gif" width="1" height="1" alt="" /></td>
  </tr>
  <tr bgcolor="#000032">
  <td align="center" class="Titolo">&nbsp;<br /><a href="https://universibo.ing.unibo.it/phpMyAdmin" target="_blank">{$mypage_admin.mysql|escape:"htmlall"}</a><br />&nbsp;<br /></td>
  <td bgcolor="#000099" width="1"><img src="tpl/black/invisible.gif" width="1" height="1" alt="" /></td>
  <td align="center" class="Titolo">&nbsp;<br /><a href="#" onclick="window.open('popup.php?pg=50','','width=500,height=500,scrollbars=yes,resizable=yes,scrolling=yes,top=50,left=100')">{$mypage_admin.nuovi|escape:"htmlall"}</a><br />&nbsp;<br /></td>
  </tr>
  <tr bgcolor="#000099"> 
  <td colspan="1" align="left"><img src="tpl/black/rule_piccoloL.gif" width="200" height="2" alt="" /></td>
  <td colspan="2" align="right"><img src="tpl/black/rule_piccoloR.gif" width="200" height="2" alt="" /></td>
  </tr>
  </table> 
 </td></tr>
 </table> 
</td></tr>
</table>


{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}
