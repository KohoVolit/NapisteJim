{$message.sender_name} Vám poslal tuto zprávu přes web NapišteJim.cz.

{if $message.is_public == 'yes'}Zpráva byla odeslána jako veřejná a je zveřejněna na webu NapišteJim.cz.
Vaše odpoveď bude zveřejněna na stejném míste.{else}Zpráva byla odeslána jako soukromá. Odpovídejte, prosím, přímo na
e-mailovou adresu odesílatele: {$message.sender_email}.{/if}


--- Zpráva pro Vás ---

Předmět: {$message.subject}
Od: {$message.sender_name}

{$message.body}
