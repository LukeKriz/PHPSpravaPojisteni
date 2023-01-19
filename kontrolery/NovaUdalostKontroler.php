<?php

class NovaUdalostKontroler extends Kontroler
{
	public function zpracuj(array $parametry) : void
	{
        
		//ověření uživatele
        $this->overUzivatele();

        $spravceUzivatelu = new SpravceUzivatelu();    
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['jmeno'] = $uzivatel['jmeno'];
        $this->data['admin'] = $uzivatel['admin'];
		
		$this->pohled = 'novaudalost';
        
      
    }


    private function pridejPrispevek(int $pojisteni_id,string $druh_udalosti, string $cena_skody, string $aktualni_stav , string $popis_skody,string $datum_udalosti) : void
    {
        Db::dotaz('
            INSERT INTO `udalosti`
            (`event_id`,`pojisteni_id`,`druh_udalosti`, `cena_skody`,`aktualni_stav`, `popis_skody`,`datum_udalosti`)
            VALUES (NULL,?, ?, ?, ? , ?,?)
            
        ', array($pojisteni_id,$druh_udalosti, $cena_skody,$aktualni_stav,$popis_skody,$datum_udalosti));
    }
		
    public function pridej()
    {
        if (isset($_POST['druh_udalosti']))
        {

           
            
            
            $params=$_SERVER['REQUEST_URI'];
     
            $naparsovanaURL=parse_url($params);
            $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
            $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
            $parametry = explode("/", $naparsovanaURL["path"]);
          
          
            

                $this->pridejPrispevek($parametry[2] ,$_POST['druh_udalosti'], $_POST['cena_skody'], $_POST['aktualni_stav'], $_POST['popis_skody'],$_POST['datum_udalosti']);
                header('Location:../../detailpojisteni/'.$parametry[1].'/'.$parametry[2]);
                exit;
         
        }
        return false;
    }


    public function vypisFormular() : void
    {
        $druh_udalosti = (isset($_POST['druh_udalosti']) ? $_POST['druh_udalosti'] : '');
        $cena_skody = (isset($_POST['cena_skody']) ? $_POST['cena_skody'] : '');
        $aktualni_stav = (isset($_POST['aktualni_stav']) ? $_POST['aktualni_stav'] : '');
        $popis_skody = (isset($_POST['popis_skody']) ? $_POST['popis_skody'] : '');
        $datum_udalosti = (isset($_POST['datum_udalosti']) ? $_POST['datum_udalosti'] : '');
        


        $params=$_SERVER['REQUEST_URI'];
        
       
        $naparsovanaURL=parse_url($params);
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
        $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
        $parametry = explode("/", $naparsovanaURL["path"]);
          
    


        //nacteni parametru do tlacitka zpet

        $spravce=new SpravcePojistencu();
    
        $event=$spravce->nactiId($parametry[1]);

        $this->data['user_id']=$event['user_id'];
        $this->data['insurance_id']=$event['insurance_id'];


        //vypis
    
        
        echo('<form class="formularis2" method="post">');
        echo('<h4>Pojistná událost: </h4><br>');
        echo('<input name="druh_udalosti"  value="' . htmlspecialchars($druh_udalosti) . '"/><br>');
        echo('<h4>Škoda v Kč: </h4><br>');
        echo('<input type="number" name="cena_skody" value="' . htmlspecialchars($cena_skody) . '" /><br>');
        echo('<h4>Datum pojistné události: </h4><br>');
        echo('<input type="date" name="datum_udalosti" value="' . htmlspecialchars($datum_udalosti) . '" /><br>');
        echo('<h4>Stav: </h4><br>');
        echo('<select type="text" name="aktualni_stav" value="' . htmlspecialchars($aktualni_stav) . '">
        <option value="-">-</option>
        <option value="Probíhá">Probíhá</option>    
        <option value="Vyřešeno">Vyřešeno</option>
        <option value="Zamítnuto">Zamítnuto</option>
        
      
       
        
        </select><br>');
        echo('<h4>Popis pojistné události: </h4><br>');
        echo('<textarea type="text" name="popis_skody" value="' . htmlspecialchars($popis_skody) . '"></textarea><br>');
        echo('</div>');
        
           
           echo('<div class="tlacitka"">');
           echo('<a style="margin-right:0.1rem" class="pojistenec" href="detailpojisteni/' .  $event['user_id'] . '/'.$event['insurance_id'].'">Zpět</a>');
            echo('<input type="submit" />');
            echo('</ div>');
        echo('</form>');
    }


        public function vypis() : void
        {  
            $this->vypisFormular();
           
        }
}