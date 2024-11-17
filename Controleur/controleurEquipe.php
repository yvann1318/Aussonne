<?php
switch ($action)
{
		/* 
		----------------------------------------------------
					AJOUTER UNE EQUIPE
		----------------------------------------------------
	*/
	case "ajouter":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$vue = new vueCentraleEquipe();
		$listeSpecialite = $this->toutesLesSpecialites->lesSpecialitesAuFormatHTML();
		$listeEntraineur = $this->tousLesEntraineurs->lesEntraineursAuFormatHTML();
		$vue->saisirEquipe($listeSpecialite, $listeEntraineur);
		break;
	case 'enregistrer':
		$nomEquipe = $_POST['nomEquipe'];
		$placeEquipe = $_POST['placeEquipe'];
		$ageMin = $_POST['ageMin'];
		$ageMax = $_POST['ageMax'];
		$sexEquipe = $_POST['sexEquipe'];
		$idSpecialites = $_POST['idSpecialite'];
		$idEntraineur = $_POST['idEntraineur'];
		$vacataire = $this->tousLesVacataires->chercherExistanceIdVacataire($idEntraineur);
		if ($vacataire)
		{
			$this->toutesLesEquipes->ajouterUneEquipe($this->maBD->donneProchainIdentifiant("EQUIPE") + 1, $nomEquipe, $placeEquipe, $ageMin, $ageMax, $sexEquipe, $this->toutesLesSpecialites->donneObjetSpecialiteDepuisNumero($idSpecialites), $this->tousLesVacataires->donneObjetVacataireDepuisNumero($idEntraineur));
		}
		else
		{
			$this->toutesLesEquipes->ajouterUneEquipe($this->maBD->donneProchainIdentifiant("EQUIPE") + 1, $nomEquipe, $placeEquipe, $ageMin, $ageMax, $sexEquipe, $this->toutesLesSpecialites->donneObjetSpecialiteDepuisNumero($idSpecialites), $this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($idEntraineur));
		}
		$triggers = $this->maBD->insertEquipe($nomEquipe, $placeEquipe, $ageMin, $ageMax, $sexEquipe, $idSpecialites, $idEntraineur);
		$triggerOccupeEquipe = $triggers['trigger'];
		$triggerCompEntraineur = $triggers['triggerCompEntraineur'];
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$vue = new vueCentraleEquipe();
		if ($triggerOccupeEquipe)
		{
			$vue->messageRequeteTriggerOccupeEquipe();
		}
		elseif ($triggerCompEntraineur)
		{
			$vue->messageRequeteTriggerCompEntraineur();
		}
		else
		{
			$vue->messageRequeteCreation();
		}
		break;

		/* 
		----------------------------------------------------
					FIN AJOUTER UNE EQUIPE
		----------------------------------------------------
	*/

		/* 
		----------------------------------------------------
					MODIFIER UNE EQUIPE
		----------------------------------------------------
	*/

	case "modifier":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$listeEquipe = $this->toutesLesEquipes->lesEquipesAuFormatHTML();
		$vue = new vueCentraleEquipe();
		$vue->modifierEquipe($listeEquipe);
		break;

	case "saisirModif":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$idEquipe = $_POST['idEquipe'];
		$lEquipe = $this->toutesLesEquipes->donneObjetEquipeDepuisNumero($idEquipe);
		$listeSpecialite = $this->toutesLesSpecialites->lesSpecialitesSelectedAuFormatHTML($lEquipe->idSpecialite);
		$listeEntraineur = $this->tousLesEntraineurs->lesEntraineursSelectedAuFormatHTML($lEquipe->idEntraineur);
		$listeSexe = $this->toutesLesEquipes->sexeEquipeAuFormatHTML($lEquipe->sexeEquipe);
		$vue = new vueCentraleEquipe();
		echo $lEquipe->idSpecialite;
		echo $lEquipe->idEntraineur;
		echo $lEquipe->sexeEquipe;
		$vue->saisirModifEquipe($idEquipe, $lEquipe->nomEquipe, $lEquipe->nbrPlaceEquipe, $lEquipe->ageMinEquipe, $lEquipe->ageMaxEquipe, $listeSpecialite, $listeEntraineur,$listeSexe);
		break;

	case 'enregistrerModification':
		$idEquipe = $_POST['idEquipe'];
		$nomEquipe = $_POST['nomEquipe'];
		$nbrPlaceEquipe = $_POST['nbrPlaceEquipe'];
		$ageMin = $_POST['ageMin'];
		$ageMax = $_POST['ageMax'];
		$sexEquipe = $_POST['sexEquipe'];
		$idSpecialite = $_POST['idSpecialite'];
		$idEntraineur = $_POST['idEntraineur'];
		/*$vacataire = $this->tousLesVacataires->chercherExistanceIdVacataire($idEntraineur);
		if ($vacataire)
		{
			$this->toutesLesEquipes->modifierUneEquipe($idEquipe, $nomEquipe, $nbrPlaceEquipe, $ageMin, $ageMax, $sexEquipe, $this->toutesLesSpecialites->donneObjetSpecialiteDepuisNumero($idSpecialite), $this->tousLesVacataires->donneObjetVacataireDepuisNumero($idEntraineur));
		}
		else
		{
			$this->toutesLesEquipes->modifierUneEquipe($idEquipe, $nomEquipe, $nbrPlaceEquipe, $ageMin, $ageMax, $sexEquipe, $this->toutesLesSpecialites->donneObjetSpecialiteDepuisNumero($idSpecialite), $this->tousLesTitulaires->donneObjetTitulaireDepuisNumero($idEntraineur));
		}*/
		$triggers = $this->maBD->modifEquipe($idEquipe, $nomEquipe, $nbrPlaceEquipe, $ageMin, $ageMax, $sexEquipe, $idSpecialite, $idEntraineur);
		$triggerOccupeEquipe = $triggers['trigger'];
		$triggerCompEntraineur = $triggers['triggerCompEntraineur'];
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$vue = new vueCentraleEquipe();
		if ($triggerOccupeEquipe)
		{
			$vue->messageRequeteTriggerOccupeEquipe();
		}
		elseif ($triggerCompEntraineur)
		{
			$vue->messageRequeteTriggerCompEntraineur();
		}
		else
		{
			$vue->messageRequeteModification();
		}
		break;

		/* 
		----------------------------------------------------
					FIN MODIFIER UNE EQUIPE
		----------------------------------------------------
	*/

	case "visualiser":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuInternaute($liste);
		$message = $this->toutesLesEquipes->listeDesEquipes();
		$vue = new vueCentraleEquipe();
		$vue->visualiserEquipe($message);
		break;

	default:
		echo "Erreur requête introuvable";
		break;
}
