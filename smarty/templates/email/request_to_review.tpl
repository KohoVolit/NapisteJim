Zpráva napsaná přes web {$smarty.const.WTT_TITLE} se zdá jako urážející a aby mohla být
odeslána, potřebuje tvoje posouzení a schválení. Napsaná zpráva je připojena
níže.

Pokud je zpráva v pořádku a MÁ SE ODESLAT adresátům, klikni na tento odkaz:
http://{$smarty.const.WTT_HOST}/confirm?action=approve&cc={$message.confirmation_code}&ac={$message.approval_code}

Pokud je zpráva urážející a NEMÁ SE ODESLAT adresátům, klikni sem:
http://{$smarty.const.WTT_HOST}/confirm?action=refuse&cc={$message.confirmation_code}&ac={$message.approval_code}


--- Napsaná zpráva pro politiky ---

Předmět: {$message.subject}

{$message.body}
