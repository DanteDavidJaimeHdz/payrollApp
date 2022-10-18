<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payroll App</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
  </head>

  <body style="background-image: url('../img/welcome.jpg'); background-size: 100% 100%;">

    <div id="app" style="background-image: url('../img/welcome.jpg'); max-width:100%; max-height:100%;">
      <component-header-pos></component-header-pos>
      <component-main-pos></component-main-pos>
      <div ></div>
    </div>

    <!-- importar component vue -->
    <script src="{{ asset('js/app.js') }}" ></script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
 
  </body>
</html>