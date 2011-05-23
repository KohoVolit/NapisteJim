{extends file="layout.tpl"}

{block name=title}{t}NapisteJim.cz{/t} - {t}Write{/t}{/block}

{block name=head}
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
<script type="text/javascript" src="locale/{$locale}/LC_MESSAGES/locale.js"></script>
<script type="text/javascript" src="js/i18n.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine-{$locale}.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="js/write.js"></script>
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
{/block}

{block name=body}
<br/><br/><br/>!!ODSTRAN TYTO br/ z write.tpl
<div id="write-form-wrapper">

    <form id="write" class="formular" method="post" action="?">
      <input type="hidden" value="{$mps}" name="mp"/>
      
      <div id="write-mps">
        {foreach $mp_details as $key=>$mp}
          <div id="write-mp-{$mp.id}" class="write-mp">
            <div id="write-mp-photo-{$mp.id}" class="write-mp-photo">
              <img src="http://localhost/michal/kohovolit/data/images/{$mp.parliament_code}/images/mp/{$mp.image}" alt="" title="{$mp.last_name}" />
            </div>
            <div id="write-mp-first_name-{$mp.id}" class="write-mp-first_name">{$mp.first_name}</div>
            <div id="write-mp-last_name-{$mp.id}" class="write-mp-last_name">{$mp.last_name}</div>
          </div>
        {/foreach}
      </div>
      
      <div id="write-personal">
        {t}Email is{/t}*: <input type="radio" id="write-radio-1" name="is_public" value="1" class="validate[required] radio" />{t}Public{/t} <input type="radio" id="write-radio-2" name="is_public" value="0" class="validate[required] radio" />{t}Private{/t} <br/>
        {t}Name{/t}*: <input type="text" id="write-name" name="name" value="" class="validate[required] text-input" /><br/>
        {t}Email{/t}*: <input type="text"  id="write-email" name="email" value="" class="validate[required,custom[email]] text-input" /><br/>
        {t}Subject{/t}*: <input type="text" id="write-subject" name="subject" value=""  class="validate[required] text-input" /><br/>
      </div>
      
      <textarea id="write-body" rows="15" cols="62" name="body" class="validate[required,minSize[170]] textarea">
       {t}Greetings{/t},
       &#010;&#010;&#010;&#010;
       {t}Yours sincerely{/t},&#010;&#010;
      </textarea>
      
      <input class="submit" type="submit" value="Send"/>
    </form>
    
  </div>
{/block}
