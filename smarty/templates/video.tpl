{extends file="layout.tpl"}

{block name=title}{$smarty.const.NJ_TITLE} – {t}Video{/t}{/block}

{block name=body}
<h1>{t}Video{/t}</h1>
{t escape=no 1=$smarty.const.NJ_TITLE}MSGID_VIDEO_SECTION{/t}

<p>
{t 1='http://www.youtube.com/kohovolit' 2='Youtube'}Watch the videos on <a href="%1">%2</a>{/t}.
</p>
<object style="height: 390px; width: 640px"><param name="movie" value="http://www.youtube.com/v/UKmMiNxd0xk?version=3"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><embed src="http://www.youtube.com/v/UKmMiNxd0xk?version=3" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="640" height="390"></object>
{/block}
