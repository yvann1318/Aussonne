<?php
use PHPUnit\Framework\TestCase;
include_once('metierAdherent.php');
include_once('metierEquipe.php');
include_once('metierEntraineur.php');

class testAdherent extends TestCase
{
    private metierAdherent $A;
    private metierEquipe $E;
    private metierEntraineur $En;
     /**
     * @before
     */
    public function new()
    {
        $this->En1 = new metierEntraineur(1,'Durant','gogo','lolo');
        $this->E1 = new metierEquipe($this->En1,1,'toto',12,10,14,'F');
        $this->A1 = new metierAdherent($this->E1,1,'Dupont','pierre',8,'F','pDupont','pDupont');        
        
    }      
    
    public function testGet()
    {
        $this->assertEquals($this->A1->nomAdherent,"Dupont", "lol");
    }

    public function testSet()
    {
        $this->A1->idEquipe = 2;
        $this->assertEquals($this->A1->idEquipe,2, "erreur changement équipe");
    }
        
}