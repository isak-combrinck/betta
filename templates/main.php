<?php
ob_start();

if ($settings['php_scripts'] != null) {
	echo file_get_contents($settings['php_scripts']);
}
?>

<!DOCTYPE html>
<html lang="<?php echo $settings['lang']?>">
	<head>
		<meta charset="UTF-8">
		
		<title><?php echo $settings['title_before'] . $settings['title'] . $settings['title_after']?></title>
    <meta name="description" content="<?php echo $settings['meta_description']?>"/>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital@0;1&display=swap" rel="stylesheet">

    <?php echo $settings['link_stylesheets']?>

    <meta name="color-scheme" content="dark light">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/favicons/site.webmanifest">
    <link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#212121">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#ffffff">

        <style>
            body, textarea, option, input, select, button {
                font-family: 'Lato', sans-serif;
                font-display: optional;
            }

            header.hero {
                font-family: 'Cormorant Garamond';
            }
        </style>
	</head>

	<body>
		<?php
    if ($settings['header_show']) {
			include ('../src/page_elements/'.$settings['header_file']);
		}
        
    if ($settings['back_button_show']) {
			include ('../src/page_elements/back-button.html');
		} elseif ($settings['menu_show']) {
			include ('../src/page_elements/menu.html');
		}
    ?>

    <button id="betta_theme-button" class="icon-button simple">
      <span class="icon"><img src="/icons/dark_mode.svg" alt="Switch theme"/></span>
    </button>

		<main>
        <?php
        if ($settings['parse'] != NULL) {
            include '../src/pages/' . $settings['parse'];
        } else {
            echo $settings['content'];
        }
        ?>
		</main>

    <?php
    if ($settings['footer_show']) {
			include ('../src/page_elements/footer.html');
		}
    ?>

		<?php echo $settings['script_imports']?>

    
    <div id="loader">
      <div id="spinner"></div>
    </div>
	</body>
</html>

<?php ob_end_flush(); ?>