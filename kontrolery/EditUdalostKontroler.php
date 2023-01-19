<?php
class EditUdalostKontroler extends Kontroler
{
    public function zpracuj(array $parametry) : void
    {
       
        //ověření uživatele
         $this->overUzivatele();
        // Vytvoření instance modelu
        $spravcePojisteni = new SpravcePojistencu();
        // Příprava prázdného článku
        $udalost= array(
            
            'druh_udalosti' => '',
            'cena_skody' => '',
            'aktualni_stav' => '',
            'popis_skody' => '',
            'vyplaceno' => '',
            'datum_udalosti' => '',
            'datum_vyplaceni' => '',
            
          
        );
       
           // Je odeslán formulář
           if ($_POST)
           {
   
               // Získání článku z $_POST
               $detail = array('druh_udalosti', 'cena_skody', 'aktualni_stav', 'popis_skody', 'vyplaceno', 'datum_udalosti', 'datum_vyplaceni');
               $udalost = array_intersect_key($_POST, array_flip($detail));
               // Uložení článku do DB
               $spravcePojisteni->ulozEvent($parametry[2], $udalost);
               
               $this->presmeruj('detailudalosti/' . $parametry[0].'/'.$parametry[1].'/'.$parametry[2]);
           }
          
           else if (!empty($parametry[1]))
           {
               $nactenaudalost = $spravcePojisteni->nactiUdalost($parametry[2]);
               if ($nactenaudalost)
                   $udalost = $nactenaudalost;
               else
                   $this->pridejZpravu('Osoba nebyla nalezena');
           }
           $zpet=$parametry[0].'/'.$parametry[1].'/'.$parametry[2];
           $this->data['udalost'] = $udalost;
           $this->data['zpet']=$zpet;

           $spravceUzivatelu = new SpravceUzivatelu();    
           $uzivatel = $spravceUzivatelu->vratUzivatele();
           $this->data['jmeno'] = $uzivatel['jmeno'];
           $this->data['admin'] = $uzivatel['admin'];
   
           $this->pohled = 'editudalost';


           





        
    }
}

       


