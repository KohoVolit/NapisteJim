{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}About project{/t}{/block}

{block name=main}
<h1>{t}About project{/t}</h1>
{t escape=no 1=$smarty.const.NJ_TITLE}MSGID_ABOUT_PROJECT_SECTION{/t}

<div>
<a href="video">&rarr; {t}Video{/t}</a><br/>
<a href="faq">&rarr; {t}Frequently asked questions{/t}</a><br/>
<a href="#authors">&rarr; {t}Authors{/t}</a><br/>
<a href="#tools">&rarr; {t}Published tools examples{/t}</a><br/>
<a href="support">&rarr; {t}Support us{/t}</a>
</div>

<h2 id="authors">{t}Authors{/t}</h2>
{t escape=no 1=$smarty.const.NJ_TITLE}MSGID_AUTHORS_SECTION{/t}

<h2 id="tools">{t}Published tools examples{/t}</h2>
{t escape=no 1=$smarty.const.NJ_TITLE}MSGID_PUBLISHED_TOOLS_EXAMPLES_SECTION{/t}

<p>
{t escape=no}If you like the application and you would like it to be further developed, <a href="/support">support  it</a> please.{/t}
</p>
<p>{t}The application was created with kind support of:{/t}<br/><br/>
<a href="http://www.osi.hu"><img src="http://c0431992.cdn2.cloudfiles.rackspacecloud.com/osf-logo.gif" width='150' height='35' alt='OSI.hu' title='OSI.hu' /></a>
<a href="http://www.osf.cz"><img src="http://www.osf.cz/images/stories/download/static/logo/osf_praha_cz.gif" width='150' height='32' alt='OSF.cz' title='OSF.cz' /></a><br/><br/>
{/block}
