{extends file="basic_layout.tpl"}

{block name=title}{/block}

{block name=head}{/block}

{block name="logo"}
<div id="head">
  <div id="logo-small">
    <a href="/">
      <img height="79" width="150" alt="NapišteJim.cz" src="images/logo.png">
    </a>
  </div>
</div>
{/block}


{block name=basic_body}
<div id="wrapper-page">
{block name=body}
{/block}
</div>
{/block}

