<?php
switch ($action)
{
	case "ajouter":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$vue = new vueCentraleAdherent();
		$listeEquipe = $this->toutesLesEquipes->lesEquipesAuFormatHTMLMultiple();
		$vue->saisirAdherents($listeEquipe);
		break;

	case "enregistrer":
		$nom = $_POST['nom'];
		$prenom = $_POST['prenom'];
		$age = $_POST['age'];
		$sexe = $_POST['sexe'];
		$login = $_POST['login'];
		$pwd = $_POST['pwd'];
		$listeEquipe = $_POST['idEquipe'];
		$triggers = $this->maBD->insertAdherent($nom,$prenom,$age,$sexe,$login,$pwd, $listeEquipe);
		$triggerNbMaxAdherent = $triggers['triggerNbMaxAdherent'];
		$triggerMaxEquipe = $triggers['triggerMaxEquipe'];
		$triggerAge = $triggers['triggerAge'];
		$triggerSexe = $triggers['triggerSexe'];
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$vue = new vueCentraleAdherent();
		if ($triggerNbMaxAdherent)
		{
			$vue->messageRequeteTriggerNbMaxAdherent();
		}
		elseif ($triggerMaxEquipe)
		{
			$vue->messageRequeteTriggerMaxEquipe();
		}
		elseif ($triggerAge)
		{
			$vue->messageRequeteTriggerAge();
		}
		elseif ($triggerSexe)
		{
			$vue->messageRequeteTriggerSexe();
		}
		else
		{
			$vue->messageRequeteInsert();
		}
		break;

	case "modifier":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$vue = new vueCentraleAdherent();
		$liste = $this->tousLesAdherents->lesAdherentsAuFormatHTML();
		$vue->modifierAdherent($liste);
		break;

	case "saisirModif":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$vue = new vueCentraleAdherent();
		$idAdherent = $_POST['idAdherent'];
		$lAdherent = $this->tousLesAdherents->donneObjetAdherentDepuisNumero($idAdherent);
		$listeEquipe = $this->toutesLesEquipes->lesEquipesMultipleSelectedAuFormatHTML($lAdherent->idEquipe()); 
		$listeSexe = $this->tousLesAdherents->sexeAdherentAuFormatHTML($lAdherent->sexeAdherent);
		$vue->saisirModifAdherent($idAdherent, $lAdherent->nomAdherent, $lAdherent->prenomAdherent, $lAdherent->ageAdherent, $lAdherent->loginAdherent, $lAdherent->pwdAdherent, $listeEquipe, $listeSexe);
		break;

	case "enregistrerModif":
		$idAdherent = $_POST['idAdherent'];
		$lAdherent = $this->tousLesAdherents->donneObjetAdherentDepuisNumero($idAdherent);
		$ancienNom = $lAdherent->nomAdherent;
		$ancienPrenom = $lAdherent->prenomAdherent;
		$ancienAge = $lAdherent->ageAdherent;
		$ancienSexe = $lAdherent->sexeAdherent;
		$ancienLogin = $lAdherent->loginAdherent;
		$ancienPwd = $lAdherent->pwdAdherent;

		
		$nom = $_POST['nomAdherent'];
		$prenom = $_POST['prenomAdherent'];
		$age = $_POST['age'];
		$sexe = $_POST['sexEquipe'];
		$login = $_POST['login'];
		$pwd = $_POST['pwd'];
		$listeEquipeAvant = $lAdherent->idEquipe(); 
		if($pwd == $lAdherent->pwdAdherent)
		{
			$pwd = null;
		}
		$listeEquipeApres = $_POST['idEquipe'];
		$triggers = $this->maBD->modifAdherent($idAdherent,$nom,$prenom,$age,$sexe,$login,$pwd,$listeEquipeApres,$listeEquipeAvant,$ancienNom,$ancienPrenom,$ancienAge,$ancienSexe,$ancienLogin,$ancienPwd);
		$triggerNbMaxAdherent = $triggers['triggerNbMaxAdherent'];
		$triggerMaxEquipe = $triggers['triggerMaxEquipe'];
		$triggerAge = $triggers['triggerAge'];
		$triggerSexe = $triggers['triggerSexe'];
		$triggerCritere = $triggers['adherentCritere'];
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$vue = new vueCentraleAdherent();
		if ($triggerNbMaxAdherent)
		{
			$vue->messageRequeteTriggerNbMaxAdherent();
		}
		elseif ($triggerMaxEquipe)
		{
			$vue->messageRequeteTriggerMaxEquipe();
		}
		elseif ($triggerAge)
		{
			$vue->messageRequeteTriggerAge();
		}
		elseif ($triggerSexe)
		{
			$vue->messageRequeteTriggerSexe();
		}
		elseif($triggerCritere)
		{
			$vue->messageRequeteCritere();
		}
		else
		{
			$vue->messageRequeteUpdate();
		}
		break;



	case "modifierSonProfil":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdherent($liste);
		$vue = new vueCentraleAdherent();
		$vue->modifierSonProfilAdherent();
		$result = $this->verifierMotDePasse();
		if ($result == 1)
		{
			echo '<p>Le mot de passe est valide</p>';
			$_SESSION['pwd'] = $_POST['npass'];
			$this->maBD->modifyPassword($_SESSION['role'], $_SESSION['login'], $_SESSION['pwd']);
		}
		break;
	case "voyager":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdherent($liste);
		$vue = new vueCentraleAdherent();
		$vue->voyagerAdherent();
		break;
	case "informationProfil":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdherent($liste);
		$id = $this->tousLesAdherents->infoAdherent();
		$idAdherent = $this->tousLesAdherents->idAdherent();
		$coequipier = $this->maBD->afficheCoequipier($idAdherent);
		$vue = new vueCentraleAdherent();
		$vue->informationAdherent($id, $coequipier);
		break;
	case "visualiser":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuInternaute($liste);
		$message = $this->tousLesAdherents->listeDesAdherents();
		$vue = new vueCentraleAdherent();
		$vue->visualiserAdherent($message);
		break;
}
