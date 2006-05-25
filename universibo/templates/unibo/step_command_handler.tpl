{include file=header_index.tpl}

<div class="titoloPagina">
<h2>{$StepCommandHandler_title_lang|escape:"htmlall"}</h2>
</div>

{include file=avviso_notice.tpl}

<form method="post">
{include file=$StepCommandHandler_stepPath}
	<div class="navbar"><a href="{$StepCommandHandler_back_uri|escape:"htmlall"}">{$StepCommandHandler_back_lang|escape:"htmlall"}</a><input class="post_link" name="action" type="submit" value="{$StepCommandHandler_next_lang|escape:"htmlall"}" /><a href="{$StepCommandHandler_canc_uri|escape:"htmlall"}">{$StepCommandHandler_canc_lang|escape:"htmlall"}</a></div>
</form>

{include file=footer_index.tpl}