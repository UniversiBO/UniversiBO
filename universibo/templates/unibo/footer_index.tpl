	</div>
</td> {* FINE MENU CENTRALE*}
<td id="rightmenu"> {* COLONNA MENU DI DESTRA*}
	<div class="box"> {* primo blocchetto *} 
		{if $common_userLoggedIn=='false'}
		<h3>Login</h3>
		<form action="index.php?do=Login" name="form1_a" id="f1" method="post">
			<label for="f1_username">username: </label><br />
			<input id ="f1_username" name="f1_username" maxlength="25" type="text" class="navbarForm" size="15" /><br />
			<label for="f1_password">password: </label><br />
			<input id="f1_password" name="f1_password" maxlength="25" type="password" class="navbarForm" size="15" /><br />
			<input type="hidden" name="f1_resolution" value="" />
			<input class="submit" name="f1_submit" type="submit" value="Login" onclick="document.form1_a.f1_resolution.value = screen.width;" /><br />
		</form>
		<a href="index.php?do=RegStudente"><font color="#FF0000">Registrazione studenti</font></a><br />
		<a href="index.php?do=NewPasswordStudente">Password smarrita</a><br />
		{else}
		<h3>Logout</h3>
		<form action="index.php?do=Logout" name="form2" id="f2" method="post">
		<p>{$common_langWelcomeMsg|escape:"htmlall"|bbcode2html|nl2br} <strong>{$common_userUsername|escape:"htmlall"}</strong><br />
		{$common_langUserLivello|escape:"htmlall"|bbcode2html|nl2br} <strong class="NormalC">{foreach from=$common_userLivello item=temp_nomeLivello}{$temp_nomeLivello|escape:"htmlall"} {/foreach}</strong><br />
		&nbsp;<br />
		<input name="f2_submit" type="submit" value="LogOut" /><br />&nbsp;
		</form>
		{/if}	
	</div>
	{if $common_contactsCanaleAvailable|default:"false" =="true"}
	<div class="box"> {* secondo blocchetto *}
	<h3>Contatti</h3>
	{foreach from=$common_contactsCanale item=temp_currLink}
	<a href="{$temp_currLink.utente_link}">{$temp_currLink.label|escape:"htmlall"}</a>
	{if $temp_currLink.ruolo=="R"}&nbsp;<img src="tpl/black/icona_3_r.gif" width="9" height="9" alt="Referente" />{/if}
	{if $temp_currLink.ruolo=="M"}&nbsp;<img src="tpl/black/icona_3_m.gif" width="9" height="9" alt="Moderatore" />{/if}<br />
	{/foreach}
	</div>
	{/if}
	<div class="box"> {* terzo blocchetto *}
		<h3>Links</h3>
		<p><a title="Questo link apre una nuova pagina" href="http://www.unibo.it" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />Universit&agrave; di BO</a></p>
		<p><a title="Questo link apre una nuova pagina" href="http://www.ing.unibo.it" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />Facolt&agrave; di Ingegneria</a></p>
		<p><a title="Questo link apre una nuova pagina" href="https://uniwex.unibo.it" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />Uniwex</a></p>
		<p><a title="Questo link apre una nuova pagina" href="http://guida.ing.unibo.it" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />Guida dello Studente</a></p>
		<p><a title="Questo link apre una nuova pagina" href="http://www.ing.unibo.it/Ingegneria/dipartimenti.htm" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />Elenco Dipartimenti</a></p>
		<p><a title="Questo link apre una nuova pagina" href="http://www2.unibo.it/avl/org/constud/tutteass/tutteass.htm" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />Assoc. Studentesche</a></p>
		<p><a title="Questo link apre una nuova pagina" href="http://www.nettuno.it/bo/ordineingegneri/" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />Ordine Ingegneri</a></p>
		<p><a title="Questo link apre una nuova pagina" href="http://www.atc.bo.it/" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />ATC Bologna</a></p>
		<p><a title="Questo link apre una nuova pagina" href="http://www.trenitalia.com/" target="_blank"><img src="tpl/unibo/freccia_4.gif" width="12" height="11" border="0" alt="->" />Trenitalia</a></p>
	</div>
	<div class="box"> {*quarto blocchetto *}
		<h3>Giugno</h3>
		<table cellspacing="0" cellpadding="1" width="100%" align="center" border="0" summary="">
			<tr align="center">
				<th class="Feriali"><b>L</b></th>
				<th class="Feriali"><b>M</b></th>
				<th class="Feriali"><b>M</b></th>
				<th class="Feriali"><b>G</b></th>
				<th class="Feriali"><b>V</b></th>
				<th class="Feriali"><b>S</b></th>
				<th class="Domeniche"><b>D</b></th>
			</tr>
			<tr align="center">
				<td class="Piccolo"></td>
				<td class="Piccolo"></td>
				<td class="Piccolo"></td>
				<td class="Piccolo"></td>
				<td class="Piccolo"></td>
				<td class="Piccolo"></td>
				<td class="Domeniche">1</td>
			</tr>
			<tr align="center">
				<td class="Feriali">2</td>
				<td class="Feriali">3</td>
				<td class="Feriali">4</td>
				<td class="Feriali">5</td>
				<td class="Feriali">6</td>
				<td class="Feriali">7</td>
				<td class="Domeniche">8</td>
			</tr>
			<tr align="center">
				<td class="Feriali">9</td>
				<td class="Feriali">10</td>
				<td class="Feriali">11</td>
				<td class="Feriali">12</td>
				<td class="Oggi">13</td>
				<td class="Feriali">14</td>
				<td class="Domeniche">15</td>
			</tr>
			<tr align="center">
				<td class="Feriali">16</td>
				<td class="Feriali">17</td>
				<td class="Feriali">18</td>
				<td class="Feriali">19</td>
				<td class="Feriali">20</td>
				<td class="Feriali">21</td>
				<td class="Domeniche">22</td>
			</tr>
			<tr align="center">
				<td class="Feriali">23</td>
				<td class="Feriali">24</td>
				<td class="Feriali">25</td>
				<td class="Feriali">26</td>
				<td class="Feriali">27</td>
				<td class="Feriali">28</td>
				<td class="Domeniche">29</td>
			</tr>
			<tr align="center">
				<td class="Feriali">30</td>
				<td class="Piccolo"></td>
				<td class="Piccolo"></td>
				<td class="Piccolo"></td>
				<td class="Piccolo"></td>
				<td class="Piccolo"></td>
				<td class="Piccolo"></td>
			</tr>
		</table>
	</div>
	
	{if $common_isSetVisite == 'true'}
	<div class="box"> {* sesto blocchetto *}
		<h3>Statistiche</h3>
		<p>{$common_visite}&nbsp;</p>
		<span class="">visite in questa pagina</span> 
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



