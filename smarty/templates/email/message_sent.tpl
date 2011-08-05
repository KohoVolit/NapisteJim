{if isset($addressee.sent)}Vaše zpráva byla odeslána Vašim zástupcům:

{foreach $addressee.sent as $a}{$a.first_name} {$a.last_name}
{/foreach}
{else}Vaše zpráva nebyla odeslána Vašim zástupcům.
{/if}
{if isset($addressee.blocked)}

Následující adresáti již stejnou zprávu obdrželi od jiného pisatele a tato
jim už nebyla odeslána.

{foreach $addressee.blocked as $a}{$a.first_name} {$a.last_name},  {if $a.former_message.is_public == 'yes'}zpráva viz. http://napistejim.cz/?message={$a.former_message.id}{else}zpráva byla zaslána soukromě{/if}
{/foreach}

Záměrem projektu {$smarty.const.WTT_TITLE} je podpořit osobní
komunikaci občanů s politiky. I několik málo originálních zpráv má obvykle
větší efekt, než zaplavení politika jednou předpřipravenou zprávou.
Více viz.: http://{$smarty.const.WTT_HOST}/faq#q8
{/if}
{if isset($addressee.no_email)}

U adresátů:

{foreach $addressee.no_email as $a}{$a.first_name} {$a.last_name}
{/foreach}

se nám nepodařilo zjistit jejich e-mailový kontakt a nelze jim Vaší zprávu
odeslat.
{/if}

Pro případ, že se rozhodnete oslovit politiky{if isset($addressee.sent)} i{/if} jiným způsobem, připájíme dole
kopii zprávy.
{if isset($addressee.sent)}

{if $message.is_public == 'yes'}Odeslal(a) jste veřejnou zprávu - bude zveřejněna na webu {$smarty.const.WTT_TITLE}
a na stejném míste bude zveřejněna i případná odpověď oslovených politiků.{else}Zvolil(a) jste soukromou zprávu - na webu {$smarty.const.WTT_TITLE} bude smazána a
případná odpověď oslovených politiků přijde jen přímo Vám.{/if}{/if}

Na tento e-mail neodpovídejte. Chcete-li nám napsat svůj názor na projekt,
návrhy nebo problémy, použijte adresu {$smarty.const.CONTACT_EMAIL}. Rádi si je přečteme.


--- Vaše zpráva pro politiky ---

Předmět: {$message.subject}

{$message.body}
