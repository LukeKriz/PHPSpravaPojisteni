<?php

class DetailPojisteniKontroler extends Kontroler
{
	public function zpracuj(array $parametry) : void
	{
        //ověření uživatele
        $this->overUzivatele();
       // Vytvoření instance modelu, který nám umožní pracovat s články
    
       $spravcePojisteni = new SpravcePojistencu();
        // Je zadáno URL článku ke smazání
      if (!empty($parametry[3]) && $parametry[3] == 'smazat')
        {   
            $spravcePojisteni->odstranEvent($parametry[2]);
            
          };
         
    

    
      
       // Je zadáno URL článku ke smazání
       if (!empty($parametry[1]))
               {   
                $pojisteni=$spravcePojisteni->nactiDetailPojisteni($parametry[1]);

                 };


        if (!$pojisteni)
            $this->presmeruj('chyba');
      
        $this->data['user_id'] = $pojisteni['user_id'];     
        $this->data['insurance_id'] = $pojisteni['insurance_id'];
       $this->data['druh_pojisteni'] = $pojisteni['druh_pojisteni'];
       $this->data['castka'] = $pojisteni['castka'];
       $this->data['predmet_pojisteni'] = $pojisteni['predmet_pojisteni'];

       // nacteni a prevedeni data platnosti
       $pojisteni['platnost_od']=mb_substr($pojisteni['platnost_od'], 8, 2).'. '.mb_substr($pojisteni['platnost_od'], 5, 2.). '. '.mb_substr($pojisteni['platnost_od'], 0, 4.);
       $this->data['platnost_od'] = $pojisteni['platnost_od'];

       
       $pojisteni['platnost_do']=mb_substr($pojisteni['platnost_do'], 8, 2).'. '.mb_substr($pojisteni['platnost_do'], 5, 2.). '. '.mb_substr($pojisteni['platnost_do'], 0, 4.);
       $this->data['platnost_do'] = $pojisteni['platnost_do'];
     
          
         //
       $spravceUzivatelu = new SpravceUzivatelu();    
       $uzivatel = $spravceUzivatelu->vratUzivatele();
       $this->data['jmeno'] = $uzivatel['jmeno'];
       $this->data['admin'] = $uzivatel['admin'];
       
       $this->pohled = 'pojisteni';

        
       

       // Nastavení šablony
        $this->pohled = 'detailpojisteni';
    
   
    }




    		
  
  

            
      

       
		
  



}