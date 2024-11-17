<?php

class metierAdherent
{

	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct(private conteneurEquipe $lesEquipes, private int $idAdherent = 0, private string $nomAdherent = '', private string $prenomAdherent = '', private int $ageAdherent = 0, private string $sexeAdherent = '', private string $loginAdherent = '', private string $pwdAdherent = '')
	{
	}


	//ACCESSEURS-------------------------------------------------------------------------------
	public function __get($attribut)
	{
		switch ($attribut)
		{
			case 'idAdherent':
				return $this->idAdherent;
				break;
			case 'nomAdherent':
				return $this->nomAdherent;
				break;
			case 'prenomAdherent':
				return $this->prenomAdherent;
				break;
			case 'ageAdherent':
				return $this->ageAdherent;
				break;
			case 'sexeAdherent':
				return $this->sexeAdherent;
				break;
			case 'loginAdherent':
				return $this->loginAdherent;
				break;
			case 'pwdAdherent':
				return $this->pwdAdherent;
				break;
			default:
				$trace = debug_backtrace();
				trigger_error('Propriété non-accessible via _get() :' . $attribut . 'dans ' . $trace[0]['file'] . ' à la ligne' . $trace[0]['line'], E_USER_NOTICE);
				break;
		}
	}

	// les setteurs-----------------------------------------------------

	public function __set($attribut, $laValeurDeLAttribut)
	{
		switch ($attribut)
		{
			case 'idAdherent':
				$this->idAdherent = $laValeurDeLAttribut;
				break;
			case 'nomAdherent':
				$this->nomAdherent = $laValeurDeLAttribut;
				break;
			case 'prenomAdherent':
				$this->prenomAdherent = $laValeurDeLAttribut;
				break;
			case 'ageAdherent':
				$this->ageAdherent = $laValeurDeLAttribut;
				break;
			case 'loginAdherent':
				$this->loginAdherent = $laValeurDeLAttribut;
				break;
			case 'pwdAdherent':
				$this->pwdAdherent = $laValeurDeLAttribut;
				break;
			case 'idEquipe':
				$this->lesEquipe->idEquipe = $laValeurDeLAttribut;
				break;
			case 'nomEquipe':
				$this->lesEquipe->nomEquipe = $laValeurDeLAttribut;
				break;
			default:
				$trace = debug_backtrace();
				trigger_error('Propriété non-accessible via _get() :' . $attribut . 'dans ' . $trace[0]['file'] . ' à la ligne' . $trace[0]['line'], E_USER_NOTICE);
				break;
		}
	}

	// méthode permettant d'afficher tous les attributs d'un seul coup
	public function afficheAdherent()
	{
		$liste = $this->nomAdherent . '|' . $this->prenomAdherent . '|' . $this->ageAdherent . '|' . $this->sexeAdherent . '|' . $this->loginAdherent . '|' . $this->lesEquipes->leNomDesEquipes() . '|' . $this->lesEquipes->specialiteDesEquipes(). '\n';

		return  $liste;
	}

	public function afficheIdAdherent()
	{
		$liste = $this->idAdherent ;

		return  $liste;
	}
	public function idEquipe()
	{
		return $this->lesEquipes->idDesEquipes();
	}
}
