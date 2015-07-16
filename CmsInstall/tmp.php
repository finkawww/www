<?php
include '../Includes/application.inc.php';

error_reporting(E_ALL); 
ini_set('display_errors',1); 

$DBInt = DBSingleton::getInstance();

//- wypelniam tabele wartosciami domyslnymi - Languages, cmsUsers (login Admin, haslo Admin)
 
	echo 'Wypełniam tabelę cmsLang<br />';
	$dmlMenu = 'UPDATE GrupyOfert SET nazwa="Księgi handlowe" 
				where id=3';
	$DBInt -> ExecQuery($dmlMenu);
	$dmlMenu = 'UPDATE GrupyOfert SET opis=\'<div class="font"><b>Finka-FK</b><br> Program przeznaczony jest dla: biur rachunkowych, małych i średnich przedsiębiorstw, dla fundacji i stowarzyszeń, a także dla kół łowieckich.\' 
				where id=3';
	$DBInt -> ExecQuery($dmlMenu);
	

	
	
	$dmlMenu = 'UPDATE GrupyOfert SET nazwa="Kadry i place" 
				where id=4';
	$DBInt -> ExecQuery($dmlMenu);
	$dmlMenu = 'UPDATE GrupyOfert SET opis=\'<div class="font"> <b>Finka-PLA</b><br> Finka-PŁACE - mimo znacznego skomplikowania przepisów podatkowych i ZUS-owskich jest łatwym w obsłudze i elastycznym programem.\' 
				where id=4';
	$DBInt -> ExecQuery($dmlMenu);
	
	
	$dmlMenu = 'UPDATE GrupyOfert SET nazwa="Księga przychodów i rozchodów / Ryczałt" 
				where id=5';
	$DBInt -> ExecQuery($dmlMenu);
	$dmlMenu = 'UPDATE GrupyOfert SET opis=\'<div class="font"><b> Finka-KPR/RYCZAŁT</b> <br>Finka-KPR jest wygodnym narzędziem do prowadzenia księgi przychodów i rozchodów oraz do rozliczania ryczałtu w firmach o dowolnym profilu działalności.\' 
				where id=5';
	$DBInt -> ExecQuery($dmlMenu);
	
	
	
	$dmlMenu = 'UPDATE GrupyOfert SET nazwa="Ewidencja środkow trwałych" 
				where id=6';
	$DBInt -> ExecQuery($dmlMenu);
	$dmlMenu = 'UPDATE GrupyOfert SET opis=\'<b>Finka-STW</b><br> Finka-STW jest programem przeznaczonym do ewidencji środków trwałych.\' 
				where id=6';
	$DBInt -> ExecQuery($dmlMenu);
	
	
	
	$dmlMenu = 'UPDATE GrupyOfert SET nazwa="Gospodarka magazynowa" 
				where id=7';
	$DBInt -> ExecQuery($dmlMenu);
	$dmlMenu = 'UPDATE GrupyOfert SET opis=\'<div class="font"> <b>Finka-MAG</b><br> Finka-MAG jest aplikacją przeznaczoną do prowadzenia gospodarki magazynowej w firmach z sektora MŚP. \' 
				where id=7';
	$DBInt -> ExecQuery($dmlMenu);
	
	
	
	$dmlMenu = 'UPDATE GrupyOfert SET nazwa="Sprzedaż i fakturowanie" 
				where id=8';
	$DBInt -> ExecQuery($dmlMenu);
	$dmlMenu = 'UPDATE GrupyOfert SET opis=\'<div class="font"><b>Finka-FAKTURA</b><br> Sprzedaż i fakturowanie w najlepszym wydaniu, zarówno dla mikro firm, jak i dla dużych przedsiębiorstw.\' 
				where id=8';
	$DBInt -> ExecQuery($dmlMenu);
	
	echo '-->OK<br />';


