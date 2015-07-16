<?php
//controller includes
require_once rootPath.'/Modules/Sklep/SklepClass/PrzegladanieOferty.class.php';
require_once rootPath.'/Modules/Sklep/SklepClass/SkladanieZamowienia.class.php';
require_once rootPath.'/Modules/Sklep/SklepClass/ZarzadzanieKontem.class.php';

//model includes
require_once rootPath.'/Modules/Sklep/SklepClass/DostawaModel/Dostawa.php';
require_once rootPath.'/Modules/Sklep/SklepClass/KlientModel/Klient.php';
require_once rootPath.'/Modules/Sklep/SklepClass/OfertaModel/Oferta.php';
require_once rootPath.'/Modules/Sklep/SklepClass/GrupaOfertModel/GrupaOfert.php';
require_once rootPath.'/Modules/Sklep/SklepClass/PlatnoscModel/Platnosc.php';
require_once rootPath.'/Modules/Sklep/SklepClass/TowarModel/Towar.php';
require_once rootPath.'/Modules/Sklep/SklepClass/RabatModel/Rabat.php';
require_once rootPath.'/Modules/Sklep/SklepClass/ZamowienieModel/Zamowienie.php';
require_once rootPath.'/Modules/Sklep/SklepClass/Konfiguracja/Konfiguracja.php';
require_once rootPath.'/Modules/Sklep/SklepClass/PlatnosciPL/PlatnosciPL.php';

//View includes
//require_once rootPath.'/Modules/Sklep/SklepClass/DostawaView/DostawaView.php';
require_once rootPath.'/Modules/Sklep/SklepClass/KlientView/KlientView.php';
require_once rootPath.'/Modules/Sklep/SklepClass/OfertaView/OfertaView.php';
//require_once rootPath.'/Modules/Sklep/SklepClass/PlatnoscView/PlatnoscView.php';
require_once rootPath.'/Modules/Sklep/SklepClass/TowarView/TowarView.php';
require_once rootPath.'/Modules/Sklep/SklepClass/ZamowienieView/ZamowienieView.php';
require_once rootPath.'/Modules/Sklep/SklepClass/GrupaOfertView/GrupaOfertView.php';
require_once rootPath.'/Modules/Sklep/SklepClass/RabatView/RabatView.php';
//other classes
require_once rootPath.'/Modules/Sklep/SklepClass/Kontakt/Kontakt.php';
require_once rootPath.'/Modules/Sklep/SklepClass/Kontakt/KontaktKreator.php';
require_once rootPath.'/Modules/Sklep/SklepClass/KontaktOperator/KontaktOperator.php';
?>