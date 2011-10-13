{extends file="layout.tpl"}

{block name=title}{$smarty.const.WTT_TITLE} – Rozšířené vyhledávání{/block}

{block name=head}
<link rel="Stylesheet" href="css/ui.selectmenu.css" type="text/css" />
<script type="text/javascript">
//define global variables from settings.php
var lang = "{$locale.lang}";
</script>
<script type="text/javascript" src="js/ui.selectmenu.js"></script>	
<script type="text/javascript" src="js/jquery.ui.highlight.js"></script>
<script type="text/javascript" src="js/search_advanced.js"></script>	
{/block}
{block name=body}
<div id="search_advanced-page-wrapper">
 <form id="search_advanced-form" action="javascript:sendForm()">
    <label for="search_advanced-select-parliament" class="left">Vyberte zastupitelský sbor: </label>
    <select name="parliament_code" id="search_advanced-select-parliament" class="search_advanced-select">
      <option value="0" selected="selected">--</option>
	  {foreach $parliaments as $p}
      <option value="{$p.code}">{$p.name}</option>
	  {/foreach}
    </select>
  <div id="search_advanced-selects"></div>
  <div id="search_advanced-note"></div>

  
 </form>
  <form id="advanced-search-export-form">
    <input id="search_advanced-export" value="Exportovat emailové adresy" name='export' type="button" />
  </form>
  <div id="search_advanced-export-result"></div>
 <form id="search_advanced-hidden" action="">
  <input type="hidden" name="constituency" value='' id="search_advanced-hidden-constituency" />
  <input type="hidden" name="groups" value='' id="search_advanced-hidden-groups" />
  <input type="hidden" name="parliament_code" value='' id="search_advanced-hidden-parliament" />
 </form>
</div>
{/block}
