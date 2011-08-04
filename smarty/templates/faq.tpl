{extends file="layout.tpl"}

{block name=title}{$smarty.const.WTT_TITLE} – Otázky a odpovědi{/block}

{block name=body}
<h1>Otázky a odpovědi</h1>

<p>
<a href="#q1">1. Jak vyhledám komu chci napsat?</a><br/>
<a href="#q2">2. Proč si mohu vybrat jen tři adresáty?</a><br/>
<a href="#q3">3. Proč musím vyplňovat svou e-mailovu adresu?</a><br/>
<a href="#q4">4. Jak mu/jí napíšu zprávu?</a><br/>
<a href="#q5">5. Proč vracíme zpátky e-maily s vulgárním obsahem?</a><br/>
<a href="#q6">6. Ochrana osobních dat</a><br/>
<a href="#q7">7. Proč nemohu napsat třeba ministrovi, hejtmanovi nebo krajskému zastupiteli?</a><br/>
<a href="#q8">8. Proč bráníme posílání předpřipravených e-mailů?</a><br/>
<a href="#q9">9. Co je cílem projektu a kdo je za tím?</a><br/>
<a href="#q10">10. Mají politici povinnost mi odpovědět?</a><br/>
<a href="#q11">11.  Co když mi neodpoví?</a><br/>
<a href="#q12">12.  Mohu si zkontrolovat celou svou zprávu ještě před odesláním?</a><br/>
<a href="#q13">13. Na jaké adresy jsou e-maily posílány?</a><br/>
<a href="#q14">14. Mohu se spolehnout, že zpráva byla odeslána?</a><br/>
<a href="#q15">15. Mohu stornovat svou zprávu?</a><br/>
<a href="#q16">16. Mám nápad na podobnou aplikaci jako je {$smarty.const.WTT_TITLE}, můžete mi pomoci s jeho realizací?  Mohu použít váš software?</a><br/>
<a href="#q17">17. Chci pomáhat {$smarty.const.WTT_TITLE} jako dobrovolník</a><br/>
<a href="#q18">18. Chci sdělit komentář, kritiku nebo pochvalu</a>
</p>

<h3 id="q1">1. Jak vyhledám komu chci napsat?</h3>
<p>
{$smarty.const.WTT_TITLE} nabízí dvě různé možnosti jak najít „svého“ politika:
<ul>
	<li>podle vaší adresy – stačí zadat do vyhledávacího políčka vaší adresu nebo její část a zobrazí se vám seznam poslanců a senátorů, seřazených pěkně podle vzdálenosti jejich oficiální kanceláře od zadaného místa</li>
	<li>podle politické strany, výborů nebo komisí, ve kterých působí – víte už předem, že chcete napsat poslancům nebo senátorům z konkrétní politické strany a nezáleží vám na tom, odkud jsou? Nebo vás zajímá konkrétní téma? Pak klikněte na nápis <em>Rozšířené hledání</em> pod vyhledávacím políčkem.
</ul>
</p>

<h3 id="q2">2. Proč si mohu vybrat jen tři adresáty?</h3>
<p>
Aplikace {$smarty.const.WTT_TITLE} je vybudována s úmyslem podpořit osobní komunikaci občanů s politiky, nikoli sloužit jako brána pro masové uniformní kampaně, kdy se hromadně obešle celý parlament univerzální zprávou.
</p><p>
Chceme podpořit komunikaci i v rámci kampaní neziskových organizací. Směle se inspirujte – třeba u NašiPolitici.cz, Oživení, Transparency International, Hnutí Duha a dalších – ale pište za sebe a piště osobně.
</p><p>
Jakkoli v naší zemi neplatí, že by určitý poslanec měl zodpovědnost pouze a výlučně za konkrétní region, i v České republice volíme regionálně. Nejvíce vám tak budou pravděpodobně naslouchat ti politici, kteří kandidovali ve vašem volebním obvodě, protože budou chtít být zvoleni znovu. Navíc, jako zástupci tohoto obvodu v parlamentu pro něj pravděpodobně budou moci nejvíce udělat. Kdo ví, možná zjistíte, že „váš“ poslanec má kancelář přímo „za rohem“ :-)
</p>

<h3 id="q3">3. Proč musím vyplňovat svou e-mailovu adresu?</h3>
<p>
Ze dvou důvodů:
<ul>
	<li>aby vám na váš e-mail mohla přijít odpověď od daného politika. Pokud zprávu označíte jako soukromou, odpověď přijde pouze Vám.</li>
	<li>před odesláním e-mailu politikovi Vás požádáme o kliknutí na aktivační link, který pošleme na Vaši e-mailovou adresu (viz níže). Jde o prvek, který snižuje zneužití systému. Chceme mít jistotu, že zprávy odesílají lidé z masa a kostí a nikoli spammovací roboti.</li>
</ul>	
</p>

<h3 id="q4">4. Jak mu/jí napíšu zprávu?</h3>
<p>
Jakmile budete mít vybraného 1–3 politiky nebo političky, kterým chcete napsat, klikněte na <em>Napište jim!</em>. Budete přesměrováni na další stránku s jednoduchým textovým oknem, kde můžete formulovat svou zprávu. Když budete s textem spokojeni, klikněte na <em>Odeslat</em>.
</p><p>
Zbývá jeden poslední krok. Na vaši e-mailovou adresu, kterou jste vyplnili v předchozích krocích bude odeslán automatický e-mail s potvrzujícím odkazem. Stačí na něj kliknout a vaše zpráva pro politika byla právě odeslána.
</p>

<h3 id="q5">5. Proč vracíme zpátky e-maily s vulgárním obsahem?</h3>
<p>
I když o sobě uvádíte některé údaje, pořád je ještě odeslání zprávy politikovi prostřednictvím {$smarty.const.WTT_TITLE} poměrně anonymní záležitostí, kterou je možné zneužít odesíláním mnohem vulgárnějších sdělení než dopisem nebo dokonce tváří v tvář.
</p><p>
Abychom zabránili tomuto zneužívání, zabudovali jsme systém, který automaticky kontroluje zprávy z tohoto hlediska. Pokud vaše zpráva systémem neprojde, bude Vám vrácena zpátky. Máte následně možnost ji opravit a znovu odeslat. 
</p><p>
Pokud se budete domnívat, že Vaše zpráva byla vrácena neprávem, můžete nás <a href="/contact">kontaktovat</a> abychom ji posoudili ručne.
</p>

<h3 id="q6">6. Ochrana osobních dat</h3>
<p>
Aby aplikace mohla fungovat, musí uložit vaše jméno a e-mailovou adresu.
</p><p>
Pokud si zvolíte, že vaše zpráva bude veřejná, zobrazí se v přehledu odeslaných zpráv a u ní bude i vaše jméno.
</p><p>
Na rozdíl od jména vaši e-mailovou adresu zásadně zveřejňovat nebudeme, ani ji nikdy nepředáme dalším stranám. Jediný, kdo ji uvidí, je adresát vašeho 
e-mailu, aby vám mohl odpovědět.
</p><p>
Použitím aplikace souhlasíte s uložením výšeuvedeným osobních dat.
</p>

<h3 id="q7">7. Proč nemohu napsat třeba ministrovi, hejtmanovi nebo krajskému zastupiteli?</h3>
<p>
I když v KohoVolit.eu toho děláme spoustu užitečného (mrkněte se třeba na naše <a href="http://cs.kohovolit.eu/cz/psp/vote">předvolební kalkulačky</a> nebo na <a href="http://cs.kohovolit.eu/cz/psp/analysis">analýzu aktivity poslanců</a>), nezvládáme všechno najednou.
</p><p>
Plánujeme aplikaci postupně rozšiřovat a prvními kroky budou právě vláda a krajská zastupitelstva. Chtěli byste nám s tím pomoci? <a href="/contact">Kontaktujte nás!</a> Nebo můžete na vývoj <a href="/support">přispět</a>. 
</p><p>
Můžeme do systému ale přidat i úplně malou obec, pokud o to někdo projeví zájem a dodá nám e-mailové kontakty na místní zastupitelstvo – pro tuto možnost nás také <a href="/contact">kontaktujte</a>.
</p>

<h3 id="q8">8. Proč bráníme posílání předpřipravených e-mailů?</h3>
<p>
Aplikace {$smarty.const.WTT_TITLE} je vybudována s úmyslem podpořit osobní komunikaci občanů s politiky, nikoli sloužit jako brána pro masové uniformní kampaně, kdy se hromadně obešle celý parlament univerzální zprávou.
</p><p>
Také od politiků samotných máme zprávy, že se spíše zamyslí nad 5 autentickými, reálně psanými zprávami, než nad 50 identickými.
</p><p>
Navíc, i když politik má k ruce asistenty, kteří mu pomáhají vyřizovat poštu, zpráv chodí velké množství. Pokud si má vybrat komu odpovědět a tím s ním navázat určitý dialog, odpoví spíše lidem, které skutečně zajímá konkrétní oblast a dali si práci s formulací dopisu, než těm, co pouze překopírovali text a klikli na <em>odeslat</em>.
</p>

<h3 id="q9">9. Co je cílem projektu a kdo je za tím?</h3>
<p>
Cílem této aplikace je vytvořit živou platformu pro elektronickou komunikaci mezi občany a politiky. 
</p><p>
O tom, jak projekt vzniknul a o KohoVolit.eu – zastřešující organizaci, se více dočtete na stránce <a href="/about">O projektu</a>.
</p>

<h3 id="q10">10. Mají politici povinnost mi odpovědět?</h3>
<p>
Ne, ze zákona (na rozdíl například od určených státních institucí) volení zastupitelé tuto povinnost nemají. Existují ale způsoby jak ocenit dobrou práci nebo naopak vyjádřit svou nespokojenost.
</p><p>
Přímo na {$smarty.const.WTT_TITLE} pro to budeme využívat následující kanály: Pokud označíte svou zprávu jako veřejnou, bude na {$smarty.const.WTT_TITLE} zobrazena a bude u ní indikováno, zda adresát odpověděl či nikoli. Pokud odpověď nedorazí, budeme po dvou týdnech politika urgovat opakovaně odeslanou zprávou.
</p><p>
Pokud zprávu označíte jako soukromou, pouze vy budete vědět jestli vám adresát odpověděl. Po dvou týdnech vám proto pošleme e-mail, kde se vás zeptáme, jestli vám byla doručena odpověď. Stačí jednoduše kliknout na jeden ze dvou odkazů v těle e-mailu.
</p><p>
Data z veřejného zobrazení e-mailů a získaná dotazovaním budeme využívat k sestavování tabulek poslanců, senátorů a stran podle toho, jak odpovídají na dotazy občanů a výsledky budeme medializovat.
</p>

<h3 id="q11">11.  Co když mi neodpoví?</h3>
<p>
Ze zákona tak politici učinit nemusí (viz otázka č. 10). Jsou ale i jiné kanály, které můžete zkusit využít pro vyřešení svého problému:
<ul>
	<li>zkuste daného poslance kontaktovat v jeho regionální kanceláři, na webu poslanecké sněmovny naleznete adresu a často i telefonní číslo. V regionech bývají poslanci vždy v pondělí</li>
	<li>zkuste kontaktovat jiného poslance ze svého regionu nebo svého senátora</li>
	<li>kontaktujte místní pobočku jeho politické strany a žádejte odpověď přes ně</li>
	<li>pokud jste zkusili předchozí kanály, napište místnímu deníku nebo regionálním mutacím deníků celostátních o vaší kauze</li>
</ul>
</p>

<h3 id="q12">12.  Mohu si zkontrolovat celou svou zprávu ještě před odesláním?</h3>
<p>
Ano, váš text bude zobrazen v e-mailu s aktivačním odkazem. Pokud si to rozmyslíte a nebudete chtít zprávu odeslat, na aktivační odkaz jednoduše nekliknete.
</p>

<h3 id="q13">13. Na jaké adresy jsou e-maily posílány?</h3>
<p>
Využíváme kontaktní údaje z oficiálních webů <a href="http://www.psp.cz">Poslanecké sněmovny</a> a <a href="http://www.senat.cz">Senátu</a>. Případné změny tam učiněné se denně přenáší i k nám. Tímto způsobem můžeme garantovat, že e-mailové adresy jsou aktuální.
</p>

<h3 id="q14">14. Mohu se spolehnout, že zpráva byla odeslána?</h3>
<p>
Na 99%. Propojenost naší e-mailové databáze s databází Poslanecké sněmovny zaručuje, že e-maily poslanců a senátorů jsou aktuální. Náš systém nám navíc ohlásí naprostou většinu možných technických komplikací. 1% necháváme pro případ vpádu UFO nebo jiných nepředvídaných problémů.
</p>

<h3 id="q15">15. Mohu stornovat svou zprávu?</h3>
<p>
Dokud je ve fázi textového okna, jednoduše neklikejte na <em>Odeslat</em> a zprávu upravte, nebo začněte úplně odznova.
</p><p>
Další možnost odstoupení máte, když vám přijde automatický e-mail s aktivačním odkazem – jednoduše ho nepotvrďte.
</p><p>
Za tímto bodem jsou však již vaše šance na odchycení zprávy mizivé. Přesto nás můžete <a href="/contact">kontaktovat</a>.
</p>

<h3 id="q16">16. Mám nápad na podobnou aplikaci jako je {$smarty.const.WTT_TITLE}, můžete mi pomoci s jeho realizací?  Mohu použít váš software?</h3>
<p>
Veškeré zdrojové kódy k {$smarty.const.WTT_TITLE}, stejně tak jako databáze dat jsou volně přistupné široké veřejnosti a kdokoli může vytvářet aplikace, které využívají naše data nebo kódy.
</p><p>
Každopádně, už ten fakt, že máte tenhle nápad, vás činí zajímavým – chcete-li, <a href="/contact">kontaktujte nás</a> a možná se domluvíme na hlubší spolupráci!
</p>

<h3 id="q17">17. Chci pomáhat {$smarty.const.WTT_TITLE} jako dobrovolník</h3>
<p>
Super, ochotných lidí není nikdy dost! Základní možnosti spolupráce:
<ul>
	<li>zařazování dalších institucí a míst (hlavně zjišťování platných e-mailových kontaktů a jejich vkládání do databáze)</li>
	<li>programování a vymýšlení dalších „vychytávek“ pro aplikaci</li>
	<li>navazování spolupráce s místními neziskovými organizacemi pro docílení tlaku na konkrétní politiky</li>
</ul>
Zastřešující organizace <a href="http://KohoVolit.eu">KohoVolit.eu</a> má na triku mnoho dalších zajímavých projektů, podívejte se na sekci <a href="/about">O&nbsp;projektu</a>.
</p>

<h3 id="q18">18. Chci sdělit komentář, kritiku nebo pochvalu</h3>
<p>
Těšíme se na vaše názory – <a href="/contact">kontakt</a>.
</p>
{/block}
