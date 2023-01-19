<?php


class Db {



	

		private static PDO $spojeni;
	
		private static $nastaveni = Array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
			PDO::ATTR_EMULATE_PREPARES => false,
		);
	
		public static function pripoj(string $host, string $uzivatel, string $heslo, string $databaze) : PDO
		{
			if (!isset(self::$spojeni)) {
				self::$spojeni = @new PDO(
					"mysql:host=$host;dbname=$databaze",
					$uzivatel,
					$heslo,
					self::$nastaveni
				);
			}
			return self::$spojeni;
		}
	
		public static function dotaz(string $sql, array $parametry = array()) : PDOStatement
		{
			$navrat = self::$spojeni->prepare($sql);
			$navrat->execute($parametry);
			return $navrat;
		}


		public static function dotazJeden(string $dotaz, array $parametry = array()) : array|bool
		{
			$navrat = self::$spojeni->prepare($dotaz);
			$navrat->execute($parametry);
			return $navrat->fetch();
		}


		

		public static function dotazVsechny(string $dotaz, array $parametry = array()) : array|bool
		{
			$navrat = self::$spojeni->prepare($dotaz);
			$navrat->execute($parametry);
			return $navrat->fetchAll();
		}



		public static function dotazSamotny(string $dotaz, array $parametry = array()) : array|bool
{
    $vysledek = self::dotazJeden($dotaz, $parametry);
    return $vysledek[0];
}


		public static function vloz(string $tabulka, array $parametry = array()) 
		{
			return self::dotaz("INSERT INTO `$tabulka` (`".
			implode('`, `', array_keys($parametry)).
			"`) VALUES (".str_repeat('?,', sizeOf($parametry)-1)."?)",
				array_values($parametry));
		}
	
		/**
		 * Změní řádek v tabulce tak, aby obsahoval data z asociativního pole
		 * @param string $tabulka Název databázové tabulky
		 * @param array $hodnoty Asociativní pole hodnot ke změně
		 * @param $podminka Podmínka pro ovlivňované záznamy ("WHERE ...")
		 * @param array $parametry Asociativní pole dalších parametrů
		 * @return bool TRUE v případě úspěšného provedení dotazu
		 */
		public static function zmen(string $tabulka, array $hodnoty = array(), string $podminka, array $parametry = array()) 
		{
			return self::dotaz("UPDATE `$tabulka` SET `".
			implode('` = ?, `', array_keys($hodnoty)).
			"` = ? " . $podminka,
			array_merge(array_values($hodnoty), $parametry));
		}
		
		/**
		 * Vrací ID posledně vloženého záznamu
		 * @return int ID posledního vloženého záznamu
		 */
		public static function posledniId() : int
		{
			return self::$spojeni->lastInsertId();
		}
	

}