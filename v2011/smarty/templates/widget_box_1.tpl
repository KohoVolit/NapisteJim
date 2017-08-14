<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
	<title>{$data.projectname}</title>
	<link rel="Stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/ui-lightness/jquery-ui.css" type="text/css" />
	<link rel="stylesheet" type="text/css" href="css/widget-box-1.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.clearfield.packed.js"></script>
	<script type="text/javascript" src="js/search.js"></script>
	<script type="text/javascript" src="js/google_analytics.js"></script>
	<link rel="Stylesheet" href="css/widget-box-1.css" type="text/css" />
	<style>
	  {block name=style}{/block}
	</style>
</head>
<body>
  <div id="napistejim-block">
	<div id="logo-center" class="logo">
			<a href="http://{$data.project}"><img src="http://{$data.project}/images/widget/logo_{$data.project}_{$data.img_width}x{$data.img_heigth}.png" title ="{$data.projectname}" alt="{$data.projectname}" width="{$data.img_width}" height="{$data.img_height}"/></a>
	  </div>
	<div id="search-content-wrapper">
		<div id="search-search-wrapper">
		  <form name="search-search" action="http://napistejim.cz" method="get">
			<fieldset class="search">
			  <input id="search-address" name="address" class="clearField" type="text" value="{$data.text1}" />
			</fieldset>
			<div id="search-submit">
			  <input id="search-submit-geocode" type="submit" value="{$data.text2}"/>
			</div>
		  </form>	  
		</div>	
	</div>
  </div>
</body>
</html>
