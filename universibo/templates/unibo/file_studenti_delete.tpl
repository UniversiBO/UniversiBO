{include file=header_index.tpl}
<div class="titoloPagina">
<h2>Cancella il file</h2>
</div>
{include file=avviso_notice.tpl}

<form method="post">
	{if $fileDelete_flagCanali == 'true'}
	<p><fieldset>
	<legend>{$f25_langAction|escape:"htmlall"}</legend>
	</fieldset></p>	  
	{/if}
	<p><input class="submit" type="submit" id="" name="f25_submit" size="20" value="Elimina" /></p>
</form>
<p><a href="{$common_canaleURI|escape:"htmlall"}">Torna&nbsp;{$common_langCanaleNome|escape:"htmlall"}</a></p>

{include file=footer_index.tpl}