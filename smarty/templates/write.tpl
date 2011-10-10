{extends file="layout.tpl"}

{block name=title}{$smarty.const.WTT_TITLE} – Napsat zprávu{/block}

{block name=head}
<script type="text/javascript" src="locale/{$locale.system_locale}/LC_MESSAGES/locale.js"></script>
<script type="text/javascript" src="js/i18n.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine-{$locale.system_locale}.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="js/write.js"></script>
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
{/block}

{block name=body}
<div id="write-form-wrapper">

    <form id="write" class="formular" method="post" action="?">
      <input type="hidden" value="{$mps}" name="mp"/>
      <h2>Vaše zpráva pro politiky</h2>
	  <p>Napište svou zprávu pro vybrané politiky. Pište prosím osobně, nekopírujte text, který někdo předem připravil. Pokud politik už stejnou zprávu dostal od někoho jiného, nebude mu odeslána znovu. <a class="small-text" href="faq#q8" target="_blank">Proč?</a></p>

      <div id="write-mps">
        {foreach $mp_details as $key=>$mp}
          <div id="write-mp-{$mp.id}" class="addressee-box rounded-corners write-mp">
            <div id="write-mp-photo-{$mp.id}" class="write-mp-photo">
              <img src="{$smarty.const.API_FILES_URL}/{$mp.image}" alt="" title="{$mp.last_name}"  height="162"/>
            </div>
            <div id="write-mp-first_name-{$mp.id}" class="write-mp-first_name">{$mp.first_name}</div>
            <div id="write-mp-last_name-{$mp.id}" class="write-mp-last_name">{$mp.last_name}</div>
          </div>
        {/foreach}
      </div>

      <div id="write-personal">
        Vaše jméno: <br/><input type="text" id="write-name" name="name" value="" class="validate[required] text-input write-input" /><br/>
        Obec: <br/><input type="text" id="write-address" name="address" value="{$location}" class="text-input write-input" /><br/>
        E-mail: <br/><input type="text"  id="write-email" name="email" value="" class="validate[required,custom[email]] text-input write-input" /><br/>
        Předmět: <br/><input type="text" id="write-subject" name="subject" value=""  class="validate[required] text-input write-input" />
        <div id="write-privacy">Zpráva je: <input type="radio" id="write-radio-1" name="is_public" value="yes" class="validate[required] radio write-input" />Veřejná <input type="radio" id="write-radio-2" name="is_public" value="no" class="validate[required] radio" />Soukromá </div>
      </div>

      <textarea id="write-body" rows="15" cols="80" name="body" class="validate[required,minSize[90]] textarea">{include file="email/initial_message.tpl"}</textarea>
      <br/>
      <input type="checkbox" id="write-newsletter" name="newsletter" value="order-newsletter" />
       Chci dostávat informace z {$smarty.const.WTT_TITLE}<br/><br/>
      <input id="write-submit" class="submit" type="submit" value="Odeslat"/>
    </form>

  </div>
{/block}
