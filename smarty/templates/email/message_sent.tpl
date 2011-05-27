Vaše zpráva byla odeslána Vašim zástupcum:

{foreach $addressee as $a}{$a.first_name} {$a.last_name}
{/foreach}

Pro případ, že se rozhodnete je oslovit i jiným způsobem, připájíme dole
její kopii.

{if $message.is_public == 'yes'}Odeslal(a) jste veřejnou zprávu - bude zveřejněna na webu NapišteJim.cz
a na stejném míste bude zveřejněna i případná odpověď oslovených politiků.{else}Zvolil(a) jste soukromou zprávu - na webu NapišteJim.cz bude smazána a
případná odpověď oslovených politiků přijde jen přímo Vám.{/if}

Na tento e-mail neodpovídejte. Chcete-li nám napsat svůj názor na projekt,
návrhy nebo problémy, použijte adresu info@kohovolit.eu. Rádi si je přečteme.


--- Vaše zpráva pro politiky ---

Předmět: {$message.subject}

{$message.body}
