<?php
//tu klasa sluzaca do wyswietlania stron poprzez podanie ich shortname, reszta zarzadzania strona po stronie modulu Pages


class pagesMgr
{
	private $dbInt;
	
	public function __construct()
	{
		Try
		{
			$this->dbInt = DBSingleton::GetInstance();
		}
		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'pagesMgr.Construct');
   			$exc->writeException();   	   	
		}	
	}
	public function modifyPage($id, $name, $shortName, $active, $admin , $authorizedOnly, $desc, $template, $mt='T', $ml='T', $mr='N', $mb='T', $pageTitle='', $pageDescription='')
	{
		Try
  		{
  			$dmlPageModify = "
				UPDATE cmsPages
				SET 
					`PageName` = '$name', `ShortName` = '$shortName', `Active` = '$active',
					`Admin` = '$admin', `AuthorizedOnly` = '$authorizedOnly', `Desc` = '$desc', `TemplateId`=$template,
					`MenuTop` = '$mt', `MenuLeft` = '$ml', `MenuRight`='$mr', `MenuBottom`='$mb', `PageTitle`='$pageTitle',
					`PageDescription`='$pageDescription'
				WHERE
					id = $id
					";
			$this->dbInt->ExecQuery($dmlPageModify);
				
  		}
		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'pagesMgr.modifyPage');
   			return $exc->writeException();   	   	
		}
	}
	
  	public function addPage($name, $shortName, $active, $admin , $authorizedOnly, $desc, $template=0, $mt='T', $ml='T', $mr='N', $mb='T', $pageTitle='', $pageDescription='')
  	{
  		Try
  		{
  			
  			if ($template == 0)
				$ddlPageAdd = "Insert Into cmsPages (`PageName`, `ShortName`, `Active`, `Admin`, `AuthorizedOnly`, `Desc`, `TemplateId`,
  												`MenuTop`, `MenuLeft`, `MenuRight`, `MenuBottom`, `PageTitle`, `PageDescription`) Values
									('$name', '$shortName', '$active', '$admin', '$authorizedOnly', '$desc', null, '$mt', '$ml', '$mr', '$mb', '$pageTitle', '$pageDescription')";  				
  			else
  				$ddlPageAdd = "Insert Into cmsPages (`PageName`, `ShortName`, `Active`, `Admin`, `AuthorizedOnly`, `Desc`, `TemplateId`,
  												`MenuTop`, `MenuLeft`, `MenuRight`, `MenuBottom`, `PageTitle`, `PageDescription`) Values
									('$name', '$shortName', '$active', '$admin', '$authorizedOnly', '$desc', $template, '$mt', '$ml', '$mr', '$mb', '$pageTitle', '$pageDescription')";
  				
  			$this->dbInt->ExecQuery($ddlPageAdd);
  			
  		}
	  	
  		catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'pagesMgr.addPage');
   			return $exc->writeException();   	   	
		}
  	}
	
	public function getContent($pageName)
  	{
  		Try
  		{
  			$content = '';
  			
  			if ($pageName != '')
  			{
  				$secCount = 0;
  			// 	przejdz przez wszystkie sekcje i zbuduj content poprzez zbudowanie tabel z zawartoscia sekcji
	  		// 	select sectionId from pages where pagename=$pageName
			//	
				$sectionsMgr = new sectionsMgr();
  				$pageId = $this->getPageIdByName($pageName);
  				$secCount = $sectionsMgr->getSectionsCount($pageId);
  				//XXX: Tu dodalem join
  				$lang = $_SESSION['lang'];
	  			$query = "Select s.id from cmsSections s inner join cmsSectionsToPages sp on (s.id=sp.PK_SectionId)   
	  				and (sp.PK_PageId = $pageId) WHERE ((sp.Language='$lang') OR (sp.Language is null)) Order By s.Priority";
	  			
				$result = $this->dbInt->ExecQuery($query);
				
				for($i = 0; $i < $secCount; $i++)   
				{
					$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
					$sectionId = $data['id'];
					//FIXME: Tu raczej konkatenacja - przy wielu sekcjach moze byc zle
					//XXX Zmienilem - dodalem konkatenacje 23.09.2008 
					$content .= $sectionsMgr->getSectionContent($sectionId);
					//echo $content;
				}
	  		}
  			else
  			{
  				//throw new Exception('pagesMgr->GetContent'); 		
  			}
	  		return $content;
  		}
  		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'pagesMgr.getContent');
   			$exc->writeException();   	   	
		}
  	}
  	
  	public function getPageIdByName($pageTechName)
  	{
  		Try
  		{  		
  			$query = "Select id from cmsPages where ShortName = '$pageTechName'";
  			$result = $this->dbInt->ExecQuery($query);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$wyn = $data['id'];
			return $wyn;
  		}
  		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'pagesMgr.getPageIdByName');
   			return $exc->writeException();   	   	
		}
  		
  	}
	public function getPageNameById($id)
  	{
  		Try
  		{  		
  			$query = "Select ShortName from cmsPages where id = $id";
  			$result = $this->dbInt->ExecQuery($query);
			$data = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$wyn = $data['ShortName'];
			return $wyn;
  		}
  		Catch(Exception $e)
		{
			$exc = new ExceptionClass($e, 'pagesMgr.getPageNameById');
   			$exc->writeException();   	   	
		}
  		
  	}
 
}
?>