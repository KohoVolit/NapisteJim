{extends file="main_html.tpl"}

{block name=title}{/block}

{block name=head}{/block}

{block name=top}
{if !isset($css)}
<div id="head">
	<div id="top-content">
		<div id="logo-small" class="logo">
			<a href="/"><img height="79" alt="{$smarty.const.NJ_TITLE}" src="images/{$smarty.const.SMALL_LOGO_FILENAME}"></a>
		</div>
		<div id="links-top">
			<a href="/search">{t}Write to them!{/t}</a>
			<a href="/public">{t}Public messages and answers{/t}</a>
			<a href="/statistics">{t}Statistics{/t}</a>
			<a href="/about">{t}About{/t}</a>
			<a href="/video">{t}Video{/t}</a><br />
			<a href="/support">{t}Support us{/t}</a>
			<a href="{t}http://en.kohovolit.eu{/t}">KohoVolit.eu</a>
		</div>
	</div>
</div>
{/if}
{/block}

{block name=content}
<div class="content-wrapper"><div id="content-inner-wrapper">{block name=main}{/block}</div></div>
{/block}

{block name=bottom}
{if !isset($css)}
<div id="page-footer">
	<div id="social" class="social-bar">
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

	<div id="licence">
		<a href="http://www.gnu.org/licenses/gpl.html">{t}Licence{/t}</a> – <a href="/privacy">{t}Privacy{/t}</a> – <a href="/contact">{t}Contact{/t}</a>
	</div>
</div>
{/if}
{/block}
