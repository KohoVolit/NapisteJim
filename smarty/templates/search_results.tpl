{extends file="layout.tpl"}

{block name=title}{t}NapisteJim.cz{/t} - {t}Found Representatives{/t}{/block}

{block name=head}
<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.2&sensor=false"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
<script type="text/javascript">
//define global variables from settings.php
var parent_region = "{$parent_region}";
var parent_region_type = "{$parent_region_type}";
var lang = "{$lang}";
var reg = "{$reg}";
var region_check = "{$region_check}";
var address = "{$address}";
var lat = "{$lat}";
var lng = "{$lng}";
var zoom = "{$zoom}";
</script>
<script type="text/javascript" src="locale/{$locale}/LC_MESSAGES/locale.js"></script>
<script type="text/javascript" src="js/i18n.js"></script>
<script type="text/javascript" src="js/search_results.js"></script>
{/block}

{block name=body}
  <div id="search_results-content-top-wrapper">
	<div id="search_results-search-wrapper">
	  <form name="search_results-search" action="javascript:codeAddress()">
	    <input id="search_results-geocode-address" type="textbox" value="{$address}" />
	    <input id="search_results-submit-geocode" type="submit" value="{t}Change address{/t}"/>
	  </form>
	</div>
	<div id="search_results-formatted-address"></div>
	<div id="search_results-message"></div>
	<div id="search_results-message-debug"></div>
	<div id="search_results-addressee">
	  <h2>{t}Addressees{/t}</h2><div id="search_results-up-to">(up to 3)</div>
	  <div id="search_results-addressee-box-1" class="addressee-box rounded-corners droppable"></div>
	  <div id="search_results-addressee-box-2" class="addressee-box rounded-corners droppable"></div>
	  <div id="search_results-addressee-box-3" class="addressee-box rounded-corners droppable"></div>
	  <form id="search_results-selected-mps" >
	  <input type="hidden" name="input-1" id="search_results-input-1" />
	  <input type="hidden" name="input-2" id="search_results-input-2" />
	  <input type="hidden" name="input-3" id="search_results-input-3" />
	  <input id="search_results-submit-mps" type="submit" value="{t}Write!{/t}"/>
	  </form>
	</div>
  </div>
	<div id="search_results-map_canvas"></div>
<div id="search_results-result"></div>
{/block}
