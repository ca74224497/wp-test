<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="apple-touch-icon" sizes="180x180" href="https://shakuro.com/static/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="https://shakuro.com/static/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="https://shakuro.com/static/favicon/favicon-16x16.png" />
    <link rel="manifest" href="https://shakuro.com/static/favicon/manifest.json" />
    <link rel="mask-icon" href="https://shakuro.com/static/favicon/safari-pinned-tab.svg" color="#73AA2F" />
    <title><?= get_bloginfo(); ?> :: <?= esc_html(get_the_title()); ?></title>
    <?php wp_head(); ?>
  </head>
  <body>
    <header class="header">
      <a href="/" class="header__link">
        <h1 class="header__logo">
            <?= get_bloginfo(); ?>
        </h1>
      </a>
    </header>
    <main>