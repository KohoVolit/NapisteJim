{extends file="layout.tpl"}

{block name=title}{$smarty.const.WTT_TITLE} – {t}Found Representatives{/t}{/block}

{block name=head}
<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.2&sensor=false"></script>
<script type="text/javascript">
//define global variables from settings.php
var country_name = "{$smarty.const.COUNTRY_NAME}";
var country_code = "{$smarty.const.COUNTRY_CODE}";
var required_address_level = "{$smarty.const.REQUIRED_ADDRESS_LEVEL}";
var map_center_lat = "{$smarty.const.MAP_CENTER_LAT}";
var map_center_lng = "{$smarty.const.MAP_CENTER_LNG}";
var map_zoom = "{$smarty.const.MAP_ZOOM}";
var lang = "{$locale.lang}";
var address = "{$address}";
</script>
<script type="text/javascript" src="locale/{$locale.system_locale}/LC_MESSAGES/locale.js"></script>
<script type="text/javascript" src="js/i18n.js"></script>
<script type="text/javascript" src="js/jquery.rsv.js"></script>
<script type="text/javascript" src="js/jquery.ui.highlight.js"></script>
<script type="text/javascript" src="js/search_results.js"></script>
{/block}

{block name=body}
  <div id="search_results-content-top-wrapper">
	<div id="search_results-map_canvas"></div>
	<div id="search_results-message"></div>
	<div id="search_results-search-wrapper">
	  <form name="search_results-search" action="">
	    <input id="search_results-geocode-address" name="address" type="textbox" value="{$address}" />
	    <input id="search_results-submit-geocode" type="submit" value="{t}Změnit adresu{/t}"/>
	  </form>
	</div>
	<div id="search_results-formatted-address"></div>
	<div id="search_results-message-debug"></div>
	<div id="search_results-addressee">
	  <h2>{t}Adresáti{/t}</h2><div id="search_results-up-to">{t}Přetažením jmen do boxů nebo kliknutím na jméno vyberte ze svých politiků nejvíce tři adresáty Vaší zprávy. Dalším  politikům pak už stejnou zprávu nebudete moct odeslat.{/t} <a class="small-text" href="faq#q2" target="_blank">Proč?</a></div>
	  <div id="search_results-addressee-box-1" class="addressee-box rounded-corners droppable"></div>
	  <div id="search_results-addressee-box-2" class="addressee-box rounded-corners droppable"></div>
	  <div id="search_results-addressee-box-3" class="addressee-box rounded-corners droppable"></div>
	  
	  <form id="search_results-send" action="" >

	    <input type="hidden" name="mp" id="search_results-input" value="" />
	    <input type="hidden" name="location" id="search_results-input-2" value="" />
	    <input id="search_results-submit-mps" type="submit" value="{t}Napište jim!{/t}"/>
	  </form>
	</div>
  </div>
	
<div id="search_results-result"></div>
{/block}
