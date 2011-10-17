<html>
<head>
	<title>{block name=title}{/block}</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta name="Description" content="{t}MSGID_HTML_HEAD_DESCRIPTION{/t}" />
	<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/images/favicon.ico" type="image/x-icon">
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
		  <a href="/list">{t}Public messages{/t}</a>
		  <a href="/about">{t}About{/t}</a>
		  <a href="/faq">{t}FAQ{/t}</a>
		  <a href="/video">{t}Video{/t}</a>
		  <a href="/support">{t}Support us{/t}</a>
		  <a href="{t}http://en.kohovolit.eu{/t}">KohoVolit.eu</a>
		</div>
		<div id="licence">
		  <a href="http://www.gnu.org/licenses/gpl.html">{t}Licence{/t}</a> – <a href="/privacy">{t}Privacy{/t}</a> – <a href="/contact">{t}Contact{/t}</a>
		</div>
	</div>
  </div>
</body>
</html>
