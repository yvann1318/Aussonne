<?php
switch ($action)
{
	/* 
		----------------------------------------------------
					AJOUTER UNE SPECIALITE 
		----------------------------------------------------
	*/
	case "ajouter":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$vue = new vueCentraleSpecialite();
		$vue->saisirSpecialite();
		break;
	case "enregistrer":
		$nomSpecialite = $_POST['nomSpecialite'];
		$this->toutesLesSpecialites->ajouterUneSpecialite($this->maBD->donneProchainIdentifiant("SPECIALITE") + 1,$nomSpecialite);
		$this->maBD->insertSpecialite($nomSpecialite);
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$vue = new vueCentraleSpecialite();
		$vue->messageRequeteInsert();
		break;

	/* 
		----------------------------------------------------
					FIN AJOUTER UNE SPECIALITE 
		----------------------------------------------------
	*/

	/* 
		----------------------------------------------------
					MODIFIER UNE SPECIALITE 
		----------------------------------------------------
	*/
	case "modifier":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$listeSpecialite = $this->toutesLesSpecialites->lesSpecialitesAuFormatHTML();
		$vue = new vueCentraleSpecialite();
		$vue->modifierSpecialite($listeSpecialite);
		break;
	case "saisirModif":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$idSpecialite = $_POST['idSpecialite'];
		$lSpecialite = $this->toutesLesSpecialites->donneObjetSpecialiteDepuisNumero($idSpecialite);
		$vue = new vueCentraleSpecialite();
		$vue->saisirModifSpecialite($idSpecialite, $lSpecialite->nomSpecialite);
		break;
	case "enregModif":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuAdmin($liste);
		$idSpecialite = $_POST['idSpecialite'];
		$nomSpecialite = $_POST['nomSpecialite'];
		$this->maBD->modifSpecialite($idSpecialite, $nomSpecialite,);
		$this->toutesLesSpecialites->modifierUneSpecialite($idSpecialite, $nomSpecialite);
		$vue = new vueCentraleSpecialite();
		$vue->messageRequeteModification();
		break;

	/* 
		----------------------------------------------------
					FIN MODIFIER UN ENTRAINEUR 
		----------------------------------------------------
	*/

	case "visualiser":
		$vue = new vueCentraleConnexion();
		$liste = $this->maBD->afficheListeSelect();
		$vue->afficheMenuInternaute($liste);
		$message = $this->toutesLesSpecialites->listeDesSpecialites();
		$vue = new vueCentraleSpecialite();
		$vue->visualiserSpecialite($message);
		break;
}
