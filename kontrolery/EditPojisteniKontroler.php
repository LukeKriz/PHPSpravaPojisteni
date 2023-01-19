<?php
class EditPojisteniKontroler extends Kontroler
{
    public function zpracuj(array $parametry) : void
    {
        //ověření uživatele
         $this->overUzivatele();
        // Vytvoření instance modelu
        $spravcePojisteni = new SpravcePojistencu();
        // Příprava prázdného článku
        $pojisteni= array(
            
            'druh_pojisteni' => '',
            'castka' => '',
            'predmet_pojisteni' => '',
            'platnost_od' => '',
            'platnost_do' => '',
          
        );
       
           // Je odeslán formulář
           if ($_POST)
           {
   
               // Získání článku z $_POST
               $detail = array('druh_pojisteni', 'castka', 'predmet_pojisteni', 'platnost_od', 'platnost_do');
               $pojisteni = array_intersect_key($_POST, array_flip($detail));
               // Uložení článku do DB
               $spravcePojisteni->ulozPojisteni($parametry[1], $pojisteni);
               
               $this->presmeruj('detailpojisteni/' . $parametry[0].'/'.$parametry[1]);
           }
          
           else if (!empty($parametry[0]))
           {
               $nactenePojisteni = $spravcePojisteni->nactiDetailPojisteni($parametry[1]);
               if ($nactenePojisteni)
                   $pojisteni = $nactenePojisteni;
               else
                   $this->pridejZpravu('Osoba nebyla nalezena');
           }
   
           $this->data['pojisteni'] = $pojisteni;


           $spravceUzivatelu = new SpravceUzivatelu();    
           $uzivatel = $spravceUzivatelu->vratUzivatele();
           $this->data['jmeno'] = $uzivatel['jmeno'];
           $this->data['admin'] = $uzivatel['admin'];
   
           $this->pohled = 'editpojisteni';








        
    }
}

       


