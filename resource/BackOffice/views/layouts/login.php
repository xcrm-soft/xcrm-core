<?php
/**
 * @var $this \XCrm\Application\Web\View
 * @var $content string
 */
$this->beginPage() ?><!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= $this->html::encode($this->title) ?></title>
    <style>
        .card-outer {
            margin: 2% auto;
            max-width: 640px;
        }
    </style>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div id="wrapper" class="toggled">
    <div id="sidebar-wrapper">
        <a id="menu-toggle">
            <span class="title">Dashboard</span>
            <span class="icon"><i class="fas fa-bars"></i></span>
        </a>
        <div id="sidebar-keeper">

        </div>
    </div>
    <div id="page-content-wrapper">
        <div id="page-content-keeper">
            <section class="main">
                <div class="container-fluid">

                    <div class="card main-content-card card-outer">
                        <div class="card-body">
                        <?=$content?>
                        </div>
                    </div>

                </div>
            </section>
            <footer>
                <div class="container-fluid">
                    Footer
                </div>
            </footer>
        </div>

    </div>
</div>
<?= $this->render('share/header', []) ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();