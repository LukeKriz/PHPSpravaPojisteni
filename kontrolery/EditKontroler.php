<?php
class EditKontroler extends Kontroler
{
    public function zpracuj(array $parametry) : void
    {
       //ověření uživatele
       $this->overUzivatele();
        // Vytvoření instance modelu
        $spravceOsob = new SpravcePojistencu();
        // Příprava prázdného článku
        $osoba= array(
            
            'name' => '',
            'surname' => '',
            'email' => '',
            'phone' => '',
            'street' => '',
            'city' => '',
            'post_code' => '',
        );
        if ($_POST)
        {

            // Získání článku z $_POST
            $detail = array('name','surname','email', 'phone', 'street','city','post_code');
            $osoba = array_intersect_key($_POST, array_flip($detail));
            // Uložení článku do DB
            $spravceOsob->ulozPojistence($parametry[0], $osoba);
            
            $this->presmeruj('detail/' . $parametry[0]);
        }
       
        else if (!empty($parametry[0]))
        {
            $nactenaOsoba = $spravceOsob->nactiOsobu($parametry[0]);
            if ($nactenaOsoba)
                $osoba = $nactenaOsoba;
            else
                $this->pridejZpravu('Osoba nebyla nalezena');
        }

        $this->data['osoba'] = $osoba;

        $spravceUzivatelu = new SpravceUzivatelu();    
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['jmeno'] = $uzivatel['jmeno'];
        $this->data['admin'] = $uzivatel['admin'];

        $this->pohled = 'edit';
    }
}

       


