<html>
	<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<link rel="stylesheet" href="FlipClock/compiled/flipclock.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"> </script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script src="FlipClock/compiled/flipclock.js"></script>	

	</head>
  <style>
    body {
      background-image:url(css/halftone.png);
      margin-left:60px;
    }
  </style>
	<body>
  <?php
error_reporting(E_ERROR | E_PARSE);
require_once "nusoap/nusoap.php";
//$client = new nusoap_client("http://purple-comet-84-131808.euw1-2.nitrousbox.com/datelist.php");
$client = new nusoap_client("datelist.wsdl", true);
 
$error = $client->getError();
if ($error) {
    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
}

// REQUETE SUR SERVEUR SOAP. objet current date en paramètre
$result = $client->call("getProd", array("date" => date('Y-m-d H:i:s')));
//echo $result;
$resultArray = explode( ',', $result );


if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
}
else {
    $error = $client->getError();
    if ($error) {
        echo "<h2>Error</h2><pre>" . $error . "</pre>";
    }
}
?>  
    <h1>Prochain cours MAS-RAD</h1>
    <div id="container" style=" height:200px">
		<div class="clock" style="margin:2em;"></div>
      <h1>Lieu du cours</h1>
      <h4><?php echo $resultArray[1]; ?></h4>
    </div>
    
		
		<script type="text/javascript">
			var compteur;

			$(document).ready(function() {
        var resultDate = '<?php echo $resultArray[0] ;?>';
				var pastDate = new Date()
				var currentDate  = new Date(resultDate);
				var diff = currentDate.getTime() / 1000 - pastDate.getTime() / 1000;
				compteur = $('.clock').FlipClock(diff, {
					clockFace: 'DailyCounter'
				});
			});
		</script>
		
<?php
echo "<h2>Requête Soap</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Réponse Soap</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
?>
    
	</body>
</html>

