	</div>
</td> {* FINE MENU CENTRALE*}
<td id="rightmenu"> {* COLONNA MENU DI DESTRA*}
	<div class="box"> {* primo blocchetto *} 
		{if $common_userLoggedIn=='false'}
		<h3>Login</h3>
		<div class="contenuto">
			<form action="index.php?do=Login" name="form1_a" id="f1" method="post">
				<label for="f1_username">username: </label><br />
				<input id ="f1_username" name="f1_username" maxlength="25" type="text" size="15" tabindex="1" /><br />
				<label for="f1_password">password: </label><br />
				<input id="f1_password" name="f1_password" maxlength="25" type="password" size="15" tabindex="2" /><br />
				<input type="hidden" name="f1_resolution" value="" />
				<input class="submit" name="f1_submit" type="submit" value="Login" tabindex="3" onclick="document.form1_a.f1_resolution.value = screen.width;" /><br />
			</form>
			<a href="index.php?do=RegStudente">Registrazione studenti</a><br />
			<a href="index.php?do=NewPasswordStudente">Password smarrita</a><br />
		{else}
		<h3>Logout</h3>
		<div class="contenuto">
			<form action="index.php?do=Logout" name="form2" id="f2" method="post">
			<p>{$common_langWelcomeMsg|escape:"htmlall"|bbcode2html|nl2br} {$common_userUsername|escape:"htmlall"}<br />
			{$common_langUserLivello|escape:"htmlall"|bbcode2html|nl2br} {foreach from=$common_userLivello item=temp_nomeLivello}{$temp_nomeLivello|escape:"htmlall"} {/foreach}<br />
			&nbsp;<br />
			<input class="submit" name="f2_submit" type="submit" value="LogOut" /><br />
			</form>
		{/if}
		</div>	
	</div>
	{if $common_contactsCanaleAvailable|default:"false" =="true"}
	<div class="box"> {* secondo blocchetto *}
	<h3>Contatti</h3>
		<div class="contenuto">
			{foreach from=$common_contactsCanale key=temp_key item=temp_currGroup}
				<p>{$temp_key|escape:"htmlall"}</p>
				{foreach from=$temp_currGroup item=temp_currLink}
					<p><img src="tpl/black/pallino1.gif" width="12" height="11" alt="" />&nbsp;
					<a href="{$temp_currLink.utente_link|escape:"htmlall"}">{$temp_currLink.label|escape:"htmlall"}</a>
					{if $temp_currLink.ruolo=="R"}&nbsp;<img src="tpl/black/icona_3_r.gif" width="9" height="9" alt="Referente" title="Referente" />{/if}
					{if $temp_currLink.ruolo=="M"}&nbsp;<img src="tpl/black/icona_3_m.gif" width="9" height="9" alt="Moderatore" title="Moderatore" />{/if}</p>
				{/foreach}
			{/foreach}
			{if $common_contactsEditAvailable == "true"}
				<div class="actions"><a href="{$common_contactsEdit.uri|escape:"htmlall"}">{$common_contactsEdit.label|escape:"htmlall"}</a></div>
			{/if}
		</div>
	</div>
	{/if}
	<div class="box"> {* terzo blocchetto *}
		<h3>Links</h3>
		<div class="contenuto">
			<p><a title="Questo link apre una nuova pagina" href="http://www.unibo.it" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />&nbsp;Universit&agrave; di BO</a></p>
			<p><a title="Questo link apre una nuova pagina" href="http://www.ing.unibo.it" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />&nbsp;Facolt&agrave; di Ingegneria</a></p>
			<p><a title="Questo link apre una nuova pagina" href="https://uniwex.unibo.it" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />&nbsp;Uniwex</a></p>
			<p><a title="Questo link apre una nuova pagina" href="http://guida.ing.unibo.it" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />&nbsp;Guida dello Studente</a></p>
			<p><a title="Questo link apre una nuova pagina" href="http://www.ing.unibo.it/Ingegneria/dipartimenti.htm" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />&nbsp;Elenco Dipartimenti</a></p>
			<p><a title="Questo link apre una nuova pagina" href="http://www2.unibo.it/avl/org/constud/tutteass/tutteass.htm" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />&nbsp;Assoc. Studentesche</a></p>
			<p><a title="Questo link apre una nuova pagina" href="http://www.nettuno.it/bo/ordineingegneri/" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />&nbsp;Ordine Ingegneri</a></p>
			<p><a title="Questo link apre una nuova pagina" href="http://www.atc.bo.it/" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />&nbsp;ATC Bologna</a></p>
			<p><a title="Questo link apre una nuova pagina" href="http://www.trenitalia.com/" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />&nbsp;Trenitalia</a></p>
		</div>
	</div>
	<div class="box"> {*quarto blocchetto *}
		<h3><a href="{$common_calendarLink.uri|escape:"htmlall"}">{$common_calendarLink.label|escape:"htmlall"}</a></h3>
		<table width="100%" cellspacing="0" cellpadding="1" border="0" summary="Calendario">
			<tr align="center">
			{foreach name=weekday from=$common_calendarWeekDays item=temp_weekday}
			 <th class="{if %weekday.last%}Domeniche{else}Feriali{/if}">{$temp_weekday.numero|escape:"htmlall"|capitalize}</th>
			{/foreach}
			</tr>
			{foreach from=$common_calendar item=temp_week}
				<tr align="center">
				{foreach from=$temp_week item=temp_day}
					{if $temp_day.today=='true'}<td class="Oggi">{$temp_day.numero|escape:"htmlall"}</td>
					{else}<td class="{if $temp_day.tipo=='none'}Piccolo{elseif $temp_day.tipo=='feriale'}Feriali{elseif $temp_day.tipo=='festivo'}Festivi{elseif $temp_day.tipo=='domenica'}Domeniche{/if}">{$temp_day.numero|escape:"htmlall"}</td>{/if}
				{/foreach}
				</tr>
			{/foreach}
		</table>
	</div>
	
	{if $common_isSetVisite == 'true'}
	<div class="box"> {* sesto blocchetto *}
		<h3>Statistiche</h3>
		<div class="contenuto">
			<p>{$common_visite}&nbsp;</p>
			<span class="">visite in questa pagina</span>
		</div> 
	</div>
	{/if}
</td></tr> {* FINE MENU DI DESTRA*}
<tr>
	<td colspan="2">
		<div id="footer"> {* FONDO PAGINA *}
			<p>{$common_disclaimer|escape:"htmlall"|bbcode2html}</p>
		</div>
	</td>
</tr>
</table> 
</body>
</html>



