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
{/block}

{block name=main}
{include file='./write_form.tpl'}
{/block}
