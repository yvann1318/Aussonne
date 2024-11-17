<?php

class accesBD
{
	private $hote;
	private $login;
	private $passwd;
	private $base;
	private $conn;
	private $boolConnexion;

	// Nous construisons notre connexion
	public function __construct()
	{
		$this->hote = "localhost";
		$this->login = "root";
		$this->passwd = "";
		$this->base = "ym_aussonne";
		$this->connexion();
	}
	private function connexion()
	{
		try
		{
			$this->conn = new PDO("mysql:host=" . $this->hote . ";dbname=" . $this->base . ";charset=utf8", $this->login, $this->passwd);
			$this->boolConnexion = true;
		}
		catch (PDOException $e)
		{
			die("Connection à la base de données échouée" . $e->getMessage());
		}
	}
	// ON vérifie l'existance d'un utilisateur grace à son login et son password
	public function verifExistance($role, $login, $pwd)
	{
		$bool = false;
		try
		{
			// on utilise la fonction htmlspecialchars pour echapper les caractères spéciaux
			$login = htmlspecialchars($login);

			//on va mettre le mot de passe saisie en clair par l'utilisateur en crypé MD5 pour pouvoir le comparer à celui dans la base de données.
			$pwd = MD5($pwd);
			switch ($role)
			{	// On utilise la methode prepare pour se préminir des injections.    

				case "1":
					$requete = $this->conn->prepare("SELECT idAdmin FROM administrateur where loginAdmin = ? and pwdAdmin = ?;");

					break;
				case "2":
					$requete = $this->conn->prepare("SELECT idAdherent FROM adherent where loginAdherent = ? and pwdAdherent = ?;");
					break;
				case "3":
					$requete = $this->conn->prepare("SELECT idEntraineur FROM entraineur where loginEntraineur = ? and pwdEntraineur = ?;");

					break;
			}

			$requete->bindValue(1, $login);
			$requete->bindValue(2, $pwd);

			// Utilisez execute pour exécuter la requête
			$result = $requete->execute();

			if ($result)
			{
				// Utilisez rowCount pour vérifier s'il y a des résultats
				if ($requete->rowCount() > 0)
				{
					//on va créer une ligne de log dans notre table logActionUtilisateur
					$requete = 'INSERT INTO logActionUtilisateur (action, temps, idUtilisateur) VALUES (\'connexion\', \'' . date('d-m-y h:i:s') . '\', \'' . $login . '\');';
					$result = $this->conn->query($requete);
					$bool = true;
				}
			}

			return $bool;
		}
		catch (PDOException $e)
		{
			die("erreur dans la requête de recherche du login et de password" . $e->getMessage());
		}
	}
	public function modifyPassword($role, $login, $pwd)
	{
		$pwd = MD5($pwd);
		switch ($role)
		{
			case "1":
				$requete = $this->conn->prepare("UPDATE administrateur SET pwdAdmin = ? WHERE loginAdmin = ?");
				$requete->bindValue(1, $pwd);
				$requete->bindValue(2, $login);
				break;
			case "2":
				$requete = $this->conn->prepare("UPDATE adherent SET pwdAdherent = ? WHERE loginAdherent = ?");
				$requete->bindValue(1, $pwd);
				$requete->bindValue(2, $login);
				break;
			case "3":
				$requete = $this->conn->prepare("UPDATE entraineur SET pwdEntraineur = ? WHERE loginEntraineur = ?");
				$requete->bindValue(1, $pwd);
				$requete->bindValue(2, $login);
				break;
		}
		// Exécuter la requête
		$result = $requete->execute();
		if($result)
		{
				// Créer une ligne de log dans la table logActionUtilisateur
				$req = 'INSERT INTO logActionUtilisateur (action, temps, idUtilisateur) VALUES (\'changement mot de passe\', \'' . date('Y-m-d H:i:s') . '\', \'' . $login . '\')';
				// Utiliser une requête préparée pour l'INSERT
				$stmt = $this->conn->prepare($req);
				$stmt->execute();
		}
	}
	public function afficheListeSelect()
	{
		$liste = 'Selectionnez un théme
				<SELECT name =theme id =theme onchange=appelAjax()><option value="">--sélection--</option>';                 // le onchange permet d'appeler la fonction javascript quand on change la valeur et pas au chargement donc au debut la page est vide
		$requete = 'SELECT code, libelle FROM theme;';
		$result = $this->conn->query($requete);
		while ($row = $result->fetch(PDO::FETCH_OBJ))
		{
			$liste = $liste . '<OPTION value=' . $row->code . '>' . $row->libelle . '</OPTION>';
		};
		$liste = $liste . '</SELECT>';
		return $liste;
	}
	public function afficheListeDesNouvelleTous()
	{
		$tableauDesLI = array("", "");
		$requete = 'SELECT code, date, description, codeTheme FROM nouvelle;';
		$result = $this->conn->query($requete);
		while ($row = $result->fetch(PDO::FETCH_OBJ))
		{
			$tableauDesLI[$row->codeTheme - 1] = $tableauDesLI[$row->codeTheme - 1] . "<LI>" . $row->nom . "</LI>";
		}
		return $tableauDesLI;
	}
	public function afficheListeDesNouvelleAjax()
	{
		// Assurez-vous que $_POST['ref'] est une valeur numérique valide
		$ref = intval($_POST['ref']);

		// Utilisez une requête préparée pour éviter l'injection SQL
		$requete = 'SELECT * FROM nouvelle WHERE codeTheme = :ref;';
		$liste = '<table class="table table-striped table-bordered table-sm w-100">
					<thead>
						<tr>
							<th>Nouvelle</th>
							<th>Date de parution</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>';

		$stmt = $this->conn->prepare($requete);
		$stmt->bindParam(':ref', $ref, PDO::PARAM_INT);
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_OBJ))
		{
			$liste .= '<tr>
						<td>' . $row->code . '</td>
						<td>' . $row->date . '</td>
						<td>' . $row->description . '</td>
					</tr>';
		}

		$liste .= '</tbody></table>';
		return $liste;
	}



	/******************************************************************************
	Nous avons toutes les fonctions d'insertion
	 *******************************************************************************/
	public function insertVacataire($unNomEntraineur, $unLoginEntraineur, $unPwdEntraineur, $unTelephone)
	{
		$sonId = $this->donneProchainIdentifiant("ENTRAINEUR", "idEntraineur");
		$requete = $this->conn->prepare("INSERT INTO ENTRAINEUR (idEntraineur,nomEntraineur,loginEntraineur,pwdEntraineur) VALUES (?,?,?,?)");
		$requete->bindValue(1, $sonId);
		$requete->bindValue(2, $unNomEntraineur);
		$requete->bindValue(3, $unLoginEntraineur);
		$requete->bindValue(4, $unPwdEntraineur);
		if (!$requete->execute())
		{
			die("Erreur dans insert Entraineur : " . $requete->errorCode());
		}

		$requete = $this->conn->prepare("INSERT INTO vacataire (idEntraineur,telephoneVacataire) VALUES (?,?)");
		$requete->bindValue(1, $sonId);
		$requete->bindValue(2, $unTelephone);
		if (!$requete->execute())
		{
			die("Erreur dans insert Vacataire : " . $requete->errorCode());
		}
		return $sonId;
	}

	public function insertTitulaire($unNomEntraineur, $unLoginEntraineur, $unPwdEntraineur, $uneDateEmbauche)
	{
		$sonId = $this->donneProchainIdentifiant("ENTRAINEUR", "idEntraineur");
		$requete = $this->conn->prepare("INSERT INTO ENTRAINEUR (idEntraineur,nomEntraineur,loginEntraineur,pwdEntraineur) VALUES (?,?,?,?)");
		$requete->bindValue(1, $sonId);
		$requete->bindValue(2, $unNomEntraineur);
		$requete->bindValue(3, $unLoginEntraineur);
		$requete->bindValue(4, $unPwdEntraineur);
		if (!$requete->execute())
		{
			die("Erreur dans insert Entraineur : " . $requete->errorCode());
		}
		echo 'une date d embauche : ' . $uneDateEmbauche;
		$requete = $this->conn->prepare("INSERT INTO titulaire (idEntraineur,dateEmbauche) VALUES (?,?)");
		$requete->bindValue(1, $sonId);
		$requete->bindValue(2, $uneDateEmbauche);
		if (!$requete->execute())
		{
			die("Erreur dans insert Titulaire : " . $requete->errorCode());
		}

		return $sonId;
	}

	public function insertSpecialite($nomSpecialite)
	{
		$sonId = $this->donneProchainIdentifiant("SPECIALITE", "idSpecialite");
		$requete = $this->conn->prepare("INSERT INTO SPECIALITE (idSpecialite,nomSpecialite) VALUES (?,?)");
		$requete->bindValue(1, $sonId);
		$requete->bindValue(2, $nomSpecialite);
		if (!$requete->execute())
		{
			die("Erreur dans insert Specialite : " . $requete->errorCode());
		}
		return $sonId;
	}



	public function insertAdherent($unNomAdherent, $unPrenomAdherent, $unAgeAdherent, $unSexeAdherent, $unLoginAdherent, $unPwdAdherent, $listeEquipe)
	{
		$moment = date("Y-m-d H:i:s");
		$pwd = MD5($unPwdAdherent);
		$triggers = ['triggerNbMaxAdherent' => false, 'triggerMaxEquipe' => false, 'triggerAge' => false, 'triggerSexe' => false];
		$sonId = $this->donneProchainIdentifiant("ADHERENT", "idAdherent");
		$lesEquipes = '';

		try
		{
			$sonId = $this->donneProchainIdentifiant("ADHERENT", "idAdherent");
			$requete = $this->conn->prepare("INSERT INTO ADHERENT (idAdherent,nomAdherent, prenomAdherent, ageAdherent, sexeAdherent,loginAdherent, pwdAdherent) VALUES (?,?,?,?,?,?,?)");
			$requete->bindValue(1, $sonId);
			$requete->bindValue(2, $unNomAdherent);
			$requete->bindValue(3, $unPrenomAdherent);
			$requete->bindValue(4, $unAgeAdherent);
			$requete->bindValue(5, $unSexeAdherent);
			$requete->bindValue(6, $unLoginAdherent);
			$requete->bindValue(7, $pwd);

			if (!$requete->execute())
			{
				die("Erreur dans insert Adherent : " . $requete->errorCode());
			}

			foreach ($listeEquipe as $idEquipe)
			{
				$requete = $this->conn->prepare("INSERT INTO POUVOIR (idAdherent, idEquipe) VALUES (?,?)");
				$requete->bindValue(1, $sonId);
				$requete->bindValue(2, $idEquipe);

				if (!$requete->execute())
				{
					die("<h1>ERREUR<br>Connexion à la base de données impossible.</h1>");
				}
				$lesEquipes .= $idEquipe . ', ';
			}
		}
		catch (PDOException $e)
		{
			$deleteAdherent = $this->conn->prepare("DELETE FROM adherent WHERE idAdherent = ?");
			$deleteAdherent->bindValue(1, $sonId);
			$deleteAdherent->execute();

			// Vérifiez si l'erreur est liée au déclencheur et affichez un message personnalisé
			//cherche si la variable contient 10008
			if (strpos($e->getMessage(), '10008') !== false)
			{
				$triggers['triggerNbMaxAdherent'] = true;
			}
			elseif (strpos($e->getMessage(), '10009') !== false)
			{
				$triggers['triggerMaxEquipe'] = true;
			}
			elseif (strpos($e->getMessage(), '10010') !== false)
			{
				$triggers['triggerAge'] = true;
			}
			elseif (strpos($e->getMessage(), '10011') !== false)
			{
				$triggers['triggerSexe'] = true;
			}
			else
			{
				echo "Une erreur s'est produite lors de la modification de l'adherent.";
				echo $e->getMessage();
			}
		}
		//ajout de l'action dans logActionUtilisateur
		$log = $this->conn->prepare("INSERT INTO logActionUtilisateur (action,temps,idUtilisateur) VALUES (?,?,?)");
		$log->bindValue(1, 'insert adherent ' . $sonId);
		$log->bindValue(2, $moment);
		$log->bindValue(3, $_SESSION['login']);
		if (!$log->execute())
		{
			die("<h1>ERREUR<br>Connexion à la base de données impossible.</h1>");
		}
		return $triggers;
	}


	public function insertCompetent($listeSpecialites)
	{
		$sonId = $this->donneProchainIdentifiant("ENTRAINEUR", "idEntraineur");
		$moment = date("Y-m-d H:i:s");
		$lesSpes = '';

		foreach ($listeSpecialites as $idSpe)
		{
			$req = $this->conn->prepare("INSERT INTO competent (idSpecialite, idEntraineur) VALUES (?,?)");
			$req->bindValue(1, $idSpe);
			$req->bindValue(2, $sonId - 1);
			if (!$req->execute())
			{
				die("<h1>ERREUR<br>Connexion à la base de données impossible.</h1>");
			}
			$lesSpes .= $idSpe . ', ';
		}
		//ajout de l'action dans logActionUtilisateur
		$log = $this->conn->prepare("INSERT INTO logActionUtilisateur (action,temps,idUtilisateur) VALUES (?,?,?)");
		$log->bindValue(1, 'insert entraineur ' . ($sonId - 1) . ' : spécialité ' . $lesSpes);
		$log->bindValue(2, $moment);
		$log->bindValue(3, $_SESSION['login']);
		if (!$log->execute())
		{
			die("<h1>ERREUR<br>Connexion à la base de données impossible.</h1>");
		}
	}


	public function insertEquipe($nomEquipe, $placeEquipe, $ageMin, $ageMax, $sexEquipe, $idSpecialites, $idEntraineur)
	{
		$triggers = ['trigger' => false, 'triggerCompEntraineur' => false];
		$sonId = $this->donneProchainIdentifiant("EQUIPE", "idEquipe");
		$moment = date("Y-m-d H:i:s");


		try
		{

			$req = $this->conn->prepare("INSERT INTO equipe (idEquipe, nomEquipe, nbrPlaceEquipe, ageMinEquipe, ageMaxEquipe, sexeEquipe, idSpecialite, idEntraineur) VALUES (?,?,?,?,?,?,?,?)");
			$req->bindValue(1, $sonId);
			$req->bindValue(2, $nomEquipe);
			$req->bindValue(3, $placeEquipe);
			$req->bindValue(4, $ageMin);
			$req->bindValue(5, $ageMax);
			$req->bindValue(6, $sexEquipe);
			$req->bindValue(7, $idSpecialites);
			$req->bindValue(8, $idEntraineur);

			$req->execute();
		}
		catch (PDOException $e)
		{
			// Vérifiez si l'erreur est liée au déclencheur et affichez un message personnalisé
			//cherche si la variable contient 10012
			if (strpos($e->getMessage(), '10012') !== false)
			{
				$triggers['trigger'] = true;
			}
			elseif (strpos($e->getMessage(), '10016') !== false)
			{
				$triggers['triggerCompEntraineur'] = true;
			}
			else
			{
				echo "Une erreur s'est produite lors de l'insertion de l'équipe.";
				echo $e->getMessage();
			}
		}


		//ajout de l'action dans logActionUtilisateur
		$log = $this->conn->prepare("INSERT INTO logActionUtilisateur (action,temps,idUtilisateur) VALUES (?,?,?)");
		$log->bindValue(1, 'insert equipe ' . ($sonId));
		$log->bindValue(2, $moment);
		$log->bindValue(3, $_SESSION['login']);
		if (!$log->execute())
		{
			die("<h1>ERREUR<br>Connexion à la base de données impossible.</h1>");
		}

		return $triggers;
	}

	/***********************************************************************************************
	toute les fonction d'update.
	 ***********************************************************************************************/
	public function modifEntraineur($idEntraineur, $listeSpecialites, $nomEntraineur, $loginEntraineur, $pwdEntraineur, $dateOuTel, $vacataire, $titulaire)
	{

		$requeteCompetent = $this->conn->prepare("DELETE FROM competent WHERE idEntraineur = ?");
		$requeteCompetent->bindValue(1, $idEntraineur);
		if (!$requeteCompetent->execute())
		{
			die("Erreur dans modif Specialite : " . $requeteCompetent->errorCode());
		}
		foreach ($listeSpecialites as $idSpe)
		{
			$req = $this->conn->prepare("INSERT INTO competent (idSpecialite, idEntraineur) VALUES (?,?)");
			$req->bindValue(1, $idSpe);
			$req->bindValue(2, $idEntraineur);
			if (!$req->execute())
			{
				die("<h1>ERREUR<br>Connexion à la base de données impossible.</h1>");
			}
		}
		if ($vacataire)
		{
			if ($pwdEntraineur == null)
			{
				$requeteVacataire = $this->conn->prepare("UPDATE entraineur SET nomEntraineur = ?, loginEntraineur = ? WHERE idEntraineur = ?");
				$requeteVacataire->bindValue(1, $nomEntraineur);
				$requeteVacataire->bindValue(2, $loginEntraineur);
				$requeteVacataire->bindValue(3, $idEntraineur);
				if (!$requeteVacataire->execute())
				{
					die("Erreur dans modif Specialite : " . $requeteVacataire->errorCode());
				}
			}
			else
			{
				$pwdEntraineur = MD5($pwdEntraineur);
				$requeteVacataire = $this->conn->prepare("UPDATE entraineur SET nomEntraineur = ?, loginEntraineur = ?, pwdEntraineur = ? WHERE idEntraineur = ?");
				$requeteVacataire->bindValue(1, $nomEntraineur);
				$requeteVacataire->bindValue(2, $loginEntraineur);
				$requeteVacataire->bindValue(3, $pwdEntraineur);
				$requeteVacataire->bindValue(4, $idEntraineur);
				if (!$requeteVacataire->execute())
				{
					die("Erreur dans modif Specialite : " . $requeteVacataire->errorCode());
				}
			}


			$reqVacataire = $this->conn->prepare("UPDATE vacataire SET telephoneVacataire = ? WHERE idEntraineur = ?");
			$reqVacataire->bindValue(1, $dateOuTel);
			$reqVacataire->bindValue(2, $idEntraineur);
			if (!$reqVacataire->execute())
			{
				die("Erreur dans modif Specialite : " . $reqVacataire->errorCode());
			}
		}

		if ($titulaire)
		{
			if ($pwdEntraineur == null)
			{
				$requeteTitulaire = $this->conn->prepare("UPDATE entraineur SET nomEntraineur = ?, loginEntraineur = ? WHERE idEntraineur = ?");
				$requeteTitulaire->bindValue(1, $nomEntraineur);
				$requeteTitulaire->bindValue(2, $loginEntraineur);
				$requeteTitulaire->bindValue(3, $idEntraineur);
				if (!$requeteTitulaire->execute())
				{
					die("Erreur dans modif Specialite : " . $requeteTitulaire->errorCode());
				}
			}
			else
			{
				$pwdEntraineur = MD5($pwdEntraineur);
				$requeteTitulaire = $this->conn->prepare("UPDATE entraineur SET nomEntraineur = ?, loginEntraineur = ?, pwdEntraineur = ? WHERE idEntraineur = ?");
				$requeteTitulaire->bindValue(1, $nomEntraineur);
				$requeteTitulaire->bindValue(2, $loginEntraineur);
				$requeteTitulaire->bindValue(3, $pwdEntraineur);
				$requeteTitulaire->bindValue(4, $idEntraineur);
				if (!$requeteTitulaire->execute())
				{
					die("Erreur dans modif Specialite : " . $requeteTitulaire->errorCode());
				}
			}


			$reqTitulaire = $this->conn->prepare("UPDATE titulaire SET dateEmbauche = ? WHERE idEntraineur = ?");
			$dateEmbaucheFormatted = date("Y-m-d", strtotime($dateOuTel));
			$reqTitulaire->bindValue(1, $dateEmbaucheFormatted);
			$reqTitulaire->bindValue(2, $idEntraineur);
			if (!$reqTitulaire->execute())
			{
				die("Erreur dans modif Specialite : " . $reqTitulaire->errorCode());
			}

			//ajout de l'action dans logActionUtilisateur
			$moment = date("Y-m-d H:i:s");

			$log = $this->conn->prepare("INSERT INTO logActionUtilisateur (action,temps,idUtilisateur) VALUES (?,?,?)");
			$log->bindValue(1, 'update entraineur ' . $idEntraineur);
			$log->bindValue(2, $moment);
			$log->bindValue(3, $_SESSION['login']);
			if (!$log->execute())
			{
				die("<h1>ERREUR<br>Connexion à la base de données impossible.</h1>");
			}
		}
		return $idEntraineur;
	}

	public function modifSpecialite($idSpecialite, $NomSpecialite)
	{
		$requete = $this->conn->prepare("UPDATE specialite SET nomSpecialite = ? where idSpecialite = ?");
		$requete->bindValue(1, $NomSpecialite);
		$requete->bindValue(2, $idSpecialite);

		if (!$requete->execute())
		{
			die("Erreur dans modif Specialite : " . $requete->errorCode());
		}

		$moment = date("Y-m-d H:i:s");

		$log = $this->conn->prepare("INSERT INTO logActionUtilisateur (action,temps,idUtilisateur) VALUES (?,?,?)");
		$log->bindValue(1, 'update spécialité ' . $idSpecialite);
		$log->bindValue(2, $moment);
		$log->bindValue(3, $_SESSION['login']);
		if (!$log->execute())
		{
			die("<h1>ERREUR<br>Connexion à la base de données impossible.</h1>");
		}
		return $idSpecialite;
	}

	public function modifEquipe($idEquipe, $nomEquipe, $placeEquipe, $ageMin, $ageMax, $sexEquipe, $idSpecialites, $idEntraineur)
	{
		$triggers = ['trigger' => false, 'triggerCompEntraineur' => false];
		$moment = date("Y-m-d H:i:s");

		try
		{

			$req = $this->conn->prepare("UPDATE equipe SET nomEquipe = ?, nbrPlaceEquipe = ?, ageMinEquipe = ?, ageMaxEquipe = ?, sexeEquipe = ?, idSpecialite = ?, idEntraineur = ? WHERE idEquipe = ?");
			$req->bindValue(1, $nomEquipe);
			$req->bindValue(2, $placeEquipe);
			$req->bindValue(3, $ageMin);
			$req->bindValue(4, $ageMax);
			$req->bindValue(5, $sexEquipe);
			$req->bindValue(6, $idSpecialites);
			$req->bindValue(7, $idEntraineur);
			$req->bindValue(8, $idEquipe);

			$req->execute();
		}
		catch (PDOException $e)
		{
			// Vérifiez si l'erreur est liée au déclencheur et affichez un message personnalisé
			//cherche si la variable contient 10012
			if (strpos($e->getMessage(), '10012') !== false)
			{
				$triggers['trigger'] = true;
			}
			elseif (strpos($e->getMessage(), '10016') !== false)
			{
				$triggers['triggerCompEntraineur'] = true;
			}
			else
			{
				echo "Une erreur s'est produite lors de l'insertion de l'équipe.";
				echo $e->getMessage();
			}
		}


		//ajout de l'action dans logActionUtilisateur
		$log = $this->conn->prepare("INSERT INTO logActionUtilisateur (action,temps,idUtilisateur) VALUES (?,?,?)");
		$log->bindValue(1, 'modification equipe ' . ($idEquipe));
		$log->bindValue(2, $moment);
		$log->bindValue(3, $_SESSION['login']);
		if (!$log->execute())
		{
			die("<h1>ERREUR<br>Connexion à la base de données impossible.</h1>");
		}

		return $triggers;
	}

	public function modifAdherent($idAdherent, $nomAdherent, $prenomAdherent, $age, $sexe, $login, $pwd, $listeEquipeApres, $listeEquipeAvant, $ancienNom, $ancienPrenom, $ancienAge, $ancienSexe, $ancienLogin, $ancienPwd)
	{
		$triggers = ['triggerNbMaxAdherent' => false, 'triggerMaxEquipe' => false, 'triggerAge' => false, 'triggerSexe' => false, 'adherentCritere' => false];
		$moment = date("Y-m-d H:i:s");

		try
		{

			if ($pwd == null)
			{
				$req = $this->conn->prepare("UPDATE adherent SET nomAdherent = ?, prenomAdherent = ?, ageAdherent = ?, sexeAdherent = ?, loginAdherent = ? WHERE idAdherent = ?");
				$req->bindValue(1, $nomAdherent);
				$req->bindValue(2, $prenomAdherent);
				$req->bindValue(3, $age);
				$req->bindValue(4, $sexe);
				$req->bindValue(5, $login);
				$req->bindValue(6, $idAdherent);

				if (!$req->execute())
				{
					die("Erreur dans modif adherent : " . $req->errorCode());
				}
			}
			else
			{
				$pwd = MD5($pwd);
				$req = $this->conn->prepare("UPDATE adherent SET nomAdherent = ?, prenomAdherent = ?, ageAdherent = ?, sexeAdherent = ?, loginAdherent = ?, pwdAdherent = ? WHERE idAdherent = ?");
				$req->bindValue(1, $nomAdherent);
				$req->bindValue(2, $prenomAdherent);
				$req->bindValue(3, $age);
				$req->bindValue(4, $sexe);
				$req->bindValue(5, $login);
				$req->bindValue(6, $pwd);
				$req->bindValue(7, $idAdherent);

				if (!$req->execute())
				{
					die("Erreur dans modif adherent : " . $req->errorCode());
				}
			}
			// Supprimer les pouvoirs existants de l'adhérent
			$deletePouvoir = $this->conn->prepare("DELETE FROM pouvoir WHERE idAdherent = ?");
			$deletePouvoir->bindValue(1, $idAdherent);
			if (!$deletePouvoir->execute())
			{
				die("Erreur dans delete pouvoir : " . $deletePouvoir->errorCode());
			}

			// Insérer les nouveaux pouvoirs de l'adhérent
			foreach ($listeEquipeApres as $equipe)
			{
				$requete = $this->conn->prepare("INSERT INTO pouvoir (idAdherent,idEquipe) VALUES (?,?)");
				$requete->bindValue(1, $idAdherent);
				$requete->bindValue(2, $equipe);
				if (!$requete->execute())
				{
					die("Erreur dans insert pouvoir : " . $requete->errorCode());
				}
			}
		}
		catch (PDOException $e)
		{
			try
			{
				// si une requete n'a pas fonctionné remettre les ancienne valeur
				$req = $this->conn->prepare("UPDATE adherent SET nomAdherent = ?, prenomAdherent = ?, ageAdherent = ?, sexeAdherent = ?, loginAdherent = ?, pwdAdherent = ? WHERE idAdherent = ?");
				$req->bindValue(1, $ancienNom);
				$req->bindValue(2, $ancienPrenom);
				$req->bindValue(3, $ancienAge);
				$req->bindValue(4, $ancienSexe);
				$req->bindValue(5, $ancienLogin);
				$req->bindValue(6, $ancienPwd);
				$req->bindValue(7, $idAdherent);

				if (!$req->execute())
				{
					die("Erreur dans insert ancienne valeur adherent : " . $req->errorCode());
				}

				// Supprimer les enregistrement de pouvoir car le 1er a pu passer dans le foreach plus haut
				$deletePouvoir = $this->conn->prepare("DELETE FROM pouvoir WHERE idAdherent = ?");
				$deletePouvoir->bindValue(1, $idAdherent);
				if (!$deletePouvoir->execute())
				{
					die("Erreur dans delete pouvoir : " . $deletePouvoir->errorCode());
				}
				foreach ($listeEquipeAvant as $equipe)
				{
					$requete = $this->conn->prepare("INSERT INTO pouvoir (idAdherent,idEquipe) VALUES (?,?)");
					$requete->bindValue(1, $idAdherent);
					$requete->bindValue(2, $equipe);
					if (!$requete->execute())
					{
						die("Erreur dans insert ancienne valeur pouvoir : " . $requete->errorCode());
					}
				}
				// Vérifier si l'erreur est liée à un déclencheur et enregistrer dans $triggers
				if (strpos($e->getMessage(), '10008') !== false)
				{
					$triggers['triggerNbMaxAdherent'] = true;
				}
				elseif (strpos($e->getMessage(), '10009') !== false)
				{
					$triggers['triggerMaxEquipe'] = true;
				}
				elseif (strpos($e->getMessage(), '10010') !== false)
				{
					$triggers['triggerAge'] = true;
				}
				elseif (strpos($e->getMessage(), '10011') !== false)
				{
					$triggers['triggerSexe'] = true;
				}
				else
				{
					echo "Une erreur s'est produite lors de la modification de l'adherent.";
					echo $e->getMessage();
				}
			}

			catch (PDOException $e)
			{
				$triggers['adherentCritere'] = true;
			}
		}

		//ajout de l'action dans logActionUtilisateur
		$log = $this->conn->prepare("INSERT INTO logActionUtilisateur (action,temps,idUtilisateur) VALUES (?,?,?)");
		$log->bindValue(1, 'modification ahderent ' . ($idAdherent));
		$log->bindValue(2, $moment);
		$log->bindValue(3, $_SESSION['login']);
		if (!$log->execute())
		{
			die("<h1>ERREUR<br>Connexion à la base de données impossible.</h1>");
		}

		return $triggers;
	}


	/***********************************************************************************************
	C'est la fonction qui permet de charger les tables et de les mettre dans un tableau 2 dimensions. La petite fontions specialCase permet juste de psser des minuscules aux majuscules pour les noms des tables de la base de données
	 ************************************************************************************************/
	public function chargement($uneTable)
	{
		$lesInfos = null;
		$nbTuples = 0;
		$stringQuery = "SELECT * FROM ";
		$stringQuery = $this->specialCase($stringQuery, $uneTable);
		$query = $this->conn->prepare($stringQuery);
		if ($query->execute())
		{
			while ($row = $query->fetch(PDO::FETCH_NUM))
			{
				$lesInfos[$nbTuples] = $row;
				$nbTuples++;
			}
		}
		else
		{
			die('Problème dans chargement : ' . $query->errorCode());
		}
		return $lesInfos;
	}

	private function specialCase($stringQuery, $uneTable)
	{
		$uneTable = strtoupper($uneTable);
		switch ($uneTable)
		{
			case 'VACATAIRE':
				$stringQuery .= 'vacataire';
				break;
			case 'SPECIALITE':
				$stringQuery .= 'specialite';
				break;
			case 'ADHERENT':
				$stringQuery .= 'adherent';
				break;
			case 'ENTRAINEUR':
				$stringQuery .= 'entraineur';
				break;
			case 'TITULAIRE':
				$stringQuery .= 'titulaire';
				break;
			case 'EQUIPE':
				$stringQuery .= 'equipe';
				break;
			case 'POUVOIR':
				$stringQuery .= 'pouvoir';
				break;
			default:
				die('Pas une table valide' . $uneTable);
				break;
		}

		return $stringQuery . ";";
	}

	/**************************************************************************
	fonction qui permet d'avoir le prochain identifiant de la table. Elle est là uniquement parce que nous n'avons pas d'autoincremente dans notre base de données
	 ***************************************************************************/
	public function donneProchainIdentifiant($uneTable)
	{
		$stringQuery = $this->specialCase("SELECT * FROM ", $uneTable);
		$requete = $this->conn->prepare($stringQuery);
		//$requete->bindValue(1,$unIdentifiant);

		if ($requete->execute())
		{
			$nb = 0;
			while ($row = $requete->fetch(PDO::FETCH_NUM))
			{
				$nb = $row[0];
			}
			return $nb + 1;
		}
		else
		{
			die('Erreur sur donneProchainIdentifiant : ' + $requete->errorCode());
		}
	}

	/************************************************************************
     Fonction qui me permettent d'obtenir le numéro max pour l'entraineur car comme nous avons un héritage, nous ne pouvons pas savoir le dernier numéro grace à conteneurVacataire ou conteneurTitulaire et normalement on a supprimé le conteneuEntraineur.
	 On aurait pu optimisé en ayant qu'une méthode et en faisant passer le nom de la table...
	 *************************************************************************/
	public function donneNumeroMaxEntraineur()
	{
		$stringQuery = "SELECT idEntraineur FROM entraineur";
		$requete = $this->conn->prepare($stringQuery);

		if ($requete->execute())
		{
			$nb = 0;
			while ($row = $requete->fetch(PDO::FETCH_NUM))
			{
				$nb + 1;
			}
			return $nb + 1;
		}
		else
		{
			die('Erreur sur l identifiant de l entraineur : ' + $requete->errorCode());
		}
	}

	public function donneNumeroMaxSpecialite()
	{
		$stringQuery = "SELECT * FROM specialite";
		$requete = $this->conn->prepare($stringQuery);
		if ($requete->execute())
		{
			$nb = 0;
			while ($row = $requete->fetch(PDO::FETCH_NUM))
			{
				$nb + 1;
			}
			return $nb + 1;
		}
		else
		{
			die('Erreur sur l identifiant de l specialite : ' + $requete->errorCode());
		}
	}

	public function donneNumeroMaxAdherent()
	{
		$stringQuery = "SELECT * FROM adherent";
		$requete = $this->conn->prepare($stringQuery);
		if ($requete->execute())
		{
			$nb = 0;
			while ($row = $requete->fetch(PDO::FETCH_NUM))
			{
				$nb + 1;
			}
			return $nb + 1;
		}
		else
		{
			die('Erreur sur l identifiant de l adherent : ' + $requete->errorCode());
		}
	}

	public function chercheSpecialite($idEntraineur)
	{
		$stringQuery = "SELECT specialite.idSpecialite, nomSpecialite FROM specialite inner join competent on competent.idSpecialite = specialite.idSpecialite WHERE competent.idEntraineur = $idEntraineur";
		$requete = $this->conn->prepare($stringQuery);
		$nbTuples = 0;
		$lesInfos = array();
		if ($requete->execute())
		{
			while ($row = $requete->fetch(PDO::FETCH_NUM))
			{
				$lesInfos[$nbTuples] = $row;
				$nbTuples++;
			}
		}
		else
		{
			die('Problème dans chargement : ' . $requete->errorCode());
		}
		return $lesInfos;
	}
	public function chercheEquipe($idAdherent)
	{
		$stringQuery = "SELECT equipe.*, specialite.*, entraineur.*
		FROM pouvoir 
		INNER JOIN equipe ON pouvoir.idEquipe = equipe.idEquipe 
		INNER JOIN specialite ON specialite.idSpecialite = equipe.idSpecialite 
		INNER JOIN entraineur ON entraineur.idEntraineur = equipe.idEntraineur 
		WHERE pouvoir.idAdherent = $idAdherent";
		$requete = $this->conn->prepare($stringQuery);
		$nbTuples = 0;
		$lesInfos = array();
		if ($requete->execute())
		{
			while ($row = $requete->fetch(PDO::FETCH_NUM))
			{
				$lesInfos[$nbTuples] = $row;
				$nbTuples++;
			}
		}
		else
		{
			die('Problème dans chargement : ' . $requete->errorCode());
		}
		return $lesInfos;
	}

	public function chercheEquipeEntraineur($idEntraineur)
	{
		$stringQuery = "SELECT equipe.*, specialite.*, entraineur.*
		FROM entrainer
		INNER JOIN equipe ON equipe.idEquipe = entrainer.idEquipe  
		INNER JOIN specialite ON specialite.idSpecialite = equipe.idSpecialite
		INNER JOIN entraineur ON entraineur.idEntraineur = equipe.idEntraineur 
		WHERE entrainer.idEntraineur = $idEntraineur";
		$requete = $this->conn->prepare($stringQuery);
		$nbTuples = 0;
		$lesInfos = array();
		if ($requete->execute())
		{
			while ($row = $requete->fetch(PDO::FETCH_NUM))
			{
				$lesInfos[$nbTuples] = $row;
				$nbTuples++;
			}
		}
		else
		{
			die('Problème dans chargement : ' . $requete->errorCode());
		}
		return $lesInfos;
	}
	public function afficheCoequipier($idAdherent)
	{
		$query = "SELECT adherent.nomAdherent, equipe.nomEquipe
		FROM adherent
		INNER JOIN pouvoir ON adherent.idAdherent = pouvoir.idAdherent
		INNER JOIN equipe ON pouvoir.idEquipe = equipe.idEquipe
		WHERE equipe.idEquipe IN (
			SELECT idEquipe
			FROM pouvoir
			WHERE idAdherent = $idAdherent
		)
		AND adherent.idAdherent <> $idAdherent  -- exclure
		ORDER BY adherent.idAdherent, equipe.idEquipe";
		$requete = $this->conn->prepare($query);
		$nbTuples = 0;
		$lesInfos = array();
		if ($requete->execute())
		{
			while ($row = $requete->fetch(PDO::FETCH_NUM))
			{
				$lesInfos[$nbTuples] = $row;
				$nbTuples++;
			}
		}
		else
		{
			die('Problème dans chargement : ' . $requete->errorCode());
		}
		return $lesInfos;
	}

	public function afficheSesSportif($idEntraineur)
	{
		$query = "SELECT equipe.nomEquipe, adherent.nomAdherent, adherent.prenomAdherent
		FROM adherent
		INNER JOIN pouvoir on pouvoir.idAdherent = adherent.idAdherent
		INNER JOIN equipe on equipe.idEquipe = pouvoir.idEquipe
		WHERE equipe.idEntraineur = $idEntraineur";

		$requete = $this->conn->prepare($query);
		$nbTuples = 0;
		$lesInfos = array();
		if ($requete->execute())
		{
			while ($row = $requete->fetch(PDO::FETCH_NUM))
			{
				$lesInfos[$nbTuples] = $row;
				$nbTuples++;
			}
		}
		else
		{
			die('Problème dans chargement : ' . $requete->errorCode());
		}
		return $lesInfos;
	}
}
