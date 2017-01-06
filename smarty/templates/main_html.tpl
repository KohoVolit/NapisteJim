<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>{block name=title}{/block}</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<meta name="Description" content="{t}MSGID_HTML_HEAD_DESCRIPTION{/t}" />
	<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="/images/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/project.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	{block name=head}{/block}
	<script type="text/javascript">var google_analytics_key = "{$smarty.const.GOOGLE_ANALYTICS_KEY}"</script>
	<script type="text/javascript" src="js/google_analytics.js"></script>
</head>
<body>
	<div id="wrapper">
		{block name=top}{/block}
		{block name=content}{/block}
		{block name=bottom}{/block}
	</div>
</body>
</html>
