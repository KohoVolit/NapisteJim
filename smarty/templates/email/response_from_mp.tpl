{$mp.first_name} {$mp.last_name} reagoval{if $mp.sex == 'f'}a{/if} na Vaši zprávu zaslanou
přes NapišteJim.cz. {if $mp.sex == 'f'}Její{else}Jeho{/if} odpověď najdete níže.
{if $message.is_public == 'yes'}Protože byla zpráva zaslána jako veřejná, je odpoveď zároveň zveřejněna
na webu NapišteJim.cz.{/if}


Od: {$mp.first_name} {$mp.last_name}
Předmět: {$message.subject}

{$message.body}
