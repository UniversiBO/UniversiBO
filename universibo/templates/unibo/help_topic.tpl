{include file=header_index.tpl}

{include file=avviso_notice.tpl}

<h2><a href="{$common_helpUri|escape:"htmlall"}">Help</a></h2>
{if $showHelpTopic_index == "true"}
    <a id="index" />
    <div class="elenco">
	{foreach from=$showHelpTopic_topics item=temp_ref}
	<p class="{cycle name=index values="even,odd"}">&nbsp;
	<a href="#{$temp_ref.reference|escape:"htmlall"}"> {$temp_ref.titolo|escape:"htmlall"}</a></p>
	{/foreach}
	</div>
<a id="index" />
{/if}

{foreach from=$showHelpTopic_topics item=temp_topic}
	{include file=Help/topic.tpl showTopic_topic=$temp_topic idsu=$temp_topic.reference}
{/foreach}
{include file=footer_index.tpl}