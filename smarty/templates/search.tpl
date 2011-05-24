{extends file="layout.tpl"}

{block name=title}{t}NapisteJim.cz{/t} - {t}Search{/t}{/block}

{block name=head}
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.clearfield.packed.js"></script>
<script type="text/javascript" src="js/search.js"></script>
{/block}

{block name=body}

<div id="search-content-wrapper">
	<div id="search-search-wrapper">
	  <form name="search-search" action="" method="get">
	    <input id="search-address" name="address" class="clearField" type="text" value="{t}Your address...{/t}" />
	    <div id="search-right">
	      <input id="search-submit-geocode" type="submit" value="{t}Find representatives{/t}"/>
	      <div id="search-advanced-search" class="small-text dimmed">{t}Advanced search{/t}</div>
	    </div>
	  </form>	  
	</div>

	<div id="search-example">
	  {t}E.g.{/t}: <a href="?address={t escape='url'}Bartonova 951, 547 01 Nachod{/t}">	  {t}Bartonova 951, 547 01 Nachod{/t}</a>, <a href="?address={t escape='url'}331 01{/t}">{t}331 01{/t}</a>, <a href="?address={t escape='url'}Ostrava{/t}">{t}Ostrava{/t}</a>
	</div>
</div>
{/block}
