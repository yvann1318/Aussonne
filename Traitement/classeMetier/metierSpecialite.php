<?php
class metierSpecialite
{



	//CONSTRUCTEUR-----------------------------------------------------------------------------

	public function __construct(private int $idSpecialite = 0, private string $nomSpecialite = '')
	{
		
	}
	public function ajoutSpecialite($lSpecialite)
	{
		$this->idSpecialite = $lSpecialite->idSpecialite;
		$this->nomSpecialite = $lSpecialite->nomSpecialite;
	}
	//ACCESSEURS-------------------------------------------------------------------------------
	public function __get($attribut)
	{
		switch ($attribut)
		{
			case 'idSpecialite':
				return $this->idSpecialite;
				break;
			case 'nomSpecialite':
				return $this->nomSpecialite;
				break;
			case 'nbrPlaceEquipe':
				return $this->nbrPlaceEquipe;
				break;
			case 'ageMinEquipe':
				return $this->ageMinEquipe;
				break;
			case 'ageMaxEquipe':
				return $this->ageMaxEquipe;
				break;
			case 'sexeEquipe':
				return $this->sexeEquipe;
				break;
			default:
				$trace = debug_backtrace();
				trigger_error('Propriété non-accessible via _get() :' . $attribut . 'dans ' . $trace[0]['file'] . ' à la ligne' . $trace[0]['line'], E_USER_NOTICE);
				break;
		}
	}

	//SETTEUR------------------------------------------------------------

	public function __set($attribut, $laValeurDeLAttribut)
	{
		switch ($attribut)
		{
			case 'idSpecialite':
				$this->idSpecialite = $laValeurDeLAttribut;
				break;
			case 'nomSpecialite':
				$this->nomSpecialite = $laValeurDeLAttribut;
				break;
			case 'nbrPlaceEquipe':
				$this->nbrPlaceEquipe = $laValeurDeLAttribut;
				break;
			case 'sexeEquipe':
				$this->sexeEquipe = $laValeurDeLAttribut;
				break;
			case 'ageMinEquipe':
				$this->ageMinEquipe = $laValeurDeLAttribut;
				break;
			case 'ageMaxEquipe':
				$this->ageMaxEquipe = $laValeurDeLAttribut;
				break;
			case 'idEntraineur':
				$this->idEntraineur = $laValeurDeLAttribut;
				break;
			case 'nomEntraineur':
				$this->nomEntraineur = $laValeurDeLAttribut;
				break;
			default:
				$trace = debug_backtrace();
				trigger_error('Propriété non-accessible via _get() :' . $attribut . 'dans ' . $trace[0]['file'] . ' à la ligne' . $trace[0]['line'], E_USER_NOTICE);
				break;
		}
	}

	// méthode permettant d'afficher tous les attributs d'un seul coup
	public function afficheSpecialite()
	{
		return $this->nomSpecialite. '\n';
	}
}
