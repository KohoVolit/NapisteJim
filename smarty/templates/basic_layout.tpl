<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<title>{block name=title}{/block}</title>
	<link rel="Stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/project.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	{block name=head}{/block}
	<script type="text/javascript" src="js/google_analytics.js"></script>
</head>
<body>
  <div id="wrapper">
	{block name=logo}{/block}
	{block name=basic_body}{/block}
	<div id="page-footer">
		<div id="links">
		  <a href="/list">{t}Veřejné zprávy{/t}</a>
		  <a href="/about">{t}O projektu{/t}</a>
		  <a href="/faq">{t}Otázky a odpovědi{/t}</a>
		  <a href="/video">{t}Video{/t}</a>
		  <a href="/support">{t}Podpořte nás{/t}</a>
		  <a href="http://cs.kohovolit.eu">KohoVolit.eu</a>
		</div>
		<div id="licence">
		  <a href="http://www.gnu.org/licenses/gpl.html">GNU/GPL</a> - <a href="/privacy">{t}Osobní údaje{/t}</a> - <a href="/contact">Kontakt</a>
		</div>
	</div>
  </div>
</body>
</html>
