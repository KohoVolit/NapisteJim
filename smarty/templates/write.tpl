{extends file="layout.tpl"}

{block name=title}NapišteJim.cz - Napsat zprávu{/block}

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
              <img src="{$img_url}{$mp.image}" alt="" title="{$mp.last_name}" />
            </div>
            <div id="write-mp-first_name-{$mp.id}" class="write-mp-first_name">{$mp.first_name}</div>
            <div id="write-mp-last_name-{$mp.id}" class="write-mp-last_name">{$mp.last_name}</div>
          </div>
        {/foreach}
      </div>
      
      <div id="write-personal">
        Zpráva je: <input type="radio" id="write-radio-1" name="is_public" value="yes" class="validate[required] radio" />Veřejná <input type="radio" id="write-radio-2" name="is_public" value="no" class="validate[required] radio" />Soukromá <br/>
        Vaše jméno: <input type="text" id="write-name" name="name" value="" class="validate[required] text-input" /><br/>
        E-mail: <input type="text"  id="write-email" name="email" value="" class="validate[required,custom[email]] text-input" /><br/>
        Předmět: <input type="text" id="write-subject" name="subject" value=""  class="validate[required] text-input" /><br/>
      </div>
      <textarea id="write-body" rows="15" cols="62" name="body" class="validate[required,minSize[90]] textarea">
	  {include file="email/initial_message.tpl"}</textarea>
      <input type="checkbox" id="write-newsletter" name="newsletter" value="order-newsletter" /> {t}Chci dostávat informace z NapišteJim.cz{/t}<br/>
      <input class="submit" type="submit" value="Odeslat"/>
    </form>
    
  </div>
{/block}
