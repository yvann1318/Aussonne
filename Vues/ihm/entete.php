
<html>

<head>
	<title>
		Mon Agence
	</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="avion.png" type="image/x-icon" />
	<LINK rel=STYLESHEET href="Vues/design/bootstrap.min.css" type="text/css">
	<LINK rel=STYLESHEET href="Vues/design/mairie.css" type="text/css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<script src="Vues/design/jquery-3.4.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="Vues/design/bootstrap.min.js"></script>
	<SCRIPT type="text/javascript">
		//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		//Fonction permettant de d'instancier l'objet XMLHttpRequest
		//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------	
		function getObjetXMLHttpRequest() {
			var requeteHttp;
			if (window.XMLHttpRequest) //Mozilla
			{
				requeteHttp = new XMLHttpRequest();
				if (requeteHttp.overrideMimeType) //Firefox
				{
					requeteHttp.overrideMimeType('text/xml');
				}
			} else {
				if (window.ActiveXObject) //IE < 7
				{
					try {
						requeteHttp = new ActiveXObject("Msxml2.XMLHTTP");
					} catch (e) {
						try {
							requeteHttp = new ActiveXObject("Microsoft.XMLHTTP");
						} catch (e) {
							requeteHttp = null;
							alert("Navigateur incompatible");
						}
					}
				}
			}
			return requeteHttp;
		}

		//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		//Fonction permettant de faire un appel Ajax
		//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		function appelAjax() {
			var requeteHttp = getObjetXMLHttpRequest();
			if (requeteHttp != null) {
				var laListe;
				laListe = document.getElementById('theme');
				var uneRef;
				uneRef = laListe.options[laListe.selectedIndex].value;
				requeteHttp.open("POST", "constructionRequeteAjax.php", true);
				requeteHttp.setRequestHeader("Content-Type",
					"application/x-www-form-urlencoded");
				requeteHttp.send('ref=' + uneRef);
				requeteHttp.onreadystatechange =
					function() {
						recevoirReponseRequeteAjax(requeteHttp)
					};

			}
		}

		//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
		//Fonction permettant de recevoir et de traiter la reponse de la requete Ajax
		//-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------				
		function recevoirReponseRequeteAjax(requeteHttp) {
			if (requeteHttp.readyState == 4) {
				if (requeteHttp.status == 200) {
					var lesMat = requeteHttp.responseText;
					document.getElementById('zoneResultat').innerHTML = lesMat;
				} else
					alert("Erreur requete");
			}
		}
	</SCRIPT>

	<head>

	<body>

		<div class="container-fluid bleu">
			<h1 style="margin-top: -24;"> Les sportifs d'Aussonne </h1>
			Une ville dynamique
		</div>

		<div class="container">
			<div class="row">