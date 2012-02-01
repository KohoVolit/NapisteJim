{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}Choose your representatives{/t}{/block}

{block name=head}
<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.2&sensor=false&language={$smarty.const.AREAS_LANGUAGE}&region={$smarty.const.COUNTRY_CODE}"></script>
<script type="text/javascript">
var country_name = "{$smarty.const.COUNTRY_NAME}";
var address = "{$address}";
var required_address_level = "{$smarty.const.REQUIRED_ADDRESS_LEVEL}";
var map_center_lat = "{$smarty.const.MAP_CENTER_LAT}";
var map_center_lng = "{$smarty.const.MAP_CENTER_LNG}";
var map_zoom = "{$smarty.const.MAP_ZOOM}";
</script>
<script type="text/javascript" src="locale/{$locale.system_locale}/LC_MESSAGES/messages.js"></script>
<script type="text/javascript" src="js/i18n.js"></script>
<script type="text/javascript" src="js/jquery.rsv.js"></script>
<script type="text/javascript" src="js/jquery.ui.highlight.js"></script>
<script type="text/javascript" src="js/choose.js"></script>
{/block}

{block name=main}
  <div id="choose-content-top-wrapper">
	<div class="wrapper"><div id="choose-map-column">
		<div id="choose-map_canvas"></div>
		<div id="choose-message"></div>
		<div id="choose-search-wrapper">
		  <form name="choose-search" action="">
			<input id="choose-geocode-address" name="address" type="textbox" value="{$address}" />
			<input id="choose-submit-geocode" type="submit" value="{t}Change address{/t}"/>
		  </form>
		</div>
		<div id="choose-formatted-address"></div>
		<div id="choose-message-debug"></div>
	</div></div>
	<div id="choose-main-column">
		<div id="choose-addressee">
		  <h2>{t}Addressees{/t}</h2><div id="choose-up-to">{t}Choose up to three addressees of your message from the found politicians by clicking on their name or using drag&drop into boxes. The same message then cannot be sent again to other politicians.{/t} <a class="small-text" href="faq#q2" target="_blank">{t}Why?{/t}</a></div>
		  <div class="addressee-box-wrapper rounded-corners"><div id="choose-addressee-box-1" class="addressee-box droppable"></div></div>
		  <div class="addressee-box-wrapper rounded-corners"><div id="choose-addressee-box-2" class="addressee-box droppable"></div></div>
		  <div class="addressee-box-wrapper rounded-corners"><div id="choose-addressee-box-3" class="addressee-box droppable"></div></div>
		  <form id="choose-send" action="" >
			<input type="hidden" name="mp" id="choose-input" value="" />
			<input id="choose-submit-mps" type="submit" value="{t}Write to them!{/t}"/>
		  </form>
		</div>
	  </div>		
		<div id="choose-result"></div>
	</div>
{/block}
