{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}Choose your representatives{/t}{/block}

{block name=head}
<script type="text/javascript" src="locale/{$locale.system_locale}/LC_MESSAGES/messages.js"></script>
<script type="text/javascript" src="js/i18n.js"></script>
<script type="text/javascript" src="js/jquery.rsv.js"></script>
<script type="text/javascript" src="js/choose_advanced.js"></script>
{/block}

{block name=main}
<h2>{t}Addressees{/t}</h2><div id="choose-up-to">{t}Choose up to three addressees of your message from the found politicians by clicking on their name or using drag&drop into boxes. The same message then cannot be sent again to other politicians.{/t} <a class="small-text" href="faq#q2" target="_blank">{t}Why?{/t}</a></div>
  <div id="choose-addressee-box-1" class="addressee-box rounded-corners droppable"></div>
  <div id="choose-addressee-box-2" class="addressee-box rounded-corners droppable"></div>
  <div id="choose-addressee-box-3" class="addressee-box rounded-corners droppable"></div>
  <form id="choose-send" action="" >
    <input type="hidden" name="mp" id="choose-input" value="" />
    <input id="choose-submit-mps" type="submit" value="{t}Write to them!{/t}"/>
  </form>  
             <div class="group-mps">
				{foreach $mps as $mp}
		          
		            <div id="mp-{$parliament.code}/{$mp.id}" class="mp">
<!-- &nbsp; needed by IE8 -->&nbsp;<span id="mp-toggle-{$parliament.code}/{$mp.id}" class="mp-toggle mp-clicked-off mp-clicked-{$mp.id} ui-icon ui-icon-check mp-{$mp.id}"></span>
		              <span class="mp-name">
		                <span id="mp-name-name-{$parliament.code}/{$mp.id}" class="mp-name-name mp-clicked-off mp-clicked-{$mp.id} draggable">{assign "personal_name" format_personal_name($mp)}{$personal_name}</span>
		              </span>
		            </div>
		         
		        {/foreach}
            </div>
{/block}
