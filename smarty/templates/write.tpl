{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}Write message{/t}{/block}

{block name=head}
<script type="text/javascript" src="locale/{$locale.system_locale}/LC_MESSAGES/messages.js"></script>
<script type="text/javascript" src="js/i18n.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine-{$locale.system_locale}.js"></script>
<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="js/write.js"></script>
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
{/block}

{block name=body}
<div id="write-form-wrapper">

    <form id="write" class="formular" method="post" action="?">
      <input type="hidden" value="{$mp_list}" name="mp"/>
      <h2>{t}Your message for politicians{/t}</h2>
	  <p>{t}Write your message for selected representatives. Please write personally, do not copy&paste a text prearranged by someone. If a politician already received the same message from someone else it will not be sent again.{/t} <a class="small-text" href="faq#q8" target="_blank">{t}Why?{/t}</a></p>

      <div id="write-personal">
        {t}Your name:{/t} <br/><input type="text" id="write-name" name="name" value="" class="validate[required] text-input write-input" /><br/>
        {t}Town:{/t} <br/><input type="text" id="write-address" name="address" value="{$locality}" class="text-input write-input" /><br/>
        {t}E-mail:{/t} <br/><input type="text"  id="write-email" name="email" value="" class="validate[required,custom[email]] text-input write-input" /><br/>
        {t}Subject:{/t} <br/><input type="text" id="write-subject" name="subject" value=""  class="validate[required] text-input write-input" />
        <div id="write-privacy">{t}The message is:{/t} <input type="radio" id="write-radio-1" name="is_public" value="yes" class="validate[required] radio write-input" />{t}public{/t} <input type="radio" id="write-radio-2" name="is_public" value="no" class="validate[required] radio" />{t}private{/t} </div>
      </div>

      <div id="write-mps">
        {foreach $mp_details as $key=>$mp}
          <div id="write-mp-{$mp.id}" class="addressee-box rounded-corners write-mp">
            <div id="write-mp-photo-{$mp.id}">
				<img src="{if !empty($mp.image)}{$smarty.const.API_FILES_URL}/{$mp.image}{else}http://{$smarty.const.NJ_HOST}/images/head_{if $mp.sex == 'f'}female{else}male{/if}_small.png{/if}" title="{assign "personal_name" format_personal_name($mp, 'full')}{$personal_name}" alt="{$personal_name}" class="write-mp-photo" />
            </div>
            <div id="write-mp-first_name-{$mp.id}" class="write-mp-first_name">{assign "personal_name" format_personal_name($mp)}{$personal_name}</div>
          </div>
        {/foreach}
      </div>

      <textarea id="write-body" name="body" class="validate[required,minSize[90]] textarea">{include file="email/initial_message.tpl"}</textarea>
      <br/>
      <input type="checkbox" id="write-newsletter" name="newsletter" value="order-newsletter" />
       {t 1=$smarty.const.NJ_TITLE}I want to receive news from %1{/t}<br/><br/>
      <input id="write-submit" class="submit" type="submit" value="{t}Send{/t}"/>
    </form>
	
  </div>
{/block}
