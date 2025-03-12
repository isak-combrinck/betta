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

    <?php echo $settings['link_stylesheets']?>

    <meta name="color-scheme" content="dark light">

    <link rel="icon" type="image/png" href="/favicons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicons/favicon.svg" />
    <link rel="shortcut icon" href="/favicons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png" />
    <link rel="manifest" href="/favicons/site.webmanifest" />
	</head>

	<body class="<?php echo isset($settings['body_classes']) ? $settings['body_classes']: '' ?>">
    <script>
      if (localStorage.getItem('dark') == 'true') {
        document.body.classList.add('dark');
      }
    </script>

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
			include ('../src/page_elements/'.$settings['footer_file']);
		}
    ?>

		<?php echo $settings['script_imports']?>

    
    <div id="loader">
      <div id="spinner"></div>
    </div>
	</body>
</html>

<?php ob_end_flush(); ?>