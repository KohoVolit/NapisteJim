{extends file="basic_layout.tpl"}

{block name=title}{t}NapišteJim.cz{/t} - {t}Vyhledání{/t}{/block}

{block name=head}
<script type="text/javascript" src="js/jquery.clearfield.packed.js"></script>
<script type="text/javascript" src="js/search.js"></script>
{/block}
{block name=logo}
  <div id="logo-center" class="logo">
	    <a href="http://napistejim.cz"><img src="images/logo_project.png" title ="NapišteJim.cz" alt="NapišteJim.cz" width=314 height=166/></a>
  </div>
{/block}
{block name=basic_body}

<div id="search-content-wrapper">
	<div id="search-search-wrapper">
	  <form name="search-search" action="" method="get">
	    <fieldset class="search">
	      <input id="search-address" name="address" class="clearField" type="text" value="{t}Vaše adresa ...{/t}" />
	      <div id="search-advanced-search" class="small-text">
	        <a href="?advanced">{t}Rozšířené vyhledávání{/t}</a>
	      </div>
	    </fieldset>
		<div id="search-example">
		  {t}Např.{/t}: <a href="?address={t escape='url'}Bartoňova 951, 547 01 Náchod{/t}">	  {t}Bartonova 951, 547 01 Nachod{/t}</a>, <a href="?address={t escape='url'}331 01{/t}">{t}331 01{/t}</a>, <a href="?address={t escape='url'}Ostrava{/t}">{t}Ostrava{/t}</a>
		</div>
	    <div id="search-submit">
	      <input id="search-submit-geocode" type="submit" value="{t}Najít své politiky{/t}"/>
	    </div>
	  </form>	  
	</div>

	
</div>
{/block}
