<?php

class DetailKontroler extends Kontroler
{
	public function zpracuj(array $parametry) : void
	{
        //ověření uživatele
        $this->overUzivatele();
       // Vytvoření instance modelu, který nám umožní pracovat s články
       $spravceOsob = new SpravcePojistencu();
      
      
       // Je zadáno URL článku ke smazání
       if (!empty($parametry[2]) && $parametry[2] == 'smazat')
               {   
                   $spravceOsob->odstranpojisteni($parametry[1]);
                   
                 };
                
           
           $this->pohled = 'pojisteni';
       
       if (!empty($parametry[0])){


            // Získání článku podle URL
            $osoba = $spravceOsob->nactiOsobu($parametry[0]);
          
           

            // Pokud nebyl článek s danou URL nalezen, přesměrujeme na ChybaKontroler
       if (!$osoba)
           $this->presmeruj('chyba');

       

       // Naplnění proměnných pro šablonu
      $this->data['person_id'] = $osoba['person_id'];
       $this->data['name'] = $osoba['name'];
       $this->data['surname'] = $osoba['surname'];
       $this->data['email'] = $osoba['email'];
       $this->data['phone'] = $osoba['phone'];
       $this->data['street'] = $osoba['street'];
       $this->data['city'] = $osoba['city'];
       $this->data['post_code'] = $osoba['post_code'];


       $spravceUzivatelu = new SpravceUzivatelu();    
       $uzivatel = $spravceUzivatelu->vratUzivatele();
       $this->data['jmeno'] = $uzivatel['jmeno'];
       $this->data['admin'] = $uzivatel['admin'];
       

       
       
        // Nastavení šablony
        $this->pohled = 'detail';}

    
       
       

        
       

    
   
    }




    		
    private function vypisPrispevky() : void
        {
            //nacteni a naparsovani adresy
            $params=$_SERVER['REQUEST_URI'];
        
       
            $naparsovanaURL=parse_url($params);
            $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
            $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
            $parametry = explode("/", $naparsovanaURL["path"]);
           
           $load = new SpravcePojistencu();
           $loading = $load->nactiPojisteni($parametry[1]);


           $spravceUzivatelu = new SpravceUzivatelu();    
           $uzivatel = $spravceUzivatelu->vratUzivatele();
          
           $this->data['admin'] = $uzivatel['admin'];
           echo('<thead><tr">');
           echo('<th>Pojištění<span class="hide"> - Předmět pojištění:</span></th>');
           echo('<th>Platné do:</th>');
           if ($uzivatel['admin']){
           echo('<th class="hide_470">Upravit / Smazat:</th>');}
           echo('</tr></thead>');


            foreach ($loading as $prispevek)
            {  $prispevek['platnost_do']=mb_substr($prispevek['platnost_do'], 8, 2).'. '.mb_substr($prispevek['platnost_do'], 5, 2.). '. '.mb_substr($prispevek['platnost_do'], 0, 4.);


                $pole=explode(" ",htmlspecialchars($prispevek['platnost_do']));
                $platnost=implode("",$pole);
                
                echo('<tbody><tr>');
                echo('<td><a class="odkaz" href="detailpojisteni/'.htmlspecialchars($prispevek['user_id']).'/'.htmlspecialchars($prispevek['insurance_id']).'">'.htmlspecialchars($prispevek['druh_pojisteni']).'<span class="hide"> - '.htmlspecialchars($prispevek['predmet_pojisteni']).'</a></span></td>');
                echo('<td>'.$platnost.'</td>');
                if ($uzivatel['admin']){
                echo('<td class="hide_470">');
                
                echo('<a style="text-decoration:none; margin-right:0.3rem" href="editpojisteni/'.htmlspecialchars($prispevek['user_id']).'/'.htmlspecialchars($prispevek['insurance_id']).'"><i id="tuzka" class="fas fa-pencil-alt"></i></a>'); 
                echo ('<a style="text-decoration:none;margin-left:0.3rem" href="detail/'. htmlspecialchars($prispevek['user_id']) .'/'.htmlspecialchars($prispevek['insurance_id']).'/smazat"><i id="kos" class="far fa-trash-alt"></i></a></td>');
                
                echo('</td>');}
                echo('</tr></tbody>');
            }
           
        }

        public function vypis() : void
        {  
            $this->vypisPrispevky();
           
        }
  

            
      

       
		
  



}