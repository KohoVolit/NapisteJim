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
<script type="text/javascript" src="js/advanced_search.js"></script>	
{/block}
{block name=body}
<div id="advanced_search-page-wrapper">
 <form id="advanced_search-form" action="javascript:sendForm()">
    <label for="advanced_search-select-parliament" class="left">Vyberte zastupitelský sbor: </label>
    <select name="parliament_code" id="advanced_search-select-parliament" class="advanced_search-select">
      <option value="0" selected="selected">--</option>
	  {foreach $parliaments as $p}
      <option value="{$p.code}">{$p.name}</option>
	  {/foreach}
    </select>
  <div id="advanced_search-selects"></div>
  <div id="advanced_search-note"></div>

  
 </form>
  <form id="advanced-search-export-form">
    <input id="advanced_search-export" value="Exportovat emailové adresy" name='export' type="button" />
  </form>
  <div id="advanced_search-export-result"></div>
 <form id="advanced_search-hidden" action="">
  <input type="hidden" name="constituency" value='' id="advanced_search-hidden-constituency" />
  <input type="hidden" name="groups" value='' id="advanced_search-hidden-groups" />
  <input type="hidden" name="parliament_code" value='' id="advanced_search-hidden-parliament" />
 </form>
</div>
{/block}
