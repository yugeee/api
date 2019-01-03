<html>
    <head>
        <meta charset="utf8">
        <?php echo \Asset::css('semantic.min.css'); ?>
        <?php echo \Asset::js('jquery-3.3.1.min.js'); ?>
        <?php echo \Asset::js('semantic.min.js'); ?>
    <title><?php echo $title ?></title>
</head>

<body class="ui inverted segment">
    <h2 class="ui header"><?php echo $title; ?></h2>
    <div class="ui hidden divider"></div>
    <div id="wrapper">
        <?php echo $content; ?>
    </div>
    <div class="ui hidden divider"></div>
  <div class="ui two column centered grid">
    Ⓒ株式会社SSC
  </div>
</body>
</html>