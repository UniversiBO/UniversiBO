<div class="chi_siamo">
	<h3>::&nbsp;{$collaboratore.username|escape:"html"}&nbsp;:</h3>
	<img src="{$contacts_path}{$collaboratore.foto|escape:"htmlall"}" alt="foto di {$collaboratore.username|escape:"htmlall"}" width="60" height="80" />
	<hr class="hide">
	<div>
		<p><span>Ruolo:</span>&nbsp;{$collaboratore.ruolo|escape:"htmlall"}</p>
		<p><span>Email:</span>&nbsp;<a href="mailto:{$collaboratore.email|escape:"htmlall"}">{$collaboratore.email|escape:"htmlall"}</a></p>
		<p><span>Recapito:</span>&nbsp;{$collaboratore.recapito|escape:"htmlall"}</p>
	</div>
	<p>{$collaboratore.intro|escape:"html"}</p>
	<p>{$collaboratore.obiettivi|escape:"htmlall"|bbcode2html|nl2br}</p>
</div>
  