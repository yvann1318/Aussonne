<?php
	

Class metierTitulaire extends metierEntraineur
	{
	//ATTRIBUTS PRIVES-------------------------------------------------------------------------
	private $dateEmbauche; 
	
		
	//CONSTRUCTEUR-----------------------------------------------------------------------------
	public function __construct($lesSpecialites, $unIdEntraineur, $unNomEntraineur, $unLoginEntraineur, $unPwdEntraineur,private string $uneDateEmbauche='')
		{
		parent::__construct(lesSpecialites : $lesSpecialites, idEntraineur: $unIdEntraineur,nomEntraineur : $unNomEntraineur, loginEntraineur :$unLoginEntraineur, pwdEntraineur : $unPwdEntraineur);
		$this->dateEmbauche = $uneDateEmbauche;
		}
	
	//ACCESSEURS-------------------------------------------------------------------------------
	public function __get($attribut)
	{	switch ($attribut)
		{	case 'idEntraineur' : 
				return parent::__get('idEntraineur'); break;
	   		case 'nomEntraineur' : 
			   return parent::__get('nomEntraineur'); break;
	   		case 'loginEntraineur' : 
			   return parent::__get('loginEntraineur'); break;
	   		case 'pwdEntraineur' : 
				   return parent::__get('pwdEntraineur'); break;
			case 'dateEmbauche' :
				return $this->dateEmbauche; break;
			default :
				$trace = debug_backtrace();
				trigger_error('Propriété non-accessible via _get() :'.$attribut.'dans '.$trace[0]['file'].' à la ligne'.$trace[0]['line'],E_USER_NOTICE);
				break;
		}
	}
		
	//SETTEUR------------------------------------------------------------
	
	public function __set($attribut, $laValeurDeLAttribut)
		{	switch($attribut)
			{	case 'dateEmbauche' :
					$this->dateEmbauche=$laValeurDeLAttribut; break;
				default :
                    $trace = debug_backtrace();
                    trigger_error('Propriété non-accessible via _get() :'.$attribut.'dans '.$trace[0]['file'].' à la ligne'.$trace[0]['line'],E_USER_NOTICE);
				    break;
			}
		}	
	// méthode permettant d'afficher tous les attributs d'un seul coup
	public function afficheTitulaire()
	{
		$liste=parent::afficheEntraineur();
		$liste=$liste.$this->dateEmbauche. '\n';
		return $liste;
	}			    
	
	}
	
?>