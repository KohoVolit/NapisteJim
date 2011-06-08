{extends file="layout.tpl"}

{block name=title}
NapišteJim.cz - seznam veřejným emailů
{/block}

{block name=body}
<table id="list-table">
<thead>
  <tr><td class="list-td-response-status">Stav</td><td class="list-td-responder">Komu</td><td class="list-message" >Zpráva</td><td class="list-td-date">Datum</td><td class="list-td-sender">Od</td></tr>
</thead>
<tbody>
  {foreach $messages as $message}
    <tr>
      <td class="list-td-response-status">
        {foreach $message.response_status as $rs}
          <img src="/images/1x1.png" class="list-response-status list-{$rs.code}" title="{$rs.text}" alt=""/>
        {/foreach}
      </td>
      <td class="list-td-responder">{foreach $message.responder as $responder}{$responder.name}{if !$responder@last}, {/if}{/foreach}</td>
      <td class="list-message" title="{$message.body_short}"><a href="/?message={$message.id}"><span class="list-subject">{$message.subject}</span>&nbsp;<span class="list-body">{$message.body_short}</span></a></td>
      <td class="list-td-date">{$message.date}</td>
      <td class="list-td-sender">{$message.sender_name}</td>
    </tr>
    </a>
  {/foreach}
</tbody>
</table>
{/block}
