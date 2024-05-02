<?php
    /** Layout template
     *
     * @var $this \uhi67\umvc\App
     * @var $content string -- main content to display
     */
    assert($this->requireVars($content), '');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UMVC Application Template</title>
    <link href="<?= $this->linkAssetFile('npm-asset/bootstrap/dist', 'css/bootstrap.bundle.min.css') ?>" rel="stylesheet">
</head>

<body>
    <?= $content ?>
    <script src="<?= $this->linkAssetFile('npm-asset/bootstrap/dist', 'js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
