{extends file="layout.tpl"}

{block name=title}
NapišteJim.cz - výběr
{/block}
{block name=head}
<script type="text/javascript" src="locale/{$locale}/LC_MESSAGES/locale.js"></script>
<script type="text/javascript" src="js/i18n.js"></script>
<script type="text/javascript" src="js/jquery.rsv.js"></script>
<script type="text/javascript" src="js/search_results_advanced.js"></script>
{/block}
{block name=body}
<h2>{t}Adresáti{/t}</h2><div id="search_results-up-to">{t}Přetažením jmen do boxů nebo kliknutím na jméno vyberte až 3 adresáty ze svých politiků{/t}</div>
  <div id="search_results-addressee-box-1" class="addressee-box rounded-corners droppable"></div>
  <div id="search_results-addressee-box-2" class="addressee-box rounded-corners droppable"></div>
  <div id="search_results-addressee-box-3" class="addressee-box rounded-corners droppable"></div>
  <form id="search_results-send" action="" >
    <input type="hidden" name="mp" id="search_results-input" value="" />
    <input id="search_results-submit-mps" type="submit" value="{t}Napište jim!{/t}"/>
  </form>  
             <div class="group-mps">
				{foreach $mps as $mp}
		          
		            <div id="mp-{$parliament.code}/{$mp.id}" class="mp">
<!-- &nbsp; needed by IE8 -->&nbsp;<span id="mp-toggle-{$parliament.code}/{$mp.id}" class="mp-toggle mp-clicked-off mp-clicked-{$mp.id} ui-icon ui-icon-check mp-{$mp.id}"></span>
		              <span class="mp-name">
		                <span id="mp-name-name-{$parliament.code}/{$mp.id}" class="mp-name-name mp-clicked-off mp-clicked-{$mp.id} draggable">{$mp.last_name}&nbsp;{$mp.first_name}</span>
		                
		              </span>
		            </div>
		         
		        {/foreach}
            </div>
{/block}
