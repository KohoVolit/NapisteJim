Na webu {$smarty.const.WTT_TITLE} jste napsal(a) dole připojenou zprávu svým zástupcům:

{foreach $addressee as $a}{$a.first_name} {$a.last_name}
{/foreach}

Potvrďte prosím kliknutím na odkaz níže, že chcete, aby jim byla odeslána.

	http://{$smarty.const.WTT_HOST}/confirm?action=send&cc={$message.confirmation_code}

Pokud na link nelze kliknout, označte jej a skopírujte jako adresu do
webového prohlížeče.

{if $message.is_public == 'yes'}Zvolil(a) jste veřejnou zprávu - po jejím potvrzení a odeslání
politikům bude zveřejněna na webu {$smarty.const.WTT_TITLE}. Na stejném míste bude
zveřejněna i jejich případná odpověď.{else}Zvolil(a) jste soukromou zprávu - po jejím potvrzení a odeslání
politikům bude na webu {$smarty.const.WTT_TITLE} smazána a případná jejich odpověď
přijde jen přímo Vám.{/if}


Pokud jste si to rozmyslel(a) a zprávu politikům odeslat nechcete, nemusíte
dělat nic. Nekliknete-li na výšeuvedený odkaz, připravená zpráva bude po
čase smazána bez odeslání.

Pokud jste tuto zprávu politikům nepsal(a) vy, dejte nám, prosím, vědět na
{$smarty.const.CONTACT_EMAIL}.

Na tento e-mail neodpovídejte. Chcete-li nám napsat svůj názor na projekt,
návrhy nebo problémy, použijte adresu {$smarty.const.CONTACT_EMAIL}. Rádi si je přečteme.


--- Vaše zpráva pro politiky ---

Předmět: {$message.subject}

{$message.body}
