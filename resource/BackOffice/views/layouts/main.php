<?php
/**
 * @var $this XCrm\BackOffice\Component\View
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
    <?php $this->head() ?>
    <style>
        .ace_editor, .ace_editor * {
            font-family: monospace!important;
        }
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<div id="wrapper" class="toggled">
    <div id="sidebar-wrapper">
        <a href="#menu-toggle" id="menu-toggle">
            <span class="title">Dashboard</span>
            <span class="icon"><i class="fas fa-bars"></i></span>
        </a>
        <div id="sidebar-keeper">
            <?=$this->render('share/aside', [])?>
        </div>
    </div>
    <div id="page-content-wrapper">
        <div id="page-content-keeper">
            <section class="main">
                <div class="page-header">
                    <div class="container-fluid heading-container">
                        <div class="heading-icon">
                            <?=$this->html::img($this->icon('modules', $this->headingIcon, 'color'))?>
                        </div>
                        <div class="heading-content">
                            <h1><?=$this->heading?></h1>
                            <div class="crumbs">
                                <?= $this->widget('breadcrumbs', ['links' => $this->params['breadcrumbs'] ?? []]) ?>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="container-fluid">
                    <?=$content?>
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
<script>
    <?php ob_start() ?>

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        if ($("#wrapper").hasClass("toggled")) {
            $("#wrapper").removeClass("toggled");

        } else {
            $("#wrapper").addClass("toggled");
            $(".module-menu").removeClass("in");
            $(".module-menu").prop("aria-expanded", false);
        }


    });

    $(document).on("click", "#wrapper.toggled .menu-module", function(e){
        e.preventDefault();
        $("#wrapper").removeClass("toggled");
        return false;
    });

    <?php $this->registerJs(ob_get_clean()) ?>
</script>
<?= $this->render('share/header', []) ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();