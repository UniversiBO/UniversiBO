{include file=header_index.tpl}

{include file=avviso_notice.tpl}

<h2>Credits</h2>
<p>{$showCredits_langIntro|escape:"htmlall"|bbcode2html|nl2br}<br />&nbsp;</p>
<hr />
<p><span>{$showCredits_langSO|escape:"htmlall"|bbcode2html|nl2br}<img src="img/credits/gnu_linux.gif" width="88" height="31" alt="GNU/Linux Logo" /><br />
	<img src="img/credits/debian.png" width="88" height="31" alt="Debian Logo" /> </span></p>
<p><span><img src="img/credits/apache_ssl.gif" width="88" height="31" alt="Apache-SSL Logo" vspace="2" />{$showCredits_langApache|escape:"htmlall"|bbcode2html|nl2br}</span></p>
<p><span>{$showCredits_langPostgres|escape:"htmlall"|bbcode2html|nl2br}<img src="img/credits/postgresql.gif" width="88" height="31" alt="PostgreSQL Logo" vspace="2" /></span></p>
<p><span><img src="img/credits/php.gif" width="88" height="31" alt="PHP4 Logo" />{$showCredits_langPhp|escape:"htmlall"|bbcode2html|nl2br}</span></p>
<p><span>{$showCredits_langPhpAccelerator|escape:"htmlall"|bbcode2html|nl2br}<img src="img/credits/php_acc.png" width="88" height="31" alt="Ion Cube PhpAccelerator Logo" vspace="2" /></span></p>
<p><span><img src="img/credits/smarty.gif" width="88" height="31" alt="Smarty Logo" vspace="2" />{$showCredits_langSmarty|escape:"htmlall"|bbcode2html|nl2br}</span></p>
<p><span>{$showCredits_langOthers|escape:"htmlall"|bbcode2html|nl2br}
	<img src="img/credits/pear.png" width="88" height="31" alt="PEAR Logo" vspace="2" /><br />
	<img src="img/credits/phpmailer.png" width="88" height="31" alt="PhpMailer Logo" vspace="2" /><br />
	<img src="img/credits/phpbb.png" width="88" height="31" alt="PHPBB Logo" vspace="2" /></span></p>
<p><span><img src="img/credits/valid-html401" width="88" height="31" alt="Valid HTML 4.01 Logo" vspace="2" />{$showCredits_langW3c|escape:"htmlall"|bbcode2html|nl2br}</span></p>
<br />
{include file=footer_index.tpl}