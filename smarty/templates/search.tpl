{extends file="main_html.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}Search your representatives{/t}{/block}

{block name=head}
<script type="text/javascript" src="js/jquery.clearfield.packed.js"></script>
<script type="text/javascript" src="js/search.js"></script>
{/block}

{block name=top}
	<div id="front-social" class="social-bar">
		<!--twitter-->
		<div style="float:left;">
			<a href="https://twitter.com/share" class="twitter-share-button" data-via="KohoVolitEU">Tweet</a>
		</div>
		<script>{literal}!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");{/literal}</script>

		<!--facebook-->
		<div id="fb-root"></div>
		<script>{literal}(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = '//connect.facebook.net/{/literal}{$locale.system_locale|truncate:5:""}{literal}/all.js#xfbml=1';
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));{/literal}
		</script>
		<div class="fb-like" data-send="false" data-layout="button_count" data-width="130" data-show-faces="true"></div>

		<!--google+-->
		<g:plusone annotation="inline" size="small" width="220"></g:plusone>
		<!-- Place this render call where appropriate -->
		<script type="text/javascript">{literal}
			window.___gcfg = {lang: '{/literal}{$locale.lang}{literal}'};
			(function() {
				var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				po.src = 'https://apis.google.com/js/plusone.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			})();{/literal}
		</script>
	</div>

	<div id="logo-center" class="logo">
		<a href="/"><img src="images/{$smarty.const.LOGO_FILENAME}" title ="{$smarty.const.NJ_TITLE}" alt="{$smarty.const.NJ_TITLE}" width=314 /></a>
	</div>
{/block}

{block name=content}
<div id="search-content-wrapper">
	<div id="search-search-wrapper">
		<form name="search-search" action="" method="get">
			<fieldset class="search">
				<input id="search-address" name="address" class="clearField" type="text" value="{t}Your address{/t}&hellip;" />
				<div id="search-example">
					{t}E.g.{/t}: <a href="?address={t escape='url'}MSGID_ADDRESS_EXAMPLE_1{/t}">{t}MSGID_ADDRESS_EXAMPLE_1{/t}</a> {t}or{/t} <a href="?address={t escape='url'}MSGID_ADDRESS_EXAMPLE_2{/t}">{t}MSGID_ADDRESS_EXAMPLE_2{/t}</a> {t}or{/t} <a href="?address={t escape='url'}MSGID_ADDRESS_EXAMPLE_3{/t}">{t}MSGID_ADDRESS_EXAMPLE_3{/t}</a>
				</div>
				<div id="search-submit">
					<input id="search-submit-geocode" type="submit" value="{t}Search your representatives{/t}"/>
				</div>
				<div id="search-advanced-search" class="small-text">
					<a href="?advanced">{t}Advanced search{/t}</a>
				</div>
			</fieldset>
		</form>
	</div>

</div>
<div id="links-bottom">
	<a href="/public">{t}Public messages and answers{/t}</a>
	<a href="/statistics">{t}Statistics{/t}</a>
	<a href="/about">{t}About{/t}</a>
	<a href="/video">{t}Video{/t}</a>
	<a href="/support">{t}Support us{/t}</a>
	<a href="{t}http://en.kohovolit.eu{/t}">KohoVolit.eu</a>
</div>
{/block}

{block name=bottom}
<div id="page-footer">
	<div id="licence">
		<a href="http://www.gnu.org/licenses/gpl.html">{t}Licence{/t}</a> – <a href="/privacy">{t}Privacy{/t}</a> – <a href="/contact">{t}Contact{/t}</a>
	</div>
</div>
{/block}
