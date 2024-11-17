<?php
class controleur
{
	private $toutesLesEquipes;
	private $toutesLesSpecialites;
	private $tousLesAdherents;
	private $tousLesEntraineurs;
	private $tousLesVacataires;
	private $tousLesTitulaires;
	private $maBD;

	/*********************************************************************************************************************
          CONSTRUCTEUR DE NOTRE CONTROLEUR
		       On construit tous les tableux d'objets et on les remplis vec la base de données
	 *********************************************************************************************************************/
	public function __construct()
	{
		$this->maBD = new accesBD();
		$this->tousLesEntraineurs = new conteneurEntraineur();
		$this->tousLesVacataires = new conteneurVacataire();
		$this->tousLesTitulaires = new conteneurTitulaire();
		$this->toutesLesSpecialites = new conteneurSpecialite();
		$this->toutesLesEquipes = new conteneurEquipe();
		$this->tousLesAdherents = new conteneurAdherent();

		$this->chargeLesEntraineurs();
		$this->chargeLesVacataires();
		$this->chargeLesTitulaires();
		$this->chargeLesSpecialites();
		$this->chargeLesEquipes();
		$this->chargeLesAdherents();
	}
	/*****************************************************************************************
           AFFICHAGE DES ENTETES ET PIED DE PAGE
		   
	 ******************************************************************************************/
	public function afficheEntete()
	{
		//appel de la vue de l'entête
		require 'Vues/ihm/entete.php';
	}


	public function affichePiedPage()
	{
		//appel de la vue du pied de page
		require 'Vues/ihm/piedPage.php';
	}

	/******************************************************************************************
          EN FONCTION DE LA VUE DEMANDE ON EFFECTUE TELLE OU TELLE ACTION
	 ********************************************************************************************/
	public function affichePage($action, $vue, $role)
	{
		if (isset($_GET['action']) && isset($_GET['vue']))
		{
			$action = $_GET['action'];
			$vue = $_GET['vue'];

			switch ($vue)
			{
				case "Entraineur":
					$this->actionEntraineur($action, $role);
					break;
				case "Specialite":
					$this->actionSpecialite($action, $role);
					break;
				case "Equipe":
					$this->actionEquipe($action, $role);
					break;
				case "Adherent":
					$this->actionAdherent($action, $role);
					break;
				case "Connexion":
					$this->actionConnexion($action, $role);
					break;
			}
		}
	}
	/************************************************************************************************
              POUR LES ACTIONS CONCERNANT LA CONNEXION
					- Mise en lace d'un menu spécifique pour chacun des roles
	 *************************************************************************************************/

	//---> On aiguille notre action
	public function actionConnexion($action, $role)
	{
		require 'controleur/controleurConnexion.php';
	}
	/************************************************************************************************
              POUR LES ACTIONS CONCERNANT LES ENTRAINEURS
					- ajouter un entraineur
					- enregistrer un entraineur
					- visualiser un entraineur
					- modifier un entraineur
	 *************************************************************************************************/

	//---> On aiguille notre action
	public function actionEntraineur($action, $role)
	{
		require 'controleur/controleurEntraineur.php';
	}

	public function chargeLesEntraineurs()
	{
		$resultatEntraineur = $this->maBD->chargement('entraineur');
		$resultatSpecialite = $this->maBD->chargement('specialite');
		$nbA = 0;
		while ($nbA < sizeof($resultatEntraineur))
		{
			$nbP = 0;
			while ($nbP < sizeof($resultatSpecialite))
			{
				if ($resultatEntraineur[$nbA][0] == $resultatSpecialite[$nbP][0])
				{
					$resultSpecialite = $this->maBD->chercheSpecialite($resultatEntraineur[$nbP][0]);
					$lesSpecialitesTemp = new conteneurSpecialite();
					$nb = 0;
					while ($nb < sizeof($resultSpecialite))
					{
						$lesSpecialitesTemp->ajouterUneSpecialite(
							$resultatSpecialite[$nb][0],
							$resultatSpecialite[$nb][1]
						);
						$nb++;
					}
				}
				$nbP++;
			}
			$this->tousLesEntraineurs->ajouterUnEntraineur($resultatEntraineur[$nbA][0], $resultatEntraineur[$nbA][1], $resultatEntraineur[$nbA][2], $resultatEntraineur[$nbA][3], $lesSpecialitesTemp);
			$nbA++;
		}
	}

	// On a une fonction outil de chargement de notre conteneur
	public function chargeLesVacataires()
	{
		$resultatEntraineur = $this->maBD->chargement('entraineur');
		$resultatVacataire = $this->maBD->chargement('vacataire');
		$resultatSpecialite = $this->maBD->chargement('specialite');
		$nbE = 0;
		while ($nbE < sizeof($resultatEntraineur))
		{
			$nbV = 0;
			while ($nbV < sizeof($resultatVacataire))
			{
				if ($resultatEntraineur[$nbE][0] == $resultatVacataire[$nbV][0])
				{
					$resultSpecialite = $this->maBD->chercheSpecialite($resultatVacataire[$nbV][0]);
					$lesSpecialites = new conteneurSpecialite();
					$nb = 0;
					while ($nb < sizeof($resultSpecialite))
					{
						$lesSpecialites->ajouterUneSpecialite($resultSpecialite[$nb][0], $resultSpecialite[$nb][1]);
						$nb++;
					}

					$this->tousLesVacataires->ajouterUnVacataire($resultatEntraineur[$nbE][0], $resultatEntraineur[$nbE][1], $resultatEntraineur[$nbE][2], $resultatEntraineur[$nbE][3], $resultatVacataire[$nbV][1], $lesSpecialites);
				}
				$nbV++;
			}
			$nbE++;
		}
	}

	public function chargeLesTitulaires()
	{
		$resultatEntraineur = $this->maBD->chargement('entraineur');
		$resultatTitulaire = $this->maBD->chargement('titulaire');
		$resultatSpecialite = $this->maBD->chargement('specialite');
		$nbE = 0;
		while ($nbE < sizeof($resultatEntraineur))
		{
			$nbT = 0;
			while ($nbT < sizeof($resultatTitulaire))
			{
				if ($resultatEntraineur[$nbE][0] == $resultatTitulaire[$nbT][0])
				{
					$resultSpecialite = $this->maBD->chercheSpecialite($resultatTitulaire[$nbT][0]);
					$lesSpecialites = new conteneurSpecialite();
					$nb = 0;
					while ($nb < sizeof($resultSpecialite))
					{
						$lesSpecialites->ajouterUneSpecialite($resultSpecialite[$nb][0], $resultSpecialite[$nb][1]);
						$nb++;
					}
					$this->tousLesTitulaires->ajouterUnTitulaire($resultatEntraineur[$nbE][0], $resultatEntraineur[$nbE][1], $resultatEntraineur[$nbE][2], $resultatEntraineur[$nbE][3], $resultatTitulaire[$nbT][1], $lesSpecialites);
				}
				$nbT++;
			}
			$nbE++;
		}
	}

	/************************************************************************************************
              POUR LES ACTIONS CONCERNANT LES SpecialiteS
					- ajouter une équipe
					- enregistrer une équipe
					- visualiser une équipe
					- modifier une équipe
	 *************************************************************************************************/

	//---> On aiguille notre action

	function actionSpecialite($action, $role)
	{
		require 'controleur/controleurSpecialite.php';
	}

	// On a une fonction outil de chargement de notre conteneur	

	public function chargeLesSpecialites()
	{
		$resultatSpecialite = $this->maBD->chargement('Specialite');
		$nbE = 0;
		while ($nbE < sizeof($resultatSpecialite))
		{
			$this->toutesLesSpecialites->ajouterUneSpecialite($resultatSpecialite[$nbE][0], $resultatSpecialite[$nbE][1]);

			$nbE++;
		}
	}


	/************************************************************************************************
              POUR LES ACTIONS CONCERNANT LES ADHERENTS
					- ajouter un adherent
					- enregistrer un adherent
					- visualiser un adherent
					- modifier un adherent
	 *************************************************************************************************/
	//---> On aiguille notre action		
	function actionAdherent($action, $role)
	{
		require 'controleur/controleurAdherent.php';
	}

	// On a une fonction outil de chargement de notre conteneur	

	public function chargeLesAdherents()
	{
		$resultatAdherent = $this->maBD->chargement('adherent');
		$resultatPouvoir = $this->maBD->chargement('pouvoir');
		// changement de la table pouvoir
		$nbA = 0;
		while ($nbA < sizeof($resultatAdherent))
		{
			$nbP = 0;
			while ($nbP < sizeof($resultatPouvoir))
			{
				if ($resultatAdherent[$nbA][0] == $resultatPouvoir[$nbP][0])
				{
					$resultEquipe = $this->maBD->chercheEquipe($resultatPouvoir[$nbP][0]);
					$lesEquipesTemp = new conteneurEquipe();
					$nb = 0;
					while ($nb < sizeof($resultEquipe))
					{
						$lesEquipesTemp->ajouterUneEquipe(
							$resultEquipe[$nb][0],
							$resultEquipe[$nb][1],
							$resultEquipe[$nb][2],
							$resultEquipe[$nb][3],
							$resultEquipe[$nb][4],
							$resultEquipe[$nb][5],
							new metierSpecialite(
								$resultEquipe[$nb][8],
								$resultEquipe[$nb][9]
							),
							new metierEntraineur(
								new conteneurSpecialite(),
								$resultEquipe[$nb][10],
								$resultEquipe[$nb][11],
								$resultEquipe[$nb][12],
								$resultEquipe[$nb][13]
							)
						);
						$nb++;
					}
				}
				$nbP++;
			}
			$this->tousLesAdherents->ajouterUnAdherent($lesEquipesTemp, $resultatAdherent[$nbA][0], $resultatAdherent[$nbA][1], $resultatAdherent[$nbA][2], $resultatAdherent[$nbA][3], $resultatAdherent[$nbA][4], $resultatAdherent[$nbA][5], $resultatAdherent[$nbA][6]);
			$nbA++;
		}
	}
	function verifierMotDePasse()
	{	//si la variable rempli passe dans le if
		if (isset($_POST["npass"]))
		{
			$etat = 1;
			$nouveauMotDePasse = $_POST["npass"];
			// si longueur mot de pass < 12
			if (strlen($nouveauMotDePasse) < 12)
			{
				echo '<p>Le mot de passe doit contenir au moins 12 caractères</p>';
				$etat = 0;
			}
			//si y'a pas au moin un chiffre
			if (!preg_match('/\d+/', $nouveauMotDePasse))
			{
				echo '<p>Le mot de passe doit contenir au moins un chiffre</p>';
				$etat = 0;
			}
			if (!preg_match('/[a-z]/', $nouveauMotDePasse))
			{
				echo '<p>Le mot de passe doit contenir au moins une minuscule</p>';
				$etat = 0;
			}
			if (!preg_match('/[A-Z]/', $nouveauMotDePasse))
			{
				echo '<p>Le mot de passe doit contenir au moins une majuscule</p>';
				$etat = 0;
			}
			//caractére spécial
			if (!preg_match('/\W+/', $nouveauMotDePasse))
			{
				echo '<p>Le mot de passe doit contenir au moins un caractère spécial</p>';
				$etat = 0;
			}
		}
		else
		{
			$etat = 0;
		}
		return $etat;
	}
	/************************************************************************************************
              POUR LES ACTIONS CONCERNANT LES Equipes
					- ajouter une équipe
					- enregistrer une équipe
					- visualiser une équipe
					- modifier une équipe
	 *************************************************************************************************/

	//---> On aiguille notre action

	function actionEquipe($action, $role)
	{
		require 'controleur/controleurEquipe.php';
	}

	// On a une fonction outil de chargement de notre conteneur	

	public function chargeLesEquipes()
	{
		$resultatEquipe = $this->maBD->chargement('equipe');
		$nbA = 0;
		while ($nbA < sizeof($resultatEquipe))
		{
			if ($this->tousLesVacataires->chercherExistanceIdVacataire($resultatEquipe[$nbA][7]))
			{
				$this->toutesLesEquipes->ajouterUneEquipe($resultatEquipe[$nbA][0], $resultatEquipe[$nbA][1], $resultatEquipe[$nbA][2], $resultatEquipe[$nbA][3], $resultatEquipe[$nbA][4], $resultatEquipe[$nbA][5], $this->toutesLesSpecialites->donneObjetSpecialiteDepuisNumero($resultatEquipe[$nbA][6]), $this->tousLesVacataires->donneObjetVacataireDepuisNumero($resultatEquipe[$nbA][7]));
			}
			else if ($this->tousLesTitulaires->chercherExistanceIdTitulaire($resultatEquipe[$nbA][7]))
			{
				$this->toutesLesEquipes->ajouterUneEquipe($resultatEquipe[$nbA][0], $resultatEquipe[$nbA][1], $resultatEquipe[$nbA][2], $resultatEquipe[$nbA][3], $resultatEquipe[$nbA][4], $resultatEquipe[$nbA][5], $this->toutesLesSpecialites->donneObjetSpecialiteDepuisNumero($resultatEquipe[$nbA][6]), $this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($resultatEquipe[$nbA][7]));
			}

			$nbA++;
		}
	}
}
