{extends file="layout.tpl"}

{block name=title}
NapišteJim.cz - Rozšířené vyhledávání
{/block}
{block name=head}
<link rel="Stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css" type="text/css" />
<link rel="Stylesheet" href="css/ui.selectmenu.css" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/ui.selectmenu.js"></script>	
<script type="text/javascript" src="js/advanced_search.js"></script>	
{/block}
{block name=body}
<form action="javascript:sendForm()">
    <label for="advanced_search-select-parliament" class="left">Vyberte zastupitelský sbor: </label>
    <select name="parliament_code" id="advanced_search-select-parliament" class="advanced_search-select">
      <option value="0" selected="selected">Zastupitelský sbor</option>
      <option value="cz/psp">Poslanecká sněmovna</option>
      <option value="cz/senat">Senát</option>
    </select>
  <div id="advanced_search-selects"></div>
</form>
<form id="advanced_search-hidden" action="">
  <input type="hidden" name="constituency" value='' id="advanced_search-hidden-constituency" />
  <input type="hidden" name="member" value='' id="advanced_search-hidden-member" />
  <input type="hidden" name="parliament_code" value='' id="advanced_search-hidden-parliament" />
</form>

{/block}
