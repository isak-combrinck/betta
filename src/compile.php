<?php

/*
Sow your seed in the morning, and at evening let not your hands be idle,
for you do not know which will succeed, whether this or that,
or whether both will do equally well.
Ecclesiastes 11:6

Rather do one thing with excellence than ten well.
*/

# Create build directory if it doesn't exist
if (!is_dir('../build/')) {
  mkdir('../build/');
}

// Copy .htaccess if exists
if (file_exists('../src/.htaccess')) {
	copy('../src/.htaccess', '../build/.htaccess');
}

// Copy robots.txt if exists
if (file_exists('../src/robots.txt')) {
	copy('../src/robots.txt', '../build/robots.txt');
}

// Copy sitemap.xml if exists
if (file_exists('../src/sitemap.xml')) {
	copy('../src/sitemap.xml', '../build/sitemap.xml');
}

# Copy files from a directory to a production directory
# and add them to an array. Overwrites files with the
# same name. Used for js and css files.
#
# Returns an array that needs to be merged with any
# existing arrays to track all scripts/stylesheets.

function c_copy_files($type, $dir) {

	if (!is_dir('../build/'.$type.'/')) {
		mkdir('../build/'.$type.'/');
	}

	$array = [];
	$files = glob($dir . '*.{'.$type.'}', GLOB_BRACE);
	foreach ($files as $file) {
		if (is_dir($file)) {
			$array = c_copy_files($type, $dir . basename($file) . '/');
		} else {
			copy($file, '../build/'.$type.'/' . basename($file));

			// if file has .map, copy that as well
			if (file_exists($file . '.map')) {
				copy(($file.'.map'), '../build/'.$type.'/' . basename($file.'.map'));
			}

			array_push($array, '/'.$type.'/' . basename($file));
		}
	}

	return $array;
}

# Copy a directory and all its files from src to build
# $dir the directory to copy
# $from the location to copy the directory from

function c_copy_dir($dir, $from = "../src") {

	if (!is_dir('../build/'.$dir.'/')) {
		mkdir('../build/'.$dir.'/');
	}

	$files = glob($from.'/'.$dir.'/' . '*.*', GLOB_BRACE);
	foreach ($files as $file) {
		if (is_dir($file)) {
      exit($dir . '/' . basename($file));
			c_copy_dir($dir . '/' . basename($file));
		} else {
			copy($file, '../build/'.$dir.'/' . basename($file));
		}
	}
}

$link_stylesheets;
function c_compile_stylesheets() {
	// Compiles stylesheets for every page

	// Generate html for provided stylesheets, excluding array of exceptions
	function c_set_stylesheets($exceptions) {
		// Get external stylesheets from settings
		$c_stylesheets = $GLOBALS['s_external_stylesheets'];

		$c_stylesheets = array_merge($c_stylesheets, c_copy_files('css', 'libs/css/'));
		$c_stylesheets = array_merge($c_stylesheets, c_copy_files('css', '../src/css/'));

		$output = '';
		$i = 0;
		
		foreach ($c_stylesheets as $stylesheet) {
			// if listed in exceptions: don't include
			if (!empty($exceptions) && in_array($stylesheet, $exceptions)) {
				$i++;
			} else { // if not listed: include
				if ($i == 0) {
					$output .= '<link rel="stylesheet" href="'.$stylesheet.'">';
				} else {
					$output .= "\n\t\t".'<link rel="stylesheet" href="'.$stylesheet.'">';
				}
				$i++;
			}
		}
		
		return $output;
	}

	$GLOBALS['link_stylesheets'] = c_set_stylesheets($GLOBALS['s_stylesheet_exceptions']);
}

$script_imports;
function c_compile_scripts() {
	// Compiles js scripts for every page

	// Generate code custom scripts
	function c_set_scripts($exceptions) {

		// Get external scripts from settings
		$c_scripts = $GLOBALS['s_external_scripts'];

		$c_scripts = array_merge($c_scripts, c_copy_files('js', 'libs/js/'));
		$c_scripts = array_merge($c_scripts, c_copy_files('js', '../src/js/'));

		$output = '';
		$i = 0;
		
		foreach ($c_scripts as $script) {
			// if listed in exceptions: don't include
			if (!empty($exceptions) && in_array($script, $exceptions)) {
				$i++;
			} else { // if not listed: include
				if ($i == 0) {
					$output .= '<script src="'.$script.'"></script>';
				} else {
					$output .= "\n\t\t".'<script src="'.$script.'"></script>';
				}
				$i++;
			}
		}
		
		return $output;
	}

	$GLOBALS['script_imports'] = c_set_scripts($GLOBALS['s_script_exceptions']);
}

function c_compile_page($html, $php) {

	$settings = default_settings();

	// Check for settings file with same name and location
	$pathinfo = pathinfo(dirname($html) . '/' . basename($html));
	$file_settings =  $pathinfo['dirname'] . "/" . $pathinfo['filename'] . '.settings.php';

	// Execute settings file if it exists
	if (file_exists($file_settings)) {
		include ($file_settings);
		$settings = set_default_settings($settings, $keys, $values);
	}

	// Check if php file got passed as argument and set output extension accordingly
	// Output contains path
	if ($php != NULL) {
		$settings = set_default_settings($settings, ['php_scripts', 'content'], [$php, file_get_contents($html)]);
		$output = '../build' . substr($php, 12); # offset is offset to end of pages of path, e.g. for ../src/pages/standort/index.html it is 13
	} else {
		$settings = set_default_settings($settings, ['content'], [file_get_contents($html)]);
		$output = '../build/' . substr($html, 13); # BUG, fix offset being hardcoded
	}
    
	$output = str_replace("\\", "/", $output);
	
	// Extract folder from full path
	$path = substr($output, 0, (strlen($output) - strlen(strrchr($output, "/"))));

	// Exclude paths that are not a folder
	// input e.g. ../create/index.html
	// output ../create
	if (strchr($path, "/")) { # Check if path contains a /
		if (!is_dir($path)) {
			//exit($path); # is this right?
			mkdir($path);
		}
	}

	ob_start();

	include ($GLOBALS['template']);

	$file_output = fopen($output, 'w');
	fwrite($file_output, ob_get_contents());
	fclose($file_output);

	ob_end_clean();
}

function c_compile() {
	c_compile_stylesheets();
	c_compile_scripts();

  $settings = default_settings();
  
  foreach($settings['copy'] as $dir) {
    c_copy_dir($dir);
  }

  c_copy_dir("icons", "libs/icons/betta.icons"); # copy default icons over
	
	// Run appropriate compile scripts for every page found in the ../src/pages directory
	$iterator = new RecursiveDirectoryIterator("../src/pages/");

	// Call compile script for every page, passing php file if found
	foreach(new RecursiveIteratorIterator($iterator) as $file) {
		$pathinfo = pathinfo(dirname($file) . '/' . basename($file));

		if ($pathinfo['dirname'] != '../src/pages') { # Make dir for pages
			if (!is_dir('../' . str_replace('../src/pages/', 'build/', $pathinfo['dirname']))) {
				mkdir('../' . str_replace('../src/pages/', 'build/', $pathinfo['dirname'])); # Doesn't work on Windows
			}
		}
	
		if ($file->getExtension() == 'html') {

			// Check for php file with same name and location
			$file_php =  $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '.php';

			if (file_exists($file_php)) {
				c_compile_page($file, $file_php);
			} else {
				c_compile_page($file, NULL);
			}
		} else if ($file->getExtension() == 'pdf' || $file->getExtension() == 'docx') {
      # Copy pdf files and word documents, if they exist
			if (!is_dir('../' . str_replace('../src/pages/', 'build/', $pathinfo['dirname']))) {
				mkdir('../' . str_replace('../src/pages/', 'build/', $pathinfo['dirname']));
			}

			copy($file, '../' . str_replace('../src/pages/', 'build/', $file));
		}
	}
}

# Compile as Gallery (requires the betta.css and betta.js libraries)
# This option compiles the HTML needed to display the images in a folder as a gallery
# $path is the path to the folder containing the images in .jpg format
# We expect the images to hosted on a different website (static hosting)
# and thus the path should be something like ../../static.test.com/images/gallery-1/
# $path_prefix defines a prefix to add to the path when generating the HTML
# This prefix defaults to https://
# HTML is inserted where the function is called
function compile_as_gallery($path, $path_prefix = 'https://') {
    $images;

    # Stop execution if path passed does not point to a directory
    if (!is_dir($path)) {
        exit('Invalid path "' . $path . '" passed to compile as gallery.');
    }

    $iterator = new DirectoryIterator($path);
        
    foreach ($iterator as $fileinfo) {
      # We only support images with the .jpg extension
      if (!($fileinfo->isFile() && $fileinfo->getExtension() === 'jpg')) {
        continue; # File not supported
      }

      # Remove relatives from path
      $path = str_replace('../', '', $path);

      $images[] = $path_prefix . $path . '/' . $fileinfo->getBasename('.jpg');
    }

    natcasesort($images);

    include ('templates/gallery.php');
}