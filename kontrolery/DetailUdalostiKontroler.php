<?php

class DetailUdalostiKontroler extends Kontroler
{
	public function zpracuj(array $parametry) : void
	{
        //ověření uživatele
        $this->overUzivatele();
       // Vytvoření instance modelu, který nám umožní pracovat s články
       $spravceOsob = new SpravcePojistencu();
      
    
     
           
       
       if (!empty($parametry[0])){


            // Získání článku podle URL
        $event = $spravceOsob->nactiUdalost($parametry[2]);
      //  $osoba = $spravceOsob->nactiDetailPojisteni($parametry[0]);
        $osoba = $spravceOsob->nactiDetailPojisteni($parametry[1]);   

            // Pokud nebyl článek s danou URL nalezen, přesměrujeme na ChybaKontroler
       if (!$event)
           $this->presmeruj('chyba');
        
       

       // Naplnění proměnných pro šablonu
      $this->data['event_id'] = $event['event_id'];
       $this->data['druh_udalosti'] = $event['druh_udalosti'];
       $this->data['cena_skody'] = $event['cena_skody'];
       $this->data['aktualni_stav'] = $event['aktualni_stav'];
       $this->data['popis_skody'] = $event['popis_skody'];
       $this->data['vyplaceno'] = $event['vyplaceno'];
       
       $this->data['insurance_id'] = $osoba['insurance_id'];
       $this->data['user_id'] = $osoba['user_id'];

       $spravceUzivatelu = new SpravceUzivatelu();    
       $uzivatel = $spravceUzivatelu->vratUzivatele();
       $this->data['jmeno'] = $uzivatel['jmeno'];
       $this->data['admin'] = $uzivatel['admin'];



       //zmena a nacteni data
       $event['datum_udalosti']=mb_substr($event['datum_udalosti'], 8, 2).'. '.mb_substr($event['datum_udalosti'], 5, 2.). '. '.mb_substr($event['datum_udalosti'], 0, 4.);
      
       $this->data['datum_udalosti'] = $event['datum_udalosti'];
       
       
       
       
      


       $event['datum_vyplaceni']=mb_substr($event['datum_vyplaceni'], 8, 2).'. '.mb_substr($event['datum_vyplaceni'], 5, 2.). '. '.mb_substr($event['datum_vyplaceni'], 0, 4.);
       if($event['datum_vyplaceni']=="00. 00. 0000"){
         $event['datum_vyplaceni']="Vypiš při vyplácení";}

       $this->data['datum_vyplaceni'] = $event['datum_vyplaceni'];

          // Nastavení šablony
          $this->pohled = 'detailudalosti';      
       
       
 
    }

    
       
     

    
   
    }




    		
    private function vypisPrispevky() : void
        {


            $params=$_SERVER['REQUEST_URI'];
        
       
            $naparsovanaURL=parse_url($params);
                $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
                $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
                $parametry = explode("/", $naparsovanaURL["path"]);
            
            $params=$_SERVER['REQUEST_URI'];
            
            $url=$parametry[1].'/'.$parametry[2];

           $load = new SpravcePojistencu();
           $loading = $load->nactiEvent($parametry[2]);
            
           $spravceUzivatelu = new SpravceUzivatelu();    
           $uzivatel = $spravceUzivatelu->vratUzivatele();
          
           $this->data['admin'] = $uzivatel['admin'];
           echo('<thead><tr">');
           echo('<th>Pojistná událost</th>');
           echo('<th class="hide_470">Škoda</th>');
           echo('<th>Stav</th>');
           if ($uzivatel['admin']){
           echo('<th class="hide_470">Upravit / Smazat:</th>');}
           echo('</tr></thead>');

           
            foreach ($loading as $prispevek)
            {    
                $reseni=htmlspecialchars($prispevek['aktualni_stav']);
                $pozitivniodpoved="Vyřešeno";
                $negativniodpoved="Zamítnuto";
              
               
                
                echo('<tbody><tr>');
                echo('<td><a class="odkaz" href="detailudalosti/'.$url.'/'.htmlspecialchars($prispevek['event_id']).'">'.htmlspecialchars($prispevek['druh_udalosti']).'</a></td>');
                echo('<td class="hide_470">'.htmlspecialchars($prispevek['cena_skody']).' Kč</td>');
                
       // vypis barev podle stavu
                if($reseni==$pozitivniodpoved){
                    echo('<td class="zeleny">'.htmlspecialchars($prispevek['aktualni_stav']).'</td>');

                }else if($reseni==$negativniodpoved){
                    echo('<td class="cerveny">'.htmlspecialchars($prispevek['aktualni_stav']).'</td>');
                }else{echo('<td class="oranzovy">'.htmlspecialchars($prispevek['aktualni_stav']).'</td>');}
               
                
                    
                if ($uzivatel['admin']){
                echo('<td class="hide_470">');
             
                echo('<a style="text-decoration:none; margin-right:0.3rem" href="editudalost/'.$url.'/'.htmlspecialchars($prispevek['event_id']).'"><i id="tuzka" class="fas fa-pencil-alt"></i></a>'); 
                echo ('<a style="text-decoration:none;margin-left:0.3rem" href="detailpojisteni/'.$url.'/'.htmlspecialchars($prispevek['event_id']).'/smazat"><i id="kos"  class="far fa-trash-alt"></i></a></td>');
           
                echo('</td>');}
                echo('</tr></tbody>');
            }
           
        }

        public function vypis() : void
        {  
            $this->vypisPrispevky();
           
        }
  

            
      

       
		
  



}