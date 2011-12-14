<div class="box-mp">
	<img src="{if !empty($mp.image)}{$smarty.const.API_FILES_URL}/{$mp.image}{else}http://{$smarty.const.NJ_HOST}/images/head_{if $mp.sex == 'f'}female{else}male{/if}_small.png{/if}" title="{assign "personal_name" format_personal_name($mp, 'full')}{$personal_name}" alt="{$personal_name}" class="box-photo" width="120" height="162" />
  <div id="close-{$mp.id}" class="box-x deselect ui-icon ui-icon-circle-close" /></div>
<!--  <div class="box-last-name">{assign "personal_name" format_personal_name($mp)}{$personal_name}</div>-->
</div>
