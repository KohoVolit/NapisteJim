{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}Statistics of representatives{/t}{/block}

{block name=head}
<script type="text/javascript" src="js/statistics.js"></script>
{/block}

{block name=main}
<h3>{t}Statistics{/t}</h3>

<form id="statistics-filter-form" action="statistics" method="GET">
<table>
<tr class="ui-widget">
	<td><label for="parliament">{t}Parliament{/t}</label></td>
</tr>
<tr class="ui-widget">
	<td><select id="parliament" name="parliament_code" class="ui-corner-all" />
		<option value=""{if !isset($params.parliament_code) || empty($params.parliament_code)} selected="selected"{/if}>{t}any{/t}</option>
		{foreach $parliaments as $parliament}
			<option value="{$parliament.code}"{if isset($params.parliament_code) && $params.parliament_code == $parliament.code} selected="selected"{/if}>{$parliament.short_name|default:$parliament.name}</option>
		{/foreach}
		</select>
	</td>
    <td><input id="statistics-filter-submit" type="submit" value="{t}Filter{/t}" class="ui-corner-all ui-state-default" /></td>
</tr>
</table>
</form>

<table id="statistics-table">
<thead>
	<tr><td class="statistics-td-politician">{t}Politician{/t}</td><td class="statistics-td-received">{t}Received{/t}</td><td class="statistics-td-replied">{t}Replied{/t}</td><td class="statistics-td-ratio">{t}Ratio{/t}</td><td class="statistics-td-average-days">{t}Average replies in{/t}</td></tr>
</thead>
<tbody>
{foreach $statistics as $mp}
	<tr>
		<td class="statistics-td-politician">{assign "personal_name" format_personal_name($mp)}<a href="http://{$smarty.const.NJ_HOST}/list?mp_id={$mp.id}">{$personal_name}<a></td>
		<td class="statistics-td-received">{$mp.received_public_messages}</td>
		<td class="statistics-td-replied">{$mp.replied_public_messages}</td>
		{assign "ratio" round(100.0 * $mp.replied_public_messages / $mp.received_public_messages)}
		{assign "ratio_compl" 100 - $ratio}
		<td class="statistics-td-ratio" title="{$ratio} %"><div class="replied " style="width:{$ratio}%">&nbsp;</div><div class="not-replied" style="width:{$ratio_compl}%">&nbsp;</div></td>
		{assign "days" round($mp.average_days_to_reply)}
		{assign "hours" round($mp.average_days_to_reply * 24)}
		{assign "minutes" round($mp.average_days_to_reply * 24 * 60)}
		<td class="statistics-td-average-days">{if isset($mp.average_days_to_reply)}{if ($days > 0)}{t count=$days 1=$days plural="%1 days"}%1 days{/t}{else}{if ($hours > 0)}{t count=$hours 1=$hours plural="%1 hours"}%1 hours{/t}{else}{t count=$minutes 1=$minutes plural="%1 minutes"}%1 minutes{/t}{/if}{/if}{else}&nbsp;{/if}</td>
	</tr>
{/foreach}
</tbody>
</table>
<div id="statistics-pager" class="pager">
{if isset($pager.prev_url_query)}
<div class="pager-link pager-prev"><a href="http://{$smarty.const.NJ_HOST}/statistics?{$pager.prev_url_query}">&laquo;&nbsp;{t}previous politicians{/t}</a></div>
{/if}
{if isset($pager.next_url_query)}
<div class="pager-link pager-next"><a href="http://{$smarty.const.NJ_HOST}/statistics?{$pager.next_url_query}">{t}next politicians{/t}&nbsp;&raquo;</a></div>
{/if}
</div>
{/block}
