<h4>{$collaboratore.username|escape:"html"}</h4>
<div class="chi_siamo">
	<img src="{$contacts_path}{$collaboratore.foto|escape:"htmlall"}" alt="foto di {$collaboratore.username|escape:"htmlall"}" width="60" height="80" />
	<p>...</p>
	<div>
		<p><span>Ruolo:&nbsp;{$collaboratore.ruolo|escape:"htmlall"}</span></p>
		<p><span>Email:&nbsp;<a href="mailto:{$collaboratore.email|escape:"htmlall"}">{$collaboratore.email|escape:"htmlall"}</a></span></p>
		<p><span>Recapito:&nbsp;{$collaboratore.recapito|escape:"htmlall"}</span></p>
	</div>
	</p>
	<p>{$collaboratore.intro|escape:"html"}</p>
	<p>{$collaboratore.obiettivi|escape:"htmlall"|bbcode2html|nl2br}</p>
</div>
  