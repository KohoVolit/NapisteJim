{extends file="basic_layout.tpl"}

{block name=title}{/block}

{block name=head}{/block}

{block name="logo"}
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

{block name=basic_body}
<div class="wrapper-page-outer"><div id="wrapper-page">
{block name=body}
{/block}
</div></div>
{/block}
