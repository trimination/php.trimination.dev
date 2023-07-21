<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?></title>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/css/normalize.css?ver=<?= time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/css/style.css?ver=<?= time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/css/toggle-switch.css?ver=<?= time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/css/flip-card.css?ver=<?= time(); ?>"/>
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/css/cookie-confirm.css?ver=<?= time(); ?>"/>
    <script src="<?= BASE_URL ?>/js/cookies.js?ver=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/toggle-dark-mode.js?ver=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/responsive-menu.js?ver=<?= time(); ?>"></script>
    <script src="<?= BASE_URL ?>/js/cookie-confirm.js?ver=<?= time(); ?>"></script>
    <script>
        let postLoadCSSUrl = '<?= BASE_URL ?>/css/post-load.css';
    </script>
</head>
<body class="toggleable dark">
<div class="navigation-container toggleable dark">
    <div class="responsive-menu-button toggleable">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="nav-menu" id="nav-menu">
        <?php
        $db = new \trimination\Database();
        $menu = $db->query("SELECT * FROM nav_menu")->fetchAll(\trimination\QueryResultType::asObjects);

        foreach($menu as $item) {
            echo '<a href="' . $item->url . '" class="dark toggleable">' . $item->name . '</a>';
        }
        ?>

        <div class="theme-switch">
            Dark Mode:
            <label class="switch">
                <input type="checkbox" onchange="toggleDarkMode()">
                <span class="slider round toggleable"></span>
            </label>
        </div>
    </div>
    <div class="dark-mode-toggle-container toggleable" title="toggle dark mode" onclick="toggleDarkMode()">
        <img src="<?= BASE_URL ?>/assets/on.svg" id="dark-mode-on"/>
        <img src="<?= BASE_URL ?>/assets/off.svg" id="dark-mode-off"/>

    </div>
</div>
<div class="main-container"> <!-- closed in footer.php -->
