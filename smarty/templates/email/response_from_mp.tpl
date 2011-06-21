{$mp.first_name} {$mp.last_name} reagoval{if $mp.sex == 'f'}a{/if} na Vaši zprávu zaslanou přes NapišteJim.cz.
{if $mp.sex == 'f'}Její{else}Jeho{/if} odpověď najdete níže.

{if $message.is_public == 'yes'}Protože byla Vaše zpráva zaslána jako veřejná, je odpověď zároveň
zveřejněna na webu NapišteJim.cz. Budete-li však pokračovat v diskusi
odpovědí na tento e-mail, tato už bude odeslána přímo adresátovi mimo webu
NapišteJim.cz.{/if}


--- Odpověď na Vaši zprávu ---

Od: {$mp.first_name} {$mp.last_name}
Předmět: {$message.subject}

{$message.body}
