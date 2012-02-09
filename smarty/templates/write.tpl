{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}Write message{/t}{/block}

{block name=head}
	<script type="text/javascript" src="locale/{$locale.system_locale}/LC_MESSAGES/messages.js"></script>
	<script type="text/javascript" src="js/i18n.js"></script>
	<script type="text/javascript" src="js/jquery.validationEngine-{$locale.system_locale}.js"></script>
	<script type="text/javascript" src="js/jquery.validationEngine.js"></script>
	<script type="text/javascript" src="js/jquery.caret.js"></script>
	<script type="text/javascript" src="js/write.js"></script>
	<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css" />
	{if isset($css) && !empty($css)}<link rel="stylesheet" href="{$css}" type="text/css" />{/if}
{/block}

{block name=main}
<div id="write-form-wrapper">
	<form id="write" class="formular" method="post" action="?">
		<input type="hidden" value="{$mp_list}" name="mp" />
		<h2>{t}Your message for politicians{/t}</h2>
		<p>{t}Write your message for selected representatives. Please write personally, do not copy&paste a text prearranged by someone. If a politician already received the same message from someone else it will not be sent again.{/t} <a class="small-text" href="faq#q8" target="_blank">{t}Why?{/t}</a></p>

		<div id="write-fields">
			<span class="caption">{t}Your name:{/t}</span><br /><input type="text" id="write-name" name="name" value="" class="validate[required] text-input" /><br />
			<span class="caption">{t}Town:{/t}</span><br /><input type="text" id="write-address" name="address" value="{$locality}" class="text-input" /><br />
			<span class="caption">{t}E-mail:{/t}</span><br /><input type="text"  id="write-email" name="email" value="" class="validate[required,custom[email]] text-input" /><br />
			<span class="caption">{t}Subject:{/t}</span><br /><input type="text" id="write-subject" name="subject" value=""  class="validate[required] text-input" />
			<div id="write-privacy">
				<div class="caption">{t}The message is:{/t}</div>
				<div class="option"><input type="radio" id="write-radio-public" name="is_public" value="yes" class="validate[required] radio" /><span>{t}public{/t}</span></div>
				<div class="option"><input type="radio" id="write-radio-private" name="is_public" value="no" class="validate[required] radio" /><span>{t}private{/t}</span></div>
				<div id="write-explanation-public" class="explanation ui-state-highlight ui-corner-all">{t escape=no}A <strong>public message</strong> will be published on this web together with beeing sent. So will be all eventual responses you receive from the addressed MPs.{/t}</div>
				<div id="write-explanation-private" class="explanation ui-state-highlight ui-corner-all">{t escape=no}A <strong>private message</strong> will be sent to the addressees without publishing. They will send their eventual response directly and exclusively to you.{/t}</div>
			</div>
		</div>

		<div id="write-mps">
			{foreach $mp_details as $mp}
				<div id="write-mp-{$mp.id}" class="mp">
					{assign "personal_name" format_personal_name($mp)}
					<img src="{if !empty($mp.image)}{$smarty.const.API_FILES_URL}/{$mp.image}{else}http://{$smarty.const.NJ_HOST}/images/head_{if $mp.sex == 'f'}female{else}male{/if}_small.png{/if}" title="{$personal_name}" alt="{$personal_name}" />
					<span class="name">{$personal_name}</span>,<br />
					{if !empty($mp.political_group)}{$mp.political_group},<br />{/if}
					{$mp.parliament}
				</div>
			{/foreach}
		</div>

		<textarea id="write-body" name="body" class="validate[required,minSize[90]] textarea" data-prompt-position="topRight:-140">{include file="./email/initial_message.tpl"}</textarea>
		<input type="checkbox" id="write-newsletter" name="newsletter" value="order-newsletter" />
		{t 1=$smarty.const.NJ_TITLE}I want to receive news from %1{/t}<br /><br />
		<input id="write-submit" class="submit" type="submit" value="{t}Send{/t}" />
		<input type="hidden" id="write-requested-at" name="form_requested_at" value="{$requested_at}" />
		<input type="hidden" id="write-css" name="css" value="{if isset($css)}{$css}{/if}" />
    </form>
</div>
{/block}
