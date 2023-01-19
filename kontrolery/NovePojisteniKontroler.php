<?php

class NovePojisteniKontroler extends Kontroler
{
	public function zpracuj(array $parametry) : void
	{
        
		//ověření uživatele
        $this->overUzivatele();

        $spravceUzivatelu = new SpravceUzivatelu();    
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['jmeno'] = $uzivatel['jmeno'];
        $this->data['admin'] = $uzivatel['admin'];
		
		$this->pohled = 'novepojisteni';
    }


    private function pridejPojistku(int $user_id, string $druh_pojisteni, int $castka, string $predmet_pojisteni, string $platnost_od, string $platnost_do) : void
    {
        Db::dotaz('
            INSERT INTO `pojisteni`
            (`insurance_id`,`user_id`,`druh_pojisteni`, `castka`, `predmet_pojisteni`, `platnost_od`, `platnost_do`)
            VALUES (NULL, ?, ?, ?, ?, ?, ?)
           
        ', array($user_id, $druh_pojisteni,$castka,$predmet_pojisteni,$platnost_od,$platnost_do));
    }
		
    public function pridej()
    {
        if (isset($_POST['druh_pojisteni']))
        {   
            $params=$_SERVER['REQUEST_URI'];
        
       
            $naparsovanaURL=parse_url($params);
            $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
            $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
            $parametry = explode("/", $naparsovanaURL["path"]);
                
                $this->pridejPojistku($parametry[1] , $_POST['druh_pojisteni'], $_POST['castka'], $_POST['predmet_pojisteni'], $_POST['platnost_od'], $_POST['platnost_do']);
                header('Location:../detail/'.$parametry[1]);
                exit;
         
        }
        return false;
    }


    public function vypisFormular() : void
    {
        $druh_pojisteni = (isset($_POST['druh_pojisteni']) ? $_POST['druh_pojisteni'] : '');
        $castka = (isset($_POST['castka']) ? $_POST['castka'] : '');
        $predmet_pojisteni = (isset($_POST['predmet_pojisteni']) ? $_POST['predmet_pojisteni'] : '');
        $platnost_od = (isset($_POST['platnost_od']) ? $_POST['platnost_od'] : '');
        $platnost_do = (isset($_POST['platnost_do']) ? $_POST['platnost_do'] : '');
 
        $params=$_SERVER['REQUEST_URI'];
        
        $naparsovanaURL=parse_url($params);
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
        $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
        $parametry = explode("/", $naparsovanaURL["path"]);
        $param=$parametry[1];
        
        
        echo('<form method="post"><div class="formularis"><div>');
            echo('<h4>Druh pojištění: </h4><br>');
            echo('<select name="druh_pojisteni"  value="' . htmlspecialchars($druh_pojisteni) . '">
            <option value="-">-</option>
            <option value="Pojištění majetku">Pojištění majetku</option>
            <option value="Povinné ručení">Povinné ručení</option>
            <option value="Úrazové pojištění">Úrazové pojištění</option>
            <option value="Cestovní pojištění">Cestovní pojištění</option>
            <option value="Havarijní pojištění">Havarijní pojištění</option>
            <option value="Pojištění odpovědnosti za škodu">Pojištění odpovědnosti za škodu</option>
            

        </select><br>');
            echo('<h4>Částka v Kč: </h4><br>');
            echo('<input type="number" name="castka" value="' . htmlspecialchars($castka) . '" /><br>');
            echo('<h4>Předmět pojištění: </h4><br>');
            echo('<select type="text" name="predmet_pojisteni" value="' . htmlspecialchars($predmet_pojisteni) . '">
            <option value="-">-</option>
            <option value="Automobil">Automobil</option>
            <option value="Domácí mazličci">Domácí mazličci</option>
            <option value="Dům">Dům</option>
            <option value="Osoba">Osoba</option>
            <option value="Průmyslový objekt">Průmyslový objekt</option>
           
            
            </select><br></div>');
            echo('<div><h4>Platnost od: </h4><br>');
            echo('<input type="date" name="platnost_od" value="' . htmlspecialchars($platnost_od) . '" /><br>');
            echo('<h4>Platnost do:: </h4><br>');
            echo('<input type="date" name="platnost_do" value="' . htmlspecialchars($platnost_do) . '" /><br></div></div>');
          

    
           
            echo('<div class="tlacitka">');
            echo('<a style="margin-right:0.1rem" class="pojistenec" href="detail/'.$param.'">Zpět</a>');
             echo('<input type="submit" />');
             echo('</ div>');
        echo('</form>');
    }


        public function vypis() : void
        {  
            $this->vypisFormular();
           
        }
}