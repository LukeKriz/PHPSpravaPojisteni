<?php

class PojisteniKontroler extends Kontroler
{
	public function zpracuj(array $parametry) : void
	{

        //ověření uživatele
        $this->overUzivatele();

     // načtení instance   
        $spravceClanku = new SpravcePojistencu();
	// Je zadáno URL článku ke smazání
    if (!empty($parametry[1]) && $parametry[1] == 'smazat')
            {   
                $spravceClanku->odstranOsobu($parametry[0]);
                
              };
      
              
    
        $spravceUzivatelu = new SpravceUzivatelu();    
        $uzivatel = $spravceUzivatelu->vratUzivatele();
       
        $this->data['admin'] = $uzivatel['admin'];
		
		$this->pohled = 'pojisteni';
    }



    private function vyberPrispevky() : array
        {
            $name = Db::dotaz('
                SELECT person_id, name ,surname, street, city, email, phone
                FROM `pojistenci`
               
                LIMIT 30
            ');
            return $name->fetchAll();
        }

        
		
    private function vypisPrispevky() : void
        {

            $spravceUzivatelu = new SpravceUzivatelu();    
            $uzivatel = $spravceUzivatelu->vratUzivatele();
           
            $this->data['admin'] = $uzivatel['admin'];
      
            
            echo('<table>');
          
            echo('<thead><tr">');
            echo('<th>Jméno a příjmení</th>');
            echo('<th><span class="hide">Email&nbsp&nbsp&nbsp&nbsp/&nbsp&nbsp&nbsp</span>Telefon:</th>');
            if ($uzivatel['admin']){
            echo('<th class="hide_470">Upravit / Smazat:</th>');}
            echo('</tr></thead>');
            
           
            $prispevky = $this->vyberPrispevky();
            foreach ($prispevky as $prispevek)
            {   

                $pole=explode(" ",htmlspecialchars($prispevek['phone']));
                $phone = implode("",$pole);
                echo('<tbody><tr>');
                echo('<td><a class="odkaz" href="detail/' . htmlspecialchars($prispevek['person_id']) . '">' .  htmlspecialchars($prispevek['name']) .' '. htmlspecialchars($prispevek['surname']) . '</a><br></td>');
                echo('<td><span class="hide"><a class="odkaz" href="mailto:'. htmlspecialchars($prispevek['email']).'" type="email">'. htmlspecialchars($prispevek['email']).'</a>&nbsp&nbsp&nbsp&nbsp/&nbsp&nbsp&nbsp </span><a class="odkaz" href="tel:'. $phone.'" type="email">'. $phone.'</a></td>');
                if ($uzivatel['admin']){
                echo ('<td class="hide_470">');
                
                echo ('<a style="text-decoration:none; margin-right:0.3rem" href="edit/'.htmlspecialchars($prispevek['person_id']).'"><i id="tuzka" class="fas fa-pencil-alt" ></i></a>'); 
                echo ('<a style="text-decoration:none;margin-left:0.3rem" href="pojisteni/'.htmlspecialchars($prispevek['person_id']).'/smazat"><i id="kos" class="far fa-trash-alt" ></i></a>');
                
                echo ('</td>');
            }
                echo('</tr></tbody>');
                
             
            }
            echo('</table><br />');
        }

        public function vypis() : void
        {  
            $this->vypisPrispevky();
           
        }
}