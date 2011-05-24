<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<title>{block name=title}{/block}</title>
	<link rel="stylesheet" type="text/css" href="css/project.css" />
	{block name=head}{/block}
</head>
<body>
  <div id="page-wrapper">
	<div id="logos-wrapper">
	  <div id="logo-right" class="logo">
  	    <a href="http://kohovolit.eu"><img src="images/logo_kohovolit.eu.png" alt="kohovolit.eu" /></a>
  	  </div>
	  <div id="logo-left" class="logo">
	    <a href="http://napistejim.cz"><img src="images/logo_napistejim.cz.jpg" alt="napistejim.cz" /></a>
	  </div>
	</div>
	{block name=body}{/block}
	<div id="page-footer">
		<div id="links">
		  <a href="/about">{t}About project{/t}</a>
		  <a href="/faq">{t}Faq{/t}</a>
		  <a href="/video">{t}Video{/t}</a>
		  <a href="http://cs.kohovolit.eu">KohoVolit.eu</a>
		</div>
		<div id="licence">
		  <a href="http://www.gnu.org/licenses/gpl.html">GNU/GPL</a> - <a href="/privacy">{t}Privacy{/t}</a>
		</div>
	</div>
  </div>
</body>
</html>
