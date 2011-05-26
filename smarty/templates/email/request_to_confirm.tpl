Na webu NapišteJim.cz jste napsal(a) dole připojenou zprávu svým zástupcům:

{foreach $addressee as $a}{$a.first_name} {$a.last_name}
{/foreach}

Potvrďte prosím kliknutím na odkaz níže, že chcete, aby jim byla odeslána.

	http://napistejim.cz/confirm?action=send&cc={$message.confirmation_code}

Pokud na link nelze kliknout, označte jej a skopírujte jako adresu do
webového prohlížeče.

{if $message.is_public == 'yes'}Zvolil(a) jste veřejnou zprávu - po jejím potvrzení a odeslání
politikům bude zveřejněna na webu NapišteJim.cz. Na stejném míste bude
zveřejněna i jejich případná odpověď.{else}Zvolil(a) jste soukromou zprávu - po jejím potvrzení a odeslání
politikům bude na webu NapišteJim.cz smazána a případná jejich odpověď
přijde jen přímo Vám.{/if}

Pokud jste si to rozmyslel(a) a zprávu politikům odeslat nechcete, nemusíte
dělat nic. Nekliknete-li na výšeuvedený odkaz, připravená zpráva bude po
čase smazána bez odeslání.

Pokud jste tuto zprávu politikům nepsal(a) vy, dejte nám, prosím, vědět na
info@kohovolit.eu.

Na tento e-mail neodpovídejte. Chcete-li nám napsat svůj názor na projekt,
návrhy nebo problémy, použijte adresu info@kohovolit.eu. Rádi si je přečteme.


--- Vaše zpráva pro politiky ---

Předmět: {$message.subject}

{$message.body}
