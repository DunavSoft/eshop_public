<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">

	<title><?= lang('AdminPanel.whoops') ?></title>

	<style type="text/css">
		<?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
	</style>
</head>
<body>

	<div class="container text-center">

		<h1 class="headline"><?= lang('AdminPanel.whoops') ?></h1>

		<p class="lead"><?= lang('AdminPanel.hitSnag') ?></p>

	</div>

</body>

</html>
