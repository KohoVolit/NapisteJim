{extends file="layout.tpl"}

{block name=title}{t}NapisteJim.cz{/t}-{t}search{/t}{/block}

{block name=head}
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.clearfield.packed.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine-{$locale}.js"></script>
<script type="text/javascript" src="js/search.js"></script>
{/block}

{block name=body}

<div id="search-content-wrapper">
	<div id="search-search-wrapper">
	  <form name="search" action="index.php" method="get">
	    <input id="address" class="clearField" type="textbox" value="{t}Your address...{/t}" />
	    <input id="submit" type="submit" value="{t}Find representatives{/t}"/>
	  </form>
	</div>

	<div id="search-example">
	  {t}E.g.{/t}: <a href="?address={t escape='url'}Bartonova 951, 547 01 Nachod{/t}">	  {t}Bartonova 951, 547 01 Nachod{/t}</a>, <a href="?address={t escape='url'}331 01{/t}">331 01</a>, <a href="?address={t escape='url'}Ostrava{/t}">Ostrava</a>
	</div>
</div>
{/block}
