{extends file="basic_layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}Search your representatives{/t}{/block}

{block name=head}
<script type="text/javascript" src="js/jquery.clearfield.packed.js"></script>
<script type="text/javascript" src="js/search.js"></script>
{/block}
{block name=logo}
  <div id="logo-center" class="logo">
	    <a href="/"><img src="images/logo_project.png" title ="{$smarty.const.NJ_TITLE}" alt="{$smarty.const.NJ_TITLE}" width=314 height=166/></a>
  </div>
{/block}
{block name=basic_body}

<div id="search-content-wrapper">
	<div id="search-search-wrapper">
	  <form name="search-search" action="" method="get">
	    <fieldset class="search">
	      <input id="search-address" name="address" class="clearField" type="text" value="{t}Your address{/t}&hellip;" />
	      <div id="search-advanced-search" class="small-text">
	        <a href="?advanced">{t}Advanced search{/t}</a>
	      </div>
	    </fieldset>
		<div id="search-example">
		  {t}E.g.{/t}: <a href="?address={t escape='url'}MSGID_ADDRESS_EXAMPLE_1{/t}">{t}MSGID_ADDRESS_EXAMPLE_1{/t}</a> {t}or{/t} <a href="?address={t escape='url'}MSGID_ADDRESS_EXAMPLE_2{/t}">{t}MSGID_ADDRESS_EXAMPLE_2{/t}</a> {t}or{/t} <a href="?address={t escape='url'}MSGID_ADDRESS_EXAMPLE_3{/t}">{t}MSGID_ADDRESS_EXAMPLE_3{/t}</a>
		</div>
	    <div id="search-submit">
	      <input id="search-submit-geocode" type="submit" value="{t}Search your representatives{/t}"/>
	    </div>
	  </form>	  
	</div>
	
</div>
{/block}
