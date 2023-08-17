<?php
	include ('../src/settings.php');  # Include site specific settings
	include ('src/compile.php');      # Include script to do compiling

  ini_set('max_execution_time', 0); # Disable max execution time
	c_compile();
  ini_set('max_execution_time', 30); # Reset max execution time to default
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
      font-family: monospace, sans-serif;
		}

		div, article {
			box-sizing: border-box;
		}

    img {
      width: 10rem;
      height: 10rem;
      border-radius: 50%;
      border: 3px solid #000000;
      animation: 1.2s ease-out 0s 1 load;
      -webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
    }

		/*---------------------------------------
			Typography
		---------------------------------------*/
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

    /*---------------------------------------
			Animation
		---------------------------------------*/
    @keyframes load {
      0% {
      transform: rotateZ(0deg);
      opacity: 0;
      }
      40% {
        transform: rotateZ(20deg);
        opacity: 0.2;
      }
      80% {
        transform: rotateZ(-15deg);
        opacity: 0.6;
      }
      100% {
        transform: rotateZ(0deg);
      }
    }
	</style>

	<body>
		<div class="center">
			<article class="center">
				<div>
          <br>
          <img src="src/betta.png" alt="">
					<br>
					<h1>Betta</h1>
          <p>
          Simply reload the page to compile.
          </p>
				</div>
			</article>
		</div>
	</body>
</html>