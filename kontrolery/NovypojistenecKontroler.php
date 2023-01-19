<?php

class NovypojistenecKontroler extends Kontroler
{
	public function zpracuj(array $parametry) : void
	{
        
		//ověření uživatele
        $this->overUzivatele();

        $spravceUzivatelu = new SpravceUzivatelu();    
        $uzivatel = $spravceUzivatelu->vratUzivatele();
        $this->data['jmeno'] = $uzivatel['jmeno'];
        $this->data['admin'] = $uzivatel['admin'];
		
		$this->pohled = 'novypojistenec';
    }


    private function pridejPrispevek(string $name, string $surname, string $email, string $phone, string $street, string $city, string $postcode) : void
    {
        Db::dotaz('
            INSERT INTO `pojistenci`
            (`person_id`,`name`, `surname`, `email`, `phone`, `street`, `city`, `post_code`)
            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)
        ', array($name, $surname,$email,$phone,$street,$city,$postcode));
    }
		
    public function pridej()
    {
        if (isset($_POST['name']))
        {
        
                $this->pridejPrispevek($_POST['name'], $_POST['surname'], $_POST['email'], $_POST['phone'], $_POST['street'], $_POST['city'], $_POST['post_code']);
                header('Location:pojisteni');
                exit;
         
        }
        return false;
    }


    public function vypisFormular() : void
    {
        $name = (isset($_POST['name']) ? $_POST['name'] : '');
        $surname = (isset($_POST['surname']) ? $_POST['surname'] : '');
        $email = (isset($_POST['email']) ? $_POST['email'] : '');
        $phone = (isset($_POST['phone']) ? $_POST['phone'] : '');
        $street = (isset($_POST['street']) ? $_POST['street'] : '');
        $city = (isset($_POST['city']) ? $_POST['city'] : '');
        $postcode = (isset($_POST['post_code']) ? $_POST['post_code'] : '');
       
    

        
        echo('<form method="post"><div class="formularis"><div>');
        
            echo('<h4>Jméno: </h4><br>');
            echo('<input type="text" name="name" value="' . htmlspecialchars($name) . '" /><br>');
            echo('<h4>Příjmení: </h4><br>');
            echo('<input type="text" name="surname" value="' . htmlspecialchars($surname) . '" /><br>');
            echo('<h4>Email: </h4><br>');
            echo('<input type="email" name="email" value="' . htmlspecialchars($email) . '" /><br>');
            echo('<h4>Telefon: </h4><br>');
            echo('<input type="phone" name="phone" value="' . htmlspecialchars($phone) . '" /><br></div>');
            echo('<div><h4>Ulice a č.p.: </h4><br>');
            echo('<input type="text" name="street" value="' . htmlspecialchars($street) . '" /><br>');
            echo('<h4>Město/Obec: </h4><br>');
            echo('<input type="text" name="city" value="' . htmlspecialchars($city) . '" /><br>');
            echo('<h4>PSČ: </h4><br>');
            echo('<input type="text" name="post_code" value="' . htmlspecialchars($postcode) . '" /><br></div></div>');

           
           echo('<div class="tlacitka"">');
           echo('<a style="margin-right:0.1rem" class="pojistenec" href="pojisteni">Zpět</a>');
            echo('<input type="submit" />');
            echo('</ div>');
        echo('</form>');
    }


        public function vypis() : void
        {  
            $this->vypisFormular();
           
        }
}