<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// call compile scripts, do da hard work
	include ('../src/settings.php');
	include ('src/compile.php');

  ini_set('max_execution_time', 0);

	c_compile();

  ini_set('max_execution_time', 30);
}

?>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		
		<title>Betta</title>
        <meta name="description" content="Betta, your friendly neighborhood compiler."/>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel='shortcut icon' type='image/x-icon' href='favicon.ico' />
	</head>

	<style>
		body {
			margin: 0;
		}

		div, input, button, article, section, nav {
			box-sizing: border-box;
		}

		i {
			vertical-align: top;
		}

		i, img {
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		nav ul {
			padding: 0;
			margin: 0;
		}

		nav ul li {
			list-style: none;
		}

		button {
			vertical-align: top;
			text-align: center;
			border: none;
			outline: none;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			padding: 0.25rem 1rem;
			border-radius: 1rem;
			background: #fff;
			transition: 0.1s;
			box-shadow: 0 0 2px 0 #212121;
		}

		button:hover:enabled {
			cursor: pointer;
			background: #eee;
		}

		button:active:enabled {
			background: #e5e5e5;
		}

		/*---------------------------------------
			Typography
		---------------------------------------*/
		a
		{
			text-decoration: none;
		}

		strong {
			font-weight: 600;
		}

    p {
      max-width: 30rem;
      margin-left: auto;

      margin-right: auto;
    }

		/*---------------------------------------
			Custom Classes
		---------------------------------------*/
		.center {
			text-align: center;
		}
	</style>

	<body>
		<div class="page center">
			<article class="article center">
				<div>
					<br>
					<h1>Betta</h1>
				</div>
				<form method="post">
          <input type="hidden" name="compile-mode" value="complete">
					<button class="button-center">Compile</button>
				</form>
			</article>
      <article class="article center">
        <p>
          If you want to only reload the page to compile use the <a href="./compile.php">compile page</a>.
        </p>
			</article>
		</div>
	</body>
</html>