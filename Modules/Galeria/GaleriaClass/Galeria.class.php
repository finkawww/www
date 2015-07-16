<?php

/*
 * Klasa galeria - klasa g��wna
 * Klasa Grupy - klasa
 * klasa Realizacje
 * klasa Zdjecia
 * 
 */



 class Zdjecie
 {
 	private $url;
 	public function GetUrlById($id)
 	{
 		
 	}
 	 
 }
 
 class Realizacja
 {
 	private $id;
	private $galeriaId;
	private $opis;
	private $kolejnosc;
	private $slowa_kluczowe;
	private $priorytet;
 	private $DBInt;
 	
 	public function __construct()
 	{
 		$this->DBInt = DBSingleton::GetInstance();	
 	}
 	public function GetOpis()
 	{
 		
 	}
 	public function GetKolejnosc()
 	{
 		
 	}
 	public function GetPriorytet()
 	{
 		
 	}
 	//pokazuje  pojedyncza realizacj�
 	public function ShowRealizacja($realiazacjaId)
 	{
 		$res .= '
 			<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
	
			<script src="js/prototype.js" type="text/javascript"></script>
			<script src="js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
			<script src="js/lightbox.js" type="text/javascript"></script>
 			';
 		
 	}
 	//pokazuje realizacje galerii
 	public function ShowGallery($galeriaId)
 	{
 	
 	$res = '';
 		//pobiersez miniatury realizacji
 		$res .= '
 			<link rel="stylesheet" href="http://www.murmur.h2.pl/FrontPage/JS/css/lightbox.css" type="text/css" media="screen" />
	
			<script src="http://www.murmur.h2.pl/FrontPage/JS/js/prototype.js" type="text/javascript"></script>
			<script src="http://www.murmur.h2.pl/FrontPage/JS/js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
			<script src="http://www.murmur.h2.pl/FrontPage/JS/js/lightbox.js" type="text/javascript"></script>
 			';
 
 	
 		$sql = "SELECT 
 					R.id,
 					R.Nazwa,
 					R.opis,
 					Miniatury.URL as MiniaturaURL, 
 					Pelne.URL as PelneURL
 					 
 				FROM 
 					ZDJECIA AS Miniatury 
 					INNER JOIN REALIZACJE R ON Miniatury.REALIZACJAID = R.ID
 					INNER JOIN ZDJECIA AS Pelne ON Miniatury.Id = Pelne.IdMiniatury 
 				WHERE
 					Miniatury.MINIATURA = 1 AND R.galeriaID=$galeriaId
 				ORDER BY R.KOLEJNOSC, R.Nazwa, Miniatury.kolejnosc
 				";
 		
 		$result = $this->DBInt->ExecQuery($sql);
 		$countZdjReal = 0;
 		$prevIdReal = 0;
 		while ($data = $result->fetchRow(DB_FETCHMODE_ASSOC))
		{
			
			$urlMiniatury = $data['MiniaturaURL'];
			$urlFull = $data['PelneURL'];
			$idReal = $data['id'];
			$opis = $data['opis'];
			if ($idReal == $prevIdReal)
			{
				$countZdjReal++;
			} 
			else
			{
				$countZdjReal = 0;
				$res.='<br/>';
			}
			$moduleTmp = new ModulesMgr();
			$moduleTmp->loadModule('Galeria');
			$realAct = $moduleTmp->getModuleActionIdByName('ShowRealizacja');			
			
			/*$res .= "<a href=?a=$realAct&real=$idReal rel=\"lightbox\">
						<img src=\"$urlMiniatury\" width=\"100\" height=\"40\" alt=\"\" />
					</a>";*/
			if ($countZdjReal < 4)
			{
				$res .= "<a href=$urlFull rel=\"lightbox[$idReal]\" title=\"$opis\">
						<img src=\"$urlMiniatury\" width=\"100\" height=\"40\" alt=\"\" style=\"border: none; \"/>
					</a>";
			}
			else
			{
				$res .= "<a href=$urlFull rel=\"lightbox[$idReal]\" title=\"opis\">
						<img src=\"$urlMiniatury\" width=\"100\" height=\"40\" alt=\"\" style=\"border: none; display: none;\"/>
					</a>";
				
			}
			$prevIdReal = $idReal;
		}
		return $res;
 	}
 	 	
 }
 
 class GaleriaClass
 {
 	private $DBInt = null;
 	private $objRealizacja = null;
 	private $picsPath = '../FrontPage/Files/Img';
 	private $realizacjaObj = null;
 	/*
 	 * Pkazuje formularz dodawania zdjecia
 	 */
 	public function AddZdjecia($realizacjaId, $zdjecieId)
 	{
 		
 		$html = '';
 		$urlMin = array(); $urlPeln = array(); $kolejnosc = array();
 		$realizacje = array();
 		
 		
 	    $html .= '<table width="600" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
     	$myForm = null;
     	$myForm = new Form('dFORM', 'POST');
     	$zdjForm = $myForm->getFormInstance();
     	
     	$query = 'SELECT * FROM REALIZACJE ORDER BY NAZWA';
 	    $DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($query);
		
		while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$realizacje[$data['id']] = $data['Nazwa'];
			
		}
		
     	$zdjForm->addElement('header', ' hdrTest', 'Zarządzanie zdjęciami');
     	$realizacjaVal = $zdjForm->addElement('select', 'selRealizacja', 'Realizacja', $realizacje);
     	if ($zdjecieId == 0)
     	{
     	  $ileZdj = 5;
     	}
     	else
     	{
     		$ileZdj = 1;
     	}
     	
 		for($i = 0; $i < $ileZdj; $i++)
     	{
     		$tx = $i + 1;
     	    $zdjForm->addElement('static', 'lblZdj', "<b>-Obraz $tx-</b>"); 
     		$imgMin[$i] = $zdjForm->addElement('file', "fileMin$i", "miniatura");
     		$imgPeln[$i] = $zdjForm->addElement('file', "filePeln$i", "pełny rozm");
     		$kolejnoscElem[$i] = $zdjForm->addElement('text', "kolejnosc$i", "kolejność wyśw.");
     		
     		/*$zdjForm->addRule("fileMin$i", 'Plik jest wymagany', 'uploadedfile');
     		$zdjForm->addRule("filePeln$i", 'Plik jest wymagany', 'uploadedfile');*/
     		
     		$zdjForm->addRule("fileMin$i", 'Maksymalny rozmiar pliku to 1 MB', 'maxfilesize', 1024000);
     		$zdjForm->addRule("filePeln$i", 'Maksymalny rozmiar pliku to 1 MB', 'maxfilesize', 1024000);
     		$zdjForm-> addRule("fileMin$i", 'Plik *.jpg', 'filename', '/^.*\.jpg$/');
			$zdjForm-> addRule("filePeln$i", 'Plik *.jpg', 'filename', '/^.*\.jpg$/');     		
     	}
     	
     	/*
     	 $form-> addRule('myfile', 'File is required', 'uploadedfile');
$form-> addRule('myfile', 'Cannot exceed 1776 bytes', 'maxfilesize', 1776);
$form-> addRule('myfile', 'Must be XML', 'mimetype', 'image/jpeg');
$form-> addRule('myfile', 'Must be *.xml', 'filename', '/^.*\.xml$/');

     	 */
     	
     	$idReal = $zdjForm->addElement('hidden', 'idReal' ,'idReal');
     	if ($zdjecieId > 0)
     		$idZdj = $zdjForm->addElement('hidden', 'idZdj' ,'idZdj');
     	
     	$zdjForm->addElement('reset', 'btnReset', 'Wyczyść');
      	$zdjForm->addElement('submit', 'btnSubmit', 'Zapisz');
      	
      	$zdjForm->applyFilter('__ALL__', 'trim');
		$myForm->setStyle(2);
      	if ($zdjForm->validate())
        {
        	//$_SESSION['m'] = -1;
        	$zdjForm->freeze();
        	try
        	{
        	
        		$realizacja = $realizacjaVal->GetValue();
        		
        		
        		
        		$rozmiar = 0;
        		$ilePlikow = 0;
        		
        		for ($i=0; $i<$ileZdj; $i++)
        		{
	        	    $fileInfMin = $imgMin[$i]->GetValue();
	        	    $fileInfPeln = $imgPeln[$i]->GetValue();

	        	    if (($fileInfMin['name'] <> '') &&($fileInfPeln['name'] <> '')) 
	        	   		if (($imgMin[$i]->isUploadedFile()) && ($imgPeln[$i]->isUploadedFile())) 
    	    	    	{
	    	    	        $ilePlikow = $ilePlikow + 2;
    	    	    		    	    	           		    		
	        		    	$nazwaMin = $fileInfMin['name'];
	        		    	$nazwaPeln = $fileInfPeln['name'];
        		    		$rozmiar += $fileInfMin['size'];
        		    		$rozmiar += $fileInfPeln['size'];
        		    		$kolejnosc = $kolejnoscElem[$i]->GetValue();
        		    		
            	  	    	$imgMin[$i]->moveUploadedFile('./FrontPage/Files/Img/');
            	  	    	$imgPeln[$i]->MoveUploadedFile('./FrontPage/Files/Img/');
            	  	    	
              				$html .= $this->AddZdjeciaDo($zdjecieId, $realizacja[0], $nazwaMin, $nazwaPeln, $kolejnosc, $rozmiar, $ilePlikow);
		       	  		}
		       	  		
		   		}
		   		if ($ilePlikow == 0)
		   		{
		   			$module = new ModulesMgr();
					$module->loadModule('Galeria');
					$okAction = $module->getModuleActionIdByName('ShowZdjeciaAdmin');
					$dialogTxt = "Nie skopiowano plików";
					$dialog = new dialog('Transfer plików', $dialogTxt, 'Info', 300, 150);
					$dialog->setAlign('center');
					$dialog->setOkCaption('Ok');
					$dialog->setOkAction($okAction);
					$dialog->setId($realizacja);
					$html .= $dialog->show(1);
		   		}
		   		else
		   		{
		   			$module = new ModulesMgr();
					$module->loadModule('Galeria');
					$okAction = $module->getModuleActionIdByName('ShowZdjeciaAdmin');
					$dialogTxt = "Skopiowano $ilePlikow plików, łączny rozmiak plików: $rozmiar B";
					$dialog = new dialog('Transfer plików', $dialogTxt, 'Info', 300, 150);
					$dialog->setAlign('center');
					$dialog->setOkCaption('Ok');
					$dialog->setOkAction($okAction);
					$dialog->setId($realizacja);
					$html .= $dialog->show(1);
		   		}
        		
        	}	
        	Catch (exception $e)
        	{
        		$module = new ModulesMgr();
       			$module->loadModule('Galeria');
        		
        		$okAction = $module->getModuleActionIdByName('ShowZdjeciaAdmin');
        		$dialog = new dialog('Zapis pliku', 'Zapis pliku nie powiódł się!<br/>'.$e->GetMessage(), 'Alert', 300, 150);
        		$dialog->setAlign('center');
        		$dialog->setOkCaption('Ok');
        		$dialog->setOkAction($okAction);
        		$html .= $dialog->show(1);
        		return $html;
        		
        	}
        }
        else
        {
        	if ($realizacjaId>0)
        	{
        		$realizacjaVal->SetValue($realizacjaId);
        	}
        	
        	
        	$html .= $zdjForm->toHtml();
        	$html .= '</td></tr><tr><td>
					  <table width = "100%" class="Grid" >';
			$html .= '<tr><td align="right">';
			//$buttonChgPass = new button('../Cms/Files/Img/delete-16x16.png', 'Anuluj', $cancelAction, 0);
			//$html .=$buttonChgPass->show(1);
			$html .= '</td></tr>';
			$html .= '</table>';
        }
        $html .= '</td></tr></table>';

        return $html;
        
        
 	}
 	/*
 	 * Dodaje obraz do katalogu na dysku oraz twoprzy rekord w bd
 	 */
 	public function AddZdjeciaDo($zdjecieId, $realizacja, $nazwaMin, $nazwaPeln, $kolejnosc, $rozmiar, $ilePlikow)
 	{
 		$html = '';
 		
 		//kopiuje $photo do katlogu, gdy ok  - dodaje rekord w BD
 		$dbInt = DBSingleton::getInstance();
 		$pathMin = 'http://www.murmur.h2.pl/FrontPage/Files/Img/'.$nazwaMin;
 		$pathPeln =  'http://www.murmur.h2.pl/FrontPage/Files/Img/'.$nazwaPeln;
 		
 		//Save minitaury
 		if ($zdjecieId == 0)
 		{
 			$queryMin = "
 				INSERT INTO 
 					ZDJECIA(URL, kolejnosc, realizacjaId, Miniatura, idMiniatury)
 				VALUES ('$pathMin', $kolejnosc, $realizacja, 1, 0)	
 				";
 		}
 		else
 		{
 			$queryMin = "
 				UPDATE ZDJECIA 
 					Set URL='$pathMin', kolejnosc=$kolejnosc, realizacjaId=$realizacja, Miniatura=1, idMiniatury=0
 				WHERE
 					id=$zdjecieId
 			";
 		}
 		
 		
		
		//$dbInt->ExecQuery('start transaction');
		
		$dbInt->ExecQuery($queryMin);
		
		$queryIdMin = "SELECT id FROM ZDJECIA WHERE URL='$pathMin'";
		$result = $this->DBInt->ExecQuery($queryIdMin);
		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$idMin = $data["id"];
		
		// pelne
		
 		if ($zdjecieId == 0)
 		{
 			$queryPeln = "
 				INSERT INTO 
 					ZDJECIA(URL, kolejnosc, realizacjaId, Miniatura, idMiniatury)
 				VALUES ('$pathPeln', $kolejnosc, $realizacja, 0, $idMin)	
 				";
 		}
 		else
 		{
 			$queryPeln = "
 				UPDATE ZDJECIA 
 					Set URL='$pathPeln', kolejnosc=$kolejnosc, realizacjaId=$realizacja, Miniatura=0, idMiniatury=$idMin
 				WHERE
 					id=$zdjecieId
 			";
 		}
 		
		$dbInt->ExecQuery($queryPeln);
		//$dbInt->ExecQuery('commit');
		
	
		return $html;
 	}
 
 	//pokazuje miniatury
 	public function ShowRealizacja($realizacjaId)
 	{
 		return $this->realizacjaObj->ShowRealizacja($realizacjaId);
 	}
 	public function AddRealizacja($id)
 	{
 		$html = '';
 		$html .= '<table width="600" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
     	$myForm = null;
     	$myForm = new Form('dFORM', 'POST');
     	$realForm = $myForm->getFormInstance();
     	
     	$realForm->addElement('header', ' hdr', 'Dodawanie realizacji');
     	$elementNazwa = $realForm->addElement('text', 'txtName', 'Nazwa realizacji');
     	$elementId = $realForm->addElement('hidden', 'id', 'id gal');
     	
     	$queryGalerie = 'SELECT nazwa, id FROM GALERIE ORDER BY nazwa ';
     	$DBInt = DBSIngleton::getInstance();
    	$qResult = $DBInt->ExecQuery($queryGalerie);
		$i = 0;
		$galList = array();
		while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
			$galList[$data['id']]=$data['nazwa'];
		}
     	 
     	$elementGal = $realForm->addElement('select', 'selGal' ,'Przypisana do galerii', $galList);
     	
     	$elementOpis = $realForm->addElement('textarea', 'opis', 'Opis', array('cols'=>30, 'rows'=>6));
     	$elementKolejnosc = $realForm->addElement('text', 'txtKolejnosc', 'Kolejność');
     	$elementKeywords = $realForm->addElement('textarea', 'keywords', 'Słowa kluczowe', array('cols'=>30, 'rows'=>6));
     	$elementPriorytet = $realForm->addElement('text', 'txtPriorytet', 'Priorytet(wyszuk.)');
     	
     	$realForm->addElement('reset', 'btnReset', 'Wyczyść');
		$realForm->addElement('submit', 'btnSubmit', 'Zapisz');
     	$realForm->applyFilter('__ALL__', 'trim');
     	
     	$myForm->setStyle(2);
     	
     	if ($realForm->validate())
        {
        	//$_SESSION['m'] = -1;
        	$realForm->freeze();
        	$id = $elementId->GetValue();
        	$galeriaId = $elementGal->getValue();
        	$slowa_kluczowe = $elementKeywords->GetValue();
        	$opis = $elementOpis->GetValue();
        	$priorytet = $elementPriorytet->GetValue();
        	$kolejnosc = $elementKolejnosc->GetValue();
        	$nazwa = $elementNazwa->GetValue();
        	
        	$html = $this->AddRealizacjaDo($id, $galeriaId[0], $opis, $kolejnosc, $slowa_kluczowe, $priorytet, $nazwa);
        }
        else
        {
        	$elementId->setValue($id);
        	if ($id == 0)
        	{
        		$elementKolejnosc->SetValue(1);
        		$elementPriorytet->SetValue(1);
        		
        	}
        	else
        	{
        		$query = "
        			SELECT
        				id, galeriaId, opis, kolejnosc, slowa_kluczowe, priorytet, nazwa
        			FROM
        				REALIZACJE
        			WHERE
        				id=$id
        			";
        	
        		$qResult = $DBInt->ExecQuery($query);
        		$data = $qResult->fetchRow(DB_FETCHMODE_ASSOC);
        		$elementGal->setValue($data['galeriaId']);
        		$elementOpis->setValue($data['opis']);
        		$elementKolejnosc->setValue($data['kolejnosc']);
        		$elementKeywords->setValue($data['slowa_kluczowe']);
        		$elementPriorytet->setValue($data['priorytet']);
        		$elementNazwa->setValue($data['nazwa']);
        		
        	}
        	$html .= $realForm->toHtml();
        	$html .= '</td></tr>';
        	if ($id > 0)
			{
				$html .= '<tr><td>';
				$html .= $this->ShowZdjeciaAdmin($id);
		
				$html .= '</td></tr>';	
        	}
        	$html .= '</table>';
        	
        	
        }
 		return $html;
 	}
 	public function AddRealizacjaDo($id, $galeriaId, $opis, $kolejnosc, $slowa_kluczowe, $priorytet, $nazwa)
 	{
 		$html = '';
 		if ($id == 0)
 		{
 			$query = 
 				"
 				INSERT INTO REALIZACJE (galeriaId, opis, kolejnosc, slowa_kluczowe, priorytet, Nazwa)
 				VALUES ($galeriaId, '$opis', $kolejnosc, '$slowa_kluczowe', $priorytet, '$nazwa')
 				";
 		}
 		else
 		{
 			$query = 
 				"
 				UPDATE REALIZACJE SET
 					galeriaId = $galeriaId, opis = '$opis', kolejnosc=$kolejnosc, slowa_kluczowe='$slowa_kluczowe',
 					priorytet=$priorytet, Nazwa='$nazwa'
 				WHERE
 					id = $id
 				
 				";
 		}
 		$dbInt = DBSingleton::getInstance();
		//echo $query;
		$dbInt->ExecQuery($query);
		
		$module = new ModulesMgr();
		$module->loadModule('Galeria');
		$okAction = $module->getModuleActionIdByName('ShowRealizacjeAdmin');
		$dialog = new dialog('Zapis danych', 'Dane zapisane prawidłowo', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html .= $dialog->show(1);
		return $html;
 	}
 	public function ShowRealizacjeAdmin($galeriaId)
 	{
 		$html = '';
 		$whereClause = '';
 		if ($galeriaId > 0)
 		{
 			$whereClause = " WHERE g.Id = $galeriaId";	
 		}
 		$query = "
 			SELECT 
 				r.id, r.opis, r.kolejnosc, g.nazwa, r.slowa_kluczowe, r.priorytet, count(z.id) as ileZdjec
 			FROM
 				REALIZACJE AS r LEFT OUTER JOIN GALERIE AS g 
 					ON r.galeriaId = g.id
 				LEFT JOIN ZDJECIA z
 					ON z.realizacjaId = r.id and z.miniatura = 0
 			$whereClause
 			GROUP BY 1, 2, 3, 4, 5
 			ORDER BY
 				g.nazwa, r.kolejnosc  
 			
 		";
 		$html .= '<table class="Grid" align="center" cellspacing=0>';
 	   	if ($galeriaId == 0)
 	   	{
 			$html .= '<tr>';
 	   		$html .= '<td width=130><img src="../Cms/Files/Img/about-48x48.png" /></td>';
 	   		$html .= '<td><br/></td>';
 	   		$html .= '</tr>';
 	   	}
 	   	$html .= '<tr><td align="right" colspan="2"><hr/>';

 	   	$modules = new ModulesMgr();
 	   	$modules -> loadModule('Galeria');
 	   	$action = $modules -> getModuleActionIdByName('AddRealizacja');
 	   	$editAction = $modules -> getModuleActionIdByName('EditRealizacja');
 	   	$delAction = $modules->getModuleActionIdByName('DelRealizacja');
 	   	$upAction = $modules -> getModuleActionIdByName('realUpAction');
 	   	$downAction = $modules -> getModuleActionIdByName('realDownAction');
 	   	unset($modules);
 	   	$addTopButton = new button(buttonAddIcon, 'Dodaj realizację', $action, $galeriaId);
 	   	$html .=$addTopButton->show(1);
 	    		
 	   	$html .= '</td></tr>';
 	   	$html .= '<tr><td colspan="2">';
 	   	$realListGrid = new gridRenderer();
 	   	$realListGrid->setDataQuery($query);
 	   	if ($galeriaId > 0)
 	   	{
 	   		$nameGal = $this->GetName($galeriaId);
    		$realListGrid->setTitle("Lista realizacji dla galerii $nameGal");
 	   	}
 	   	else
 	   	{
 	   		$realListGrid->setTitle("Lista realizacji");
 	   	}
    		
    	$realListGrid->setGridAlign('center');
    	$realListGrid->setGridWidth(790);
    	
    	$realListGrid->addColumn("opis", 'Opis realizacji', 250, false, false, 'left');
    	$realListGrid->addColumn("kolejnosc", 'Kolejność wyświetlania', 80, false, false, 'left');
    	$realListGrid->addColumn('slowa_kluczowe', 'Słowa kluczowe (wyszukiwanie)', 150, false, false,  'center');
    	$realListGrid->addColumn('priorytet', 'Priorytet (wyszukiwanie)', 100, false, false,  'center');
    	if ($galeriaId == 0)
    		$realListGrid->addColumn('nazwa', 'Przypisana do galerii', 150, false, false,  'center');
    	$realListGrid->addColumn('ileZdjec', 'Ilość zdjęć', 100, false, false,  'left');
    	$realListGrid->addColumn("id", "", 200, true, false, 'right');
    	$realListGrid->enabledDelAction($delAction);
    	$realListGrid->enabledEditAction($editAction);
    	//echo $upAction;
    	//$realListGrid->addAction($upAction, '../Cms/Files/Img/up.gif');
    	//$realListGrid->addAction(21, '../Cms/Files/Img/down.gif');
    	$html .= $realListGrid->renderHtmlGrid(1);
    	$html .= '</td></tr>';
    	$html .= '<tr><td align="left"></td><td align="right">';
    	$addTopButton = new button(buttonAddIcon, 'Dodaj realizację', $action, $galeriaId);
    	$html .=$addTopButton->show(1);
    		
    	$html .= '</td></tr>';
    	
    	$html .= '</table>';
    	echo 'real';
    	return $html;
 	}
 	public function ShowZdjeciaAdmin($realizacjaId)
 	{
 		$html = '';
 		if ($realizacjaId > 0)
 		{
 			$query = "
 				SELECT 
 					zmin.id, zmin.url as urlMin, zmax.url as urlPeln, zmin.kolejnosc, r.Nazwa
 				FROM
 					ZDJECIA zmin 
 					INNER JOIN ZDJECIA zmax
 						ON zmax.idMiniatury = zmin.id
 					LEFT JOIN REALIZACJE r
 						ON r.id = zmin.realizacjaID
 				WHERE
 					zmin.realizacjaId = $realizacjaId
 				ORDER BY
 					r.Nazwa, zmin.kolejnosc	   
 			";
 		}
 		else
 		{
 			$query = "
 				SELECT 
 					zmin.id, zmin.url as urlMin, zmax.url as urlPeln, zmin.kolejnosc, r.Nazwa
 				FROM
 					ZDJECIA zmin 
 					INNER JOIN ZDJECIA zmax
 						ON zmax.idMiniatury = zmin.id
 					LEFT JOIN REALIZACJE r
 						ON r.id = zmin.realizacjaID	   
 				ORDER BY
 					r.Nazwa, zmin.kolejnosc
 			";
 		}
 		$html .= '<table class="Grid" align="center" cellspacing=0>';
 	   	if ($realizacjaId == 0)
 	   	{
 			$html .= '<tr>';
 	   		$html .= '<td width=130><img src="../Cms/Files/Img/about-48x48.png" /></td>';
 	   		$html .= '<td><br/></td>';
 	   		$html .= '</tr>';
 	   	}
 	   	$html .= '<tr><td align="right" colspan="2"><hr/>';

 	   	$modules = new ModulesMgr();
 	   	$modules -> loadModule('Galeria');
 	   	$action = $modules -> getModuleActionIdByName('AddZdjecia');
 	   	$editAction = $modules -> getModuleActionIdByName('EditZdjecie');
 	   	$delAction = $modules->getModuleActionIdByName('DelZdjecie');
 	   	$upAction = $modules -> getModuleActionIdByName('zdjUpAction');
 	   	$downAction = $modules -> getModuleActionIdByName('zdjDownAction');
 	   	unset($modules);
 	   	$addTopButton = new button(buttonAddIcon, 'Dodaj zdjęcia', $action, $realizacjaId);
 	   	$html .=$addTopButton->show(1);
 	    		
 	   	$html .= '</td></tr>';
 	   	$html .= '<tr><td colspan="2">';
 	   	$zdjListGrid = new gridRenderer();
 	   	$zdjListGrid->setDataQuery($query);
 		if ($realizacjaId > 0)
 	   	{
 	   		$realName = $this->RealizacjaGetName($realizacjaId);
    		$zdjListGrid->setTitle("Lista zdjęć dla realizacji $realName");
 	   	}
 	   	else
 	   	{
 	   		$zdjListGrid->setTitle("Lista zdjęć");
 	   	}
 	   	$zdjListGrid->setGridAlign('center');
    	$zdjListGrid->setGridWidth(790);
    	
    	$zdjListGrid->addColumn("id", "", 200, true, false, 'right');
    	$zdjListGrid->addColumn("urlMin", 'Miniatura', 250, false, false, 'center', true);
    	$zdjListGrid->addColumn("urlMin", 'Url miniatury', 250, false, false, 'left');
    	$zdjListGrid->addColumn("urlPeln", 'Url pelnego', 250, false, false, 'left');
    	$zdjListGrid->addColumn("kolejnosc", 'Kolejność wyświetlania', 80, false, false, 'center');
    	
    	if ($realizacjaId == 0)
    	  $zdjListGrid->addColumn('Nazwa', 'Przypisane do realizacji', 200, false, false,  'center');
 	   	$zdjListGrid->enabledDelAction($delAction);
    	$zdjListGrid->enabledEditAction($editAction);
    	$html .= $zdjListGrid->renderHtmlGrid(1);
    	$html .= '</td></tr>';
    	$html .= '<tr><td align="left"></td><td align="right">';
    	$addTopButton = new button(buttonAddIcon, 'Dodaj zdjęcia', $action, $realizacjaId);
    	$html .=$addTopButton->show(1);
    		
    	$html .= '</td></tr>';
    	
    	$html .= '</table>';
    	
    	return $html;
 	}
 	public function ShowGallery($galId)
 	{
 		return $this->realizacjaObj->ShowGallery($galId);
 	}
 	public function __construct()
	{
		$this->DBInt = DBSingleton::GetInstance();
		$this->realizacjaObj = new Realizacja();
		
	}
	public function GetId($menuId)
	{
		$sql = "SELECT 
					id
				FROM
					GALERIE 
				WHERE 
					idMenu = $menuId";							
 
 		$result = $this->DBInt->ExecQuery($sql);
 		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
 		$id = $data['id'];
 		if ($id == '') $id = 0;
 		
 		return $id;   
	}
	public function GetName($id)
	{
		$sql = "SELECT 
					nazwa
				FROM
					GALERIE 
				WHERE 
					id = $id";							
 
 		$result = $this->DBInt->ExecQuery($sql);
 		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
 		return $data['nazwa'];
	}
	public function RealizacjaGetName($id)
	{
	$sql = "SELECT 
					nazwa
				FROM
					REALIZACJE
				WHERE 
					id = $id";							
 
 		$result = $this->DBInt->ExecQuery($sql);
 		$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
 		return $data['nazwa'];	
	}
	public function ShowAdmin()
	{
		$html = '';
		$query = "SELECT
					gal.id,
					gal.nazwa,
					CASE WHEN 
					  m.Name IS NULL THEN 'Brak przypisanego menu'
					  ELSE m.Name
					 END AS menuName,
					count(r.id)AS ileRealizacji
				FROM
					GALERIE as gal
					LEFT JOIN REALIZACJE r ON gal.id = r.galeriaID
					LEFT JOIN cmsMenu m ON gal.idMenu = m.id
				GROUP BY
					1, 2, 3
				ORDER BY
				    gal.nazwa			
				";
		$html .= '<table class="Grid" align="center" cellspacing=0>';
 	   	$html .= '<tr>';
 	   	$html .= '<td width=130><img src="../Cms/Files/Img/about-48x48.png" /></td>';
 	   	$html .= '<td><br/></td>';
 	   	$html .= '</tr>';
 	   	$html .= '<tr><td align="right" colspan="2"><hr/>';

 	   	$modules = new ModulesMgr();
 	   	$modules -> loadModule('Galeria');
 	   	$action = $modules -> getModuleActionIdByName('AddGallery');
 	   	$editAction = $modules -> getModuleActionIdByName('EditGallery');
 	   	$delAction = $modules->getModuleActionIdByName('DelGallery');
 	   	unset($modules);
 	   	$addTopButton = new button(buttonAddIcon, 'Dodaj galerię', $action, -1);
 	   	$html .=$addTopButton->show(1);
 	    		
 	   	$html .= '</td></tr>';
 	   	$html .= '<tr><td colspan="2">';
 	   	$galListGrid = new gridRenderer();
 	   	$galListGrid->setDataQuery($query);
    	$galListGrid->setTitle('Lista galerii');
    	$galListGrid->setGridAlign('center');
    	$galListGrid->setGridWidth(790);
    	
    	$galListGrid->addColumn("nazwa", 'Nazwa', 200, false, false, 'left');
    	$galListGrid->addColumn("menuName", 'Nazwa przypisanego menu', 100, false, false, 'left');
    	$galListGrid->addColumn('ileRealizacji', 'Ilość realizacji', 40, false, false,  'center');
    	$galListGrid->addColumn("id", "", 200, true, false, 'right');
    	$galListGrid->enabledDelAction($delAction);
    	$galListGrid->enabledEditAction($editAction);
    	$html .= $galListGrid->renderHtmlGrid(1);
    	$html .= '</td></tr>';
    	$html .= '<tr><td align="left"></td><td align="right">';
    	$addTopButton = new button(buttonAddIcon, 'Dodaj glerię', $action, -1);
    	$html .=$addTopButton->show(1);
    		
    	$html .= '</td></tr>';
    	
    	$html .= '</table>';
    	
    	return $html;
	}
	public function AddGallery($id)
	{
		$editMode = ($id != 0);
				
		$html = '';
		saveActionValue();
     	$moduleTmp = new ModulesMgr();
     	$moduleTmp->loadModule('FrontendMenu');
     	$action = $moduleTmp->getModuleActionIdByName('showMenuListChoose');
     	$actionPage = $moduleTmp->getModuleActionIdByName('showMenuPagesChoose');
     	$html .= '<table width="600" align="center" cellpadding=0 cellspacing=0 border=0><tr><td>';
     	$myForm = null;
     	$myForm = new Form('dFORM', 'POST');
     	$galleryForm = $myForm->getFormInstance();
     	
     	$galleryForm->addElement('header', ' hdr', 'Dodawanie galerii');
     	$name = $galleryForm->addElement('text', 'txtName', 'Nazwa');
     	$valId = $galleryForm->addElement('hidden', 'id', 'id gal');
     	$parentMenu = $galleryForm->addElement('text', 'txtNazwa', 'Przypisane menu', 'readonly="readonly"');
     	$button = $galleryForm->addElement('button', 'btnShortNazwa', 'wybierz...', '');
     	$buttonattributes = array('title'=>'asdasd', 'onclick'=>"return window.open('?a=$action&onlycontent=1&idcol=hidden&namecol=txtNazwa', 'Wybierz', 'menubar=0,location=0,directories=0,toolbar=0,resizable,dependent,width=720,height=500');");
   	    $button->updateAttributes($buttonattributes);
   	    
     	
     	$galleryForm->addElement('reset', 'btnReset', 'Wyczyść');
		$galleryForm->addElement('submit', 'btnSubmit', 'Zapisz');
     	
     	$galleryForm->applyFilter('__ALL__', 'trim');
     	$myForm->setStyle(2);
     	
     	if ($galleryForm->validate())
        {
        	//$_SESSION['m'] = -1;
        	$galleryForm->freeze();
        	try
        	{
        		$nameVal = $name->getValue();
        		$id = $valId->getValue();
        		if ($parentMenu->getValue() == '')
        		{
        			$menuParentItemVal = 0; //w tabeli bedzie null
        		}
        		else
        		{
	        		
        			$tmpMenuMgr = MenuMgr::getInstance();
        			$parentMenuName = $parentMenu->getValue();
        			//if ($parentMenuName != 'Brak') 
	        		$menuParentItemVal = $tmpMenuMgr->getMenuIdByName($parentMenuName);
	        	}
	        	
	        	$html.=$this->AddGalleryDo($id, $nameVal, $menuParentItemVal, $editMode);
        	}   
        	catch (exception $e)
        	{
        		$module = new ModulesMgr();
        		$module->loadModule('Galeria');
        		
        		$okAction = $module->getModuleActionIdByName('ShowGalleryListAdmin');
        		$dialog = new dialog('Zapis galerii', 'Uwaga! Wyst�pi� b��d przy zapisie galerii<br/>'.$e->GetMessage(), 'Alert', 300, 150);
        		$dialog->setAlign('center');
        		$dialog->setOkCaption('Ok');
        		$dialog->setOkAction($okAction);
        		$html .= $dialog->show(1);
        		return $html;
        	}      	
        }
        else
        {
        	
        	if ($id > 0)
        	{
        		$query = "
        			SELECT 
        				`nazwa`, `idMenu`
        			FROM
        				`GALERIE`
        			WHERE
        				`id` = $id
        				"; 
				
        			
        		$dbInt = null;
        		$dbInt = DBSingleton::getInstance();
        		$data = $dbInt->ExecQuery($query);
        		$rec = $data->fetchRow(DB_FETCHMODE_ASSOC);
        		
        		$menuId = $rec['idMenu'];
        		$valId->setValue($id);
        	
        		//$index->setValue($rec['Index']);
        		$name->setValue($rec['nazwa']);
        		$parentMenuName = '';
        	    if ($menuId <> '')
        		{
        			$tmpMenuMgr = MenuMgr::getInstance();
        			$parentMenuName = $tmpMenuMgr->getMenuNameById($menuId);
        			$parentMenu->setValue($parentMenuName);
        		}
        		
        	}
        	else
        	{
        		$valId->setValue(0);
        	}
        	$html .= $galleryForm->toHtml();
        	$html .= '</td></tr>';
			if ($id > 0)
			{
				$html .= '<tr><td>';
				$html .= $this->ShowRealizacjeAdmin($id);
				
				$html .= '</td></tr>';	
        	}
       
        	
        }	
		
		
		
		$html .= '</table>';
		
		return $html;			  
	}
	public function AddGalleryDo($id, $nazwa, $menuId, $editMode)
	{
		$html='';
		if ($id==0)
		{
			$query = "INSERT INTO `GALERIE`(`nazwa`, `idMenu`) values('$nazwa', $menuId)";
		}
		else
		{
			$query = "UPDATE `GALERIE` SET `nazwa`='$nazwa', `idMenu`=$menuId WHERE id=$id";
		}
		$dbInt = DBSingleton::getInstance();
		//echo $query;
		$dbInt->ExecQuery($query);
		
		$module = new ModulesMgr();
		$module->loadModule('Galeria');
		$okAction = $module->getModuleActionIdByName('ShowGalleriesAdmin');
		$dialog = new dialog('Zapis danych', 'Dane zapisane prawid�owo', 'Info', 300, 150);
		$dialog->setAlign('center');
		$dialog->setOkCaption('Ok');
		$dialog->setOkAction($okAction);
		$html .= $dialog->show(1);
		return $html;
		
	}
	
 }
 
 
?>