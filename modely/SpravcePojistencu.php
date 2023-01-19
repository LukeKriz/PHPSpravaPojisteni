<?php



/**
 * Třída poskytuje metody pro správu článků v redakčním systému
 */
class SpravcePojistencu
{
	

	/**
	 * Odstraní článek
	 * @param string $url URL článku k odstranění
	 * @return void
	 */
	public function odstranOsobu(string $url) : void
	{
		Db::dotaz('
			DELETE FROM pojistenci
			WHERE person_id = ?
		', array($url));
	}


	public function odstranPojisteni(string $url) : void
	{
		Db::dotaz('
			DELETE FROM pojisteni
			WHERE insurance_id = ?
		', array($url));
	}
	public function odstranEvent(string $url) : void
	{
		Db::dotaz('
			DELETE FROM udalosti
			WHERE event_id = ?
		', array($url));
	}
	
	

	public function nactiPojisteni(string $url) :array
    
	{
		return Db::dotazVsechny('
		SELECT  user_id ,insurance_id,`druh_pojisteni`,castka,predmet_pojisteni,platnost_od, platnost_do
		FROM `pojisteni`
		

		WHERE user_id=?

	',array($url));

	}





	public function nactiDetailPojisteni(string $url) :array
    
	{
		return Db::dotazjeden('
		SELECT  user_id ,insurance_id,`druh_pojisteni`,castka,predmet_pojisteni,platnost_od, platnost_do
		FROM `pojisteni`
		

		WHERE insurance_id=?

	
		
	',array($url));

	}

	public function ulozPojistence(int $id, array $osoba) : void
{
    if (!$id)
        Db::vloz('pojistenci', $osoba);
    else
        Db::zmen('pojistenci', $osoba, 'WHERE person_id = ?', array($id));
}

public function ulozPojisteni(int $id, array $pojisteni) : void
{
    if (!$id)
        Db::vloz('pojisteni', $pojisteni);
    else
        Db::zmen('pojisteni', $pojisteni, 'WHERE insurance_id = ?', array($id));
}


public function ulozEvent(int $id, array $pojisteni) : void
{
    if (!$id)
        Db::vloz('udalosti', $pojisteni);
    else
        Db::zmen('udalosti', $pojisteni, 'WHERE event_id = ?', array($id));
}


public function nactiOsobu(string $url) :array
    
	{
		return Db::dotazJeden('
		SELECT `person_id`, `name`, `surname`, `email`, `phone`, `street`,`city`,`post_code`
		FROM `pojistenci`
		

		WHERE `person_id` = ?
	', array($url));

	}





public function nactiEvent(string $url) :array
    
{
	return Db::dotazVsechny('
	SELECT event_id ,pojisteni_id,`druh_udalosti`,cena_skody,aktualni_stav,popis_skody
	FROM `udalosti`
	

	WHERE pojisteni_id=?',array($url));

}


public function nactiUdalost(string $url) :array
    
{
	return Db::dotazJeden('
	SELECT event_id ,pojisteni_id,`druh_udalosti`,cena_skody,aktualni_stav,popis_skody,vyplaceno,datum_udalosti,datum_vyplaceni
	FROM `udalosti`
	

	WHERE event_id=?',array($url));

}


public function nactiId(string $url) :array
    
{
	return Db::dotazJeden('
	SELECT  user_id ,insurance_id
	FROM `pojisteni`
	

	WHERE user_id=?


	
',array($url));

}

}