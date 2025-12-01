<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?= $title ?> </title>
    <link href="<?= $style ?>" rel="stylesheet" />
    <link href="<?= empty($optional_style1) ? "" : $optional_style1 ?>" rel="stylesheet" />
    <script src="<?= $script ?>" defer></script>

</head>

<body>
    <?= $content ?>
</body>

</html>