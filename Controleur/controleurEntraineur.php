<?php
switch ($action)
{
		/* 
		----------------------------------------------------
					AJOUTER UN ENTRAINEUR 
		----------------------------------------------------
	*/
	case "ajouter":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$vue = new vueCentraleEntraineur();
		$vue->ajouterEntraineur();

		break;
	case 'SaisirEntraineur':
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$typeEntraineur = $_POST['typeEntraineur'];
		$vue = new vueCentraleEntraineur();
		$listeSpecialite = $this->toutesLesSpecialites->lesSpecialitesMultipleAuFormatHTML();
		$vue->saisirEntraineur($listeSpecialite);
		break;
	case 'enregistrer':
		$typeEntraineur = $_POST['typeEntraineur'];
		$telEntraineur = null;
		$nomEntraineur = null;
		if ($typeEntraineur == "Vacataire")
		{
			$nomEntraineur = $_POST['nomEntraineur'];
			$loginEntraineur = $_POST['loginEntraineur'];
			$pwdEntraineur = $_POST['pwdEntraineur'];
			$telEntraineur = $_POST['numTelVacataire'];
			$listeSpecialites = $_POST['idSpecialite']; //cette liste contient les id des spécialités du nouvel entraineur 
			$this->tousLesVacataires->ajouterUnVacataire($this->maBD->donneProchainIdentifiant("ENTRAINEUR") + 1, $nomEntraineur, $loginEntraineur, $pwdEntraineur, $telEntraineur, new conteneurSpecialite($listeSpecialites));
			$this->maBD->insertVacataire($nomEntraineur, $loginEntraineur, $pwdEntraineur, $telEntraineur);
			$this->maBD->insertCompetent($listeSpecialites);
			$vue = new vueCentraleConnexion();
			$liste = $this->maBD->afficheListeSelect();
			$vue->afficheMenuAdmin($liste);
			$vue = new vueCentraleEntraineur();
			$vue->messageRequeteCreation();
		}
		else
		{
			$nomEntraineur = $_POST['nomEntraineur'];
			$loginEntraineur = $_POST['loginEntraineur'];
			$pwdEntraineur = $_POST['pwdEntraineur'];
			$dateEmbEntraineur = $_POST['dateEmbaucheTitulaire'];
			$listeSpecialites = $_POST['idSpecialite'];
			$this->tousLesTitulaires->ajouterUnTitulaire($this->maBD->donneProchainIdentifiant("ENTRAINEUR") + 1, $nomEntraineur,  $loginEntraineur, $pwdEntraineur, $dateEmbEntraineur, new conteneurSpecialite($listeSpecialites));
			$this->maBD->insertTitulaire($nomEntraineur, $loginEntraineur, $pwdEntraineur, $dateEmbEntraineur);
			$this->maBD->insertCompetent($listeSpecialites);
			$vue = new vueCentraleConnexion();
			$liste = $this->maBD->afficheListeSelect();
			$vue->afficheMenuAdmin($liste);
			$vue = new vueCentraleEntraineur();
			$vue->messageRequeteCreation();
		}
		break;
		/*
	----------------------------------------------------------------
					FIN AJOUTER UN ENTRAINEUR
	----------------------------------------------------------------
	*/


		/*
	----------------------------------------------------------------
					MODIFIER UN ENTRAINEUR
	----------------------------------------------------------------
	*/
	case "modifier":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$listeEntraineur = $this->tousLesEntraineurs->lesEntraineursAuFormatHTML();
		$vue = new vueCentraleEntraineur();
		$vue->modifierEntraineur($listeEntraineur);
		break;
	case "saisirModification":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$idEntraineur = $_POST['idEntraineur'];
		$vue = new vueCentraleEntraineur();
		$lVacataire = $this->tousLesVacataires->chercherExistanceIdVacataire($idEntraineur);
		if ($lVacataire)
		{
			$vacataire = true;
			$titulaire = false;
			$entraineur = $this->tousLesVacataires->donneObjetVacataireDepuisNumero($idEntraineur);
			$listeSpecialite = $this->toutesLesSpecialites->lesSpecialitesMultipleSelectedAuFormatHTML($entraineur->idSpecialites());
			$vue->saisirModifEntraineur($listeSpecialite, $idEntraineur, $entraineur->nomEntraineur, $entraineur->loginEntraineur, $entraineur->pwdEntraineur, $entraineur->telephone, $vacataire, $titulaire);
		}
		else
		{
			$vacataire = false;
			$titulaire = true;
			$entraineur = $this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($idEntraineur);
			$listeSpecialite = $this->toutesLesSpecialites->lesSpecialitesMultipleSelectedAuFormatHTML($entraineur->idSpecialites());
			echo json_encode($this->tousLesTitulaires);
			$vue->saisirModifEntraineur($listeSpecialite, $idEntraineur, $entraineur->nomEntraineur, $entraineur->loginEntraineur, $entraineur->pwdEntraineur, $entraineur->dateEmbauche, $vacataire, $titulaire);
		}
		break;
	case "enregistrerModification":
		$idEntraineur = $_POST['idEntraineur'];
		$listeSpecialites = $_POST['idSpecialite'];
		$nomEntraineur = $_POST['nomEntraineur'];
		$loginEntraineur = $_POST['loginEntraineur'];
		$pwdEntraineur = $_POST['pwdEntraineur'];

		//initialiser les variable qui peuvent ne rien contenir comme un if-else
		$dateOuTel = isset($_POST['dateOuTel']) ? $_POST['dateOuTel'] : null;
		$vacataire = isset($_POST['vacataire']) ? $_POST['vacataire'] : null;
		$titulaire = isset($_POST['titulaire']) ? $_POST['titulaire'] : null;
		$lVacataire = $this->tousLesVacataires->chercherExistanceIdVacataire($idEntraineur);
		if($lVacataire)
		{
			$entraineur = $this->tousLesVacataires->donneObjetVacataireDepuisNumero($idEntraineur);
			if($entraineur->pwdEntraineur === $pwdEntraineur)
			{
				$pwdEntraineur = null;
			}
			$this->maBD->modifEntraineur($idEntraineur, $listeSpecialites, $nomEntraineur, $loginEntraineur, $pwdEntraineur, $dateOuTel, $vacataire, $titulaire);
		}
		else
		{
			$entraineur = $this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($idEntraineur);
			if($entraineur->pwdEntraineur === $pwdEntraineur)
			{
				$pwdEntraineur = null;
			}
			$this->maBD->modifEntraineur($idEntraineur, $listeSpecialites, $nomEntraineur, $loginEntraineur, $pwdEntraineur, $dateOuTel, $vacataire, $titulaire);
		}
		//$this->maBD->modifEntraineur($idEntraineur, $listeSpecialites, $nomEntraineur, $loginEntraineur, $pwdEntraineur, $dateOuTel, $vacataire, $titulaire);
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$vue = new vueCentraleEntraineur();
		$vue->messageRequeteModification();
		break;

		/*
	----------------------------------------------------------------
					FIN MODIFIER UN ENTRAINEUR
	----------------------------------------------------------------
	*/
	case "visualiser":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuInternaute($liste);
		$liste = $this->tousLesTitulaires->listeDesTitulaires();
		$liste = $liste . $this->tousLesVacataires->listeDesVacataires();
		$vue = new vueCentraleEntraineur();
		$vue->VisualiserEntraineur($liste);
		break;
	case "visualiserSesEquipes":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuEntraineur($liste);
		$idEntraineur = $this->tousLesEntraineurs->idEntraineur();
		$sesEquipes = $this->maBD->afficheSesSportif($idEntraineur);
		$vue = new vueCentraleEntraineur();
		$vue->afficheSesEquipes($sesEquipes);

		break;
	case "informationProfil":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuEntraineur($liste);
		$id = $this->tousLesEntraineurs->infoEntraineur();
		$vue = new vueCentraleEntraineur();
		$vue->informationEntraineur($id);
		break;
	case "modifierSonProfil":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuEntraineur($liste);
		$vue = new vueCentraleEntraineur();
		$vue->modifierSonProfilEntraineur();
		$result = $this->verifierMotDePasse();
		if ($result == 1)
		{
			echo '<p>Le mot de passe est valide</p>';
			$_SESSION['pwd'] = $_POST['npass'];
			$this->maBD->modifyPassword($_SESSION['role'], $_SESSION['login'], $_SESSION['pwd']);
		}
		break;
}
