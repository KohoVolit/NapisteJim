{extends file="main_html.tpl"}

{block name=title}{/block}

{block name=head}{/block}

{block name=top}
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
{/block}

{block name=content}
<div class="wrapper-page-outer"><div id="wrapper-page">
	{block name=main}{/block}
</div></div>
{/block}

{block name=bottom}
<div id="page-footer">
	<div id="licence">
	  <a href="http://www.gnu.org/licenses/gpl.html">{t}Licence{/t}</a> – <a href="/privacy">{t}Privacy{/t}</a> – <a href="/contact">{t}Contact{/t}</a>
	</div>
</div>
{/block}
