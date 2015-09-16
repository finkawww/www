<?php
/********************************
 *		klasa grid	
 * 	
 *
 *
 ********************************/
//FIXME Przerob groida na Smarty, dodaj komentarze

/*
UWAGA!
Jezeli korzystamy z groda rekursywnego (hierarchia) nalezy odpowiednio spreparowac zapytania:
Zapytanie master - przefiltrowane, zeby nie zwracalo wierszy podrzednych
Zapytanie Detail - przefitrowane, zeby nie zawieralo masterow oraz zeby mialo parenta
*/


final class col
{
	private $fName;
	private $fHeaderText;
	private $fSize;
	private $fIsId;
	private $fIsValue;
	private $isImg;
	//align: left, right, center
	private $align = 'left';
	
	function __construct($colName, $colHeaderText, $colSize, $isId, $isValue, $align, $isImg)
	{
		$this->fName = $colName;
		$this->fHeaderText = $colHeaderText;
		$this->fSize = $colSize;
		$this->fIsId = $isId;
		$this->fIsValue = $isValue;
		$this->align = $align;
		$this->isImg = $isImg; 
	}
	
	function __destruct()
	{
		//echo "niszcze";
	}
	
	function getName()
	{
		return $this->fName; 
	}
	
	function getHeaderText()
	{
		return $this->fHeaderText;
	}
	
	function getSize()
	{
		return $this->fSize;
	}
	
	function getAlign()
	{
		return $this->align;
	}
	function getIsImg()
	{
		return $this->isImg;
	}
	
}

//----------------------------------------------------------------------------
class gridSettings
{
	private $fEditRow = false;
	private $fDelRow = false;
	private $fChooseRow = false;
	private $fCallBackRow = false;
	private $fActionRow = false;
	
	protected $argsName = array();
	protected $argsValues = array();
	// dataSet
	//private $fDataSource;
	//nazwa kolumny kluczowej
	private $fIdColumn = '';
	private $fValueColumn = '';
	private $fColsCount = 0;
	private $fTitle = '';
	private $align = 'left';
	protected $fQuery;
	protected $fRecurseQuery;
	protected $fRecurseQueryOrderClause = '';
	protected $fParentFkCol = '';
	private $fWidth = 0;
	
	protected $fCols = Array();
	protected $fEditAction = '';
	protected $fDelAction = '';
	protected $fCallBackAction = '';
	protected $fChooseAction = '';
	protected $fActions = array();
	protected $rowDarkColor = '#E0DEEF';
	protected $rowLightColor = '#FFFFFF';
	protected $rowActiveColor = '#CCCC88';//#E9D799
	 
	// wartosci grida wstawiane przez użytkownika
	protected $colValues = array();
	protected $staticRows = array();
	protected $actionsIcons = array();
	
	private function setIdColumn($colName)
	{
		$this->fIdColumn = $colName;
	}
	
	private function setValueColumn($colName)
	{
		$this->fValueColumn = $colName;
	}
	
	//dodaje wiersze z wartosciami na grid
	protected function addValues($colValues)
	{
		$this->staticRows[count($this->staticRows)] = $colValues;
	}
	//zwraca nazwe 
	protected function getIdColumnName()
	{
		return $this->fIdColumn;
	}
	
	protected function getValueColumnName()
	{
		return $this->fValueColumn;
	}
	protected function IsImgCol()
	{
	
	}
		
	//dodaje kolumne do grida
	public function addColumn($colName, $colHeader, $colSize, $isId, $isValue = false, $align = 'left', $isImg = false)
	{
		
		$tmpCol = new col($colName,$colHeader, $colSize, $isId, $isValue, $align, $isImg);
		$this->fCols[$this->fColsCount] = $tmpCol;
		//if (!isId)
		$this->fColsCount++;
		
		if ($isId)
			$this->setIdColumn($colName);
		
		if ($isValue)
			$this->setValueColumn($colName); 
		
	}
	//kolumna id
		
	public function setDataQuery($query)
	{
		$this->fQuery = $query;
	}
	
	public function setRecurseQuery($query, $parentFkCol, $orderClause)
	{
		$this->fRecurseQuery = $query;
		$this->fParentFkCol = $parentFkCol;
		$this->fRecurseQueryOrderClause = $orderClause;
	}
	
	public function addAction($action, $icon)
	{
		$this->fActionRow = true;
		$this->fActions[] = $action;
		$this->fIcons[] = $icon;
	}
	//wlacza akcje edit 
	public function enabledEditAction($action)
	{
	  	$this->fEditRow = true;
	  	$this->fEditAction = $action;
	  //$this->fColsCount++;
	}
	public function callBackAction($action)
	{
		$this->fCallBackRow = true;
		$this->fCallBackAction = $action;
		
	}
	public function enabledDelAction($action)
	{
		$this->fDelRow = true;
	  	$this->fDelAction = $action;
	  //$this->fColsCount++;		
	}
	public function enabledChooseAction($action)
	{
		$this->fChooseRow = true;
		$this->fChooseAction = $action;

	}
	
	public function addOtherArgs($argName, $argValue)
	{
		$this->argsName[count($this->argsName)] = $argName;
		$this->argsValues[count($this->argsValues)] = $argValue;
	}
	
	public function colCount()
	{
		return $this->fColsCount;
	}
	public function setGridAlign($align)
	{
		$this->align = $align;
	}
	public function getGridAlign()
	{
		return $this->align;
	}
	public function setGridWidth($width)
	{
		$this->fWidth = $width;
	}
	public function getGridWidth()
	{
		return $this->fWidth;
	}
	public function setTitle($title)
	{
		$this->fTitle = $title;
	}
	public function getTitle()
	{
		return $this->fTitle;
	}
	public function getColHeaderText($index)
	{
		return $this->fCols[$index]->getHeaderText();
	}
	public function getColHeaderWidth($index)
	{
		return $this->fCols[$index]->getSize();
	}
	protected function getColName($index)
	{
		return $this->fCols[$index]->getName();
	}
	protected function getQuery()
	{
		return $this->fQuery;
	}
	protected function getSubQuery($parentId)
	{
		return ($this->fRecurseQuery. ' AND '.$this->fParentFkCol."=$parentId ".$this->fRecurseQueryOrderClause);
	}
	protected function getColAlign($index)
	{
		return $this->fCols[$index]->getAlign();
	}
	
}
//------------------------------------------------------------------------
class gridRenderer extends gridSettings
{
	private $level = 0;
	
	private $postValues = array();
	private $getValues = array();
	private $recurse = false;
	 
	private function fillGridNormal($renderHtml)
	{
		$result = '';
		if ($this->fQuery == '')
		{
			//TODO Zrealizowac wypelnianie grida danymi nie pochodzacymi z bazy
		}
		else
		{
			$colCount = $this->colCount();
			$DBInt = DBSingleton::getInstance();
		//	$ds = $this->getDataSource();
			$queryResult = $DBInt->ExecQuery($this->getQuery());
		//	$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
			$data = $queryResult->fetchRow(DB_FETCHMODE_ASSOC);
			$rowNr = 0;
			//jezeli puste dane to daje Brak danych
			if (count($data)==0)
			{
				$ileKolumn = $this->colCount()+2+count($this->fActions);
				$result .= "<tr class=\"rowDark\"><td width =\"100%\" colspan=\"$ileKolumn\" align=\"center\">--- Brak danych ---</td></tr>";
			}
			else
			do
			{	
				if (($rowNr % 2)==0)
				{	
					$rowColor = "rowDark";
					$bckColor = $this->rowDarkColor;
				}	
				else
				{
					$rowColor = "rowLight";
					$bckColor = $this->rowLightColor;
				}
				$activeColor = $this->rowActiveColor;
				
				//kotwice
				$idColName = '';
				$idColName = $this->getIdColumnName();
				$colIdValue = $data[$idColName];
				
				$result.= "<a name='$colIdValue'><tr class=\"$rowColor\" onmouseover=this.style.background='$activeColor' onmouseout=this.style.background='$bckColor'>";

				// wiersze - jezeli sa akcje to dodaje <td> akcji
				if ($this->fEditAction != '')
				{
					$idColName = '';
					$idColName = $this->getIdColumnName();
					$colIdValue = $data[$idColName];
					
					
					$editButton = new button(buttonEditIcon, '', $this->fEditAction, $colIdValue);
					if (count($this->argsName)>0)
					{
						for ($i=0;$i<count($this->argsName);$i++)
						{
							$editButton->addOtherActionArgs($this->argsName[$i], $this->argsValues[$i]);	
						}
						
				 } 
				$result.=	"<td align=\"center\">".
								$editButton->show(1, 'gridButton').
							"</td>";
				}
				if ($this->fDelAction != '')
				{
					$idColName = $this->getIdColumnName();
					$colIdValue = $data[$idColName];
					$delButton = new button(buttonDelIcon, '', $this->fDelAction, $colIdValue);
				//	<a href=?a=".$this->fDelAction."&id=".$colIdValue.">
					$result.=	"<td align=\"center\">".
									$delButton->show(1, 'gridButton').
								"</td>";					
				}
				if ($this->fChooseAction != '')
				{
					$idColName = '';
					$idColName = $this->getIdColumnName();
					$colIdValue = $data[$idColName];
					$chooseButton = new button(buttonChooseIcon, '', $this->fChooseAction, $colIdValue);
									
					if (count($this->argsName)>0)
					{
						for ($i=0; $i<count($this->argsName); $i++)
						{
							$chooseButton->addOtherActionArgs($this->argsName[$i], $this->argsValues[$i]);	
						}
					
					} 
					$result.=	"<td align=\"center\">".
									$chooseButton->show(1, 'gridButton').
								"</td>";					
				}
				
				if ($this->fCallBackAction != '')
				{
					$idColName = '';
					$idColName = $this->getIdColumnName();
					
					$colValueName = $this->getValueColumnName(); 
					$colValueValue = $data[$colValueName];
					if ($idColName == '')
					{
						throw new exception('Nie zainicjalizowana kolumna identyfikacyjna');
					}
					$colIdValue = $data[$idColName];
					$chooseButton = new button(buttonChooseIcon, '', 0, $colValueValue, 1, $this->fCallBackAction);
					$result.=	"<td align=\"center\">".
									$chooseButton->show(1, 'gridButton').
								"</td>";	
				}
				if (count($this->fActions) > 0)
				{
					$buttons = array();
					$idColName = $this->getIdColumnName();
					$colIdValue = $data[$idColName];
					for ($i=0; $i<count($this->fActions); $i++)
					{
						$button = new button($this->fIcons[$i], '', $this->fActions[$i], $colIdValue);
						$buttons[] = $button;
				//	<a href=?a=".$this->fDelAction."&id=".$colIdValue.">
					$result.=	"<td align=\"center\">".
									$buttons[$i]->show(1, 'gridButton').
								"</td>";
					}										
				}
				for ($i=0; $i < $this->colCount(); $i++)
				{
					//echo "<br>col";
				
					$columnName = $this->getColName($i);
					if (($columnName != $this->getIdColumnName()) && ($columnName != $this->getValueColumnName()))
					{
						$fieldValue = $data[$columnName];
						$colAlign = $this->getColAlign($i);
						if ($this->fCols[$i]->getIsImg())
						{
							$result .= "<td align=\"$colAlign\"><img src=\"$fieldValue\" width=\"130\"></td>";
						}
						else
						{
							if ($renderHtml)
							{
							$result .= "<td align=\"$colAlign\">".htmlspecialchars($fieldValue).'</td>';
							}
							else
							{
							$result .= "<td align=\"$colAlign\">".$fieldValue.'</td>';
							}
						}
					}
				}
				$result .= "</tr></a>";
				$rowNr++;
			//	echo $result;
			}
			while ($data = $queryResult->fetchRow(DB_FETCHMODE_ASSOC));
		}
		return $result;	
	}
	//TODO Przemyslec i dokonczyc
	private function saveGetAndPostValues()
	{
		
		$i = 0;
		foreach($_POST as $key=>$val)
		{
			$this->postValues[$i] = "$key=$val";
		}
		
		$i = 0;
		foreach($_GET as $key=>$val)
		{
			$this->getValues[$i] = "$key=$val";
		}
				
	}
	
	
	
	//TODO Przemyslec i dokonczyc
	private function sortActionExecute($colNumber)
	{
				
	}
	
	private function addWhiteSpaces($level)
	{
		$result = '';
		for ($i=0; $i < $level - 1; $i++)
			for ($j=0; $j < 5; $j++)		
				$result .= "&nbsp;";
		
		return $result; 
	}
	private function fillSubGrid($parentId)
	{
		$data = array();
		$result = '';
		
		$this->level ++;
				
		$colCount = $this->colCount();
		$DBInt = DBSingleton::getInstance();
		
		$sql = $this->getSubQuery($parentId);
		$qResult = $DBInt->ExecQuery($sql);
				
		$rowNr = 0;
		while ($data = $qResult->fetchRow(DB_FETCHMODE_ASSOC))
		{
						
			if (($rowNr % 2)==0)
			{	
				$rowColor = "rowDark";
				$bckColor = $this->rowDarkColor;
			}	
			else
			{
				$rowColor = "rowLight";
				$bckColor = $this->rowLightColor;
			}
			
			$count = count($data);
			$activeColor = $this->rowActiveColor;
			$result.= "<tr bgcolor=\"#FFFFFF\" onmouseover=this.style.background='$activeColor' onmouseout=this.style.background='#FFFFFF'>";
				// wiersze - jezeli sa akcje to dodaje <td> akcji
			
			if ($this->fEditAction != '')
			{
				$idColName = '';
				$idColName = $this->getIdColumnName();
				$colIdValue = $data[$idColName];
				
				
				$editButton = new button(buttonEditIcon, '', $this->fEditAction, $colIdValue);
				if (count($this->argsName)>0)
				{
					for ($i=0;$i<count($this->argsName);$i++)
					{
						$editButton->addOtherActionArgs($this->argsName[$i], $this->argsValues[$i]);	
					}
					
			 } 
			$result.=	"<td align=\"center\">".
							$editButton->show(1, 'gridButton').
						"</td>";
			}
			if ($this->fDelAction != '')
			{
				$idColName = $this->getIdColumnName();
				$colIdValue = $data[$idColName];
				$delButton = new button(buttonDelIcon, '', $this->fDelAction, $colIdValue);
				//	<a href=?a=".$this->fDelAction."&id=".$colIdValue.">
				$result.=	"<td align=\"center\">".
								$delButton->show(1, 'gridButton').
							"</td>";					
			}
			if ($this->fChooseAction != '')
			{
				$idColName = $this->getIdColumnName();
				$colIdValue = $data[$idColName];
				$chooseButton = new button(buttonChooseIcon, '', $this->fChooseAction, $colIdValue);
								
				if (count($this->argsName)>0)
				{
					for ($i=0;$i<count($this->argsName);$i++)
					{
						$editButton->addOtherActionArgs($this->argsName[$i], $this->argsValues[$i]);	
					}
				
				} 
				$result.=	"<td align=\"center\">".
								$delButton->show(1, 'gridButton').
							"</td>";					
			}
			if ($this->fCallBackAction != '')
			{
					$idColName = '';
					$idColName = $this->getIdColumnName();
					
					$colValueName = $this->getValueColumnName(); 
					$colValueValue = $data[$colValueName];
					if ($idColName == '')
					{
						throw new exception('Nie zainicjalizowana kolumna identyfikacyjna');
					}
					$colIdValue = $data[$idColName];
					$chooseButton = new button(buttonChooseIcon, '', 0, $colValueValue, 1, $this->fCallBackAction);
					$result.=	"<td align=\"center\">".
									$chooseButton->show(1, 'gridButton').
					"</td>";	
			}
			
			
			if (count($this->fActions) > 0)
			{
					
					$idColName = $this->getIdColumnName();
					$colIdValue = $data[$idColName];
					for ($i=0; $i < count($this->fActions); $i++)
					{
						//echo $this->fActions[$i];
						$button = new button($this->fIcons[$i], '', $this->fActions[$i], $colIdValue);
						
				//	<a href=?a=".$this->fDelAction."&id=".$colIdValue.">
					$result.=	"<td align=\"center\">".
									$button->show(1, 'gridButton').
								"</td>";
					}										
				}
			
			
			$img = '<img src="../Cms/Files/Img/corner-dots.gif"/>';
			
			$whiteSpaceAdded = false; 								
			for ($i=0; $i < $this->colCount(); $i++)
			{
				//echo "<br>col";
			
				$columnName = $this->getColName($i);
				$fieldValue = $data[$columnName];
				if (!$whiteSpaceAdded)
				{
					$whiteSpace = $this->addWhiteSpaces($this->level);
					$whiteSpaceAdded = true;
				}
				else
				{
					$whiteSpace = '';				
				}
				if (($columnName != $this->getIdColumnName()) && ($columnName != $this->getValueColumnName()))
				{
					$fieldValue = $data[$columnName];
					$colAlign = $this->getColAlign($i);
					$result .= "<td align=\"$colAlign\">".$whiteSpace.$img.$fieldValue.'</td>';
					$img = '';
				}
			}
			$result .= "</tr>";
			$rowNr++;
		//	echo $result;
			$actualId = $data[$this->getIdColumnName()];
			
			if ($this->recurse)
				$result .= $this->fillSubGrid($actualId);
			 
		}
		
		$this->level--;
		
		return $result;		
	}
	private function fillGridRecurse()
	{
		$result = '';
		
		$colCount = $this->colCount();
		$DBInt = DBSingleton::getInstance();
		//	$ds = $this->getDataSource();
		$queryResult = $DBInt->ExecQuery($this->getQuery());
		
		//	$userData = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$data = $queryResult->fetchRow(DB_FETCHMODE_ASSOC);
		$rowNr = 0;
		if (count($data)==0)
		{
			$ileKolumn = $this->colCount()+2+count($this->fActions);
			$result .= "<tr class=\"rowDark\"><td width =\"100%\" colspan=\"$ileKolumn\" align=\"center\">--- Brak danych ---</td></tr>";
		}
		else
		do
		{	
			if (($rowNr % 2)==0)
			{	
				$rowColor = "rowDark";
				$bckColor = $this->rowDarkColor;
			}	
			else
			{
				$rowColor = "rowDark";
				$bckColor = $this->rowDarkColor;
			}
			$activeColor = $this->rowActiveColor;
			$result.= "<tr class=\"$rowColor\" onmouseover=this.style.background='$activeColor' onmouseout=this.style.background='$bckColor'>";
				// wiersze - jezeli sa akcje to dodaje <td> akcji
			if ($this->fEditAction != '')
			{
				$idColName = '';
				$idColName = $this->getIdColumnName();
				$colIdValue = $data[$idColName];
				
				
				$editButton = new button(buttonEditIcon, '', $this->fEditAction, $colIdValue);
				if (count($this->argsName)>0)
				{
					for ($i=0;$i<count($this->argsName);$i++)
					{
						$editButton->addOtherActionArgs($this->argsName[$i], $this->argsValues[$i]);	
					}
					
			 } 
			$result.=	"<td align=\"center\">".
							$editButton->show(1, 'gridButton').
						"</td>";
			}
			if ($this->fDelAction != '')
			{
				$idColName = $this->getIdColumnName();
				$colIdValue = $data[$idColName];
				$delButton = new button(buttonDelIcon, '', $this->fDelAction, $colIdValue);
				//	<a href=?a=".$this->fDelAction."&id=".$colIdValue.">
				$result.=	"<td align=\"center\">".
								$delButton->show(1, 'gridButton').
							"</td>";					
			}
			if ($this->fChooseAction != '')
			{
				$idColName = $this->getIdColumnName();
				$colIdValue = $data[$idColName];
				$chooseButton = new button(buttonChooseIcon, '', $this->fChooseAction, $colIdValue);
								
				$result.=	"<td align=\"center\">".
								$chooseButton->show(1, 'gridButton').
							"</td>";					
			}
			if ($this->fCallBackAction != '')
			{
					$idColName = '';
					$idColName = $this->getIdColumnName();
					
					$colValueName = $this->getValueColumnName(); 
					$colValueValue = $data[$colValueName];
					
					if ($idColName == '')
					{
						throw new exception('Nie zainicjalizowana kolumna identyfikacyjna');
					}
					$colIdValue = $data[$idColName];
					$chooseButton = new button(buttonChooseIcon, '', 0, $colValueValue, 1, $this->fCallBackAction);
					$result.=	"<td align=\"center\">".
					$chooseButton->show(1, 'gridButton').
					"</td>";	
			}
			
			if (count($this->fActions) > 0)
				{
					
					$idColName = $this->getIdColumnName();
					$colIdValue = $data[$idColName];
					for ($i=0; $i < count($this->fActions); $i++)
					{
						//echo $this->fActions[$i];
						$button = new button($this->fIcons[$i], '', $this->fActions[$i], $colIdValue);
						
				//	<a href=?a=".$this->fDelAction."&id=".$colIdValue.">
					$result.=	"<td align=\"center\">".
									$button->show(1, 'gridButton').
								"</td>";
					}										
				}
								
			for ($i=0; $i < $this->colCount(); $i++)
			{
				//echo "<br>col";
				$columnName = $this->getColName($i);
				
				if (($columnName != $this->getIdColumnName()) && ($columnName != $this->getValueColumnName()) )
				{
					$fieldValue = $data[$columnName];
					$colAlign = $this->getColAlign($i);
					$result .= "<td align=\"$colAlign\">".$fieldValue.'</td>';
				}
			}
			$result .= "</tr>";
			$id = $data[$this->getIdColumnName()];
			
			if (isset($data[$this->getIdColumnName()]))
				$result .= $this->fillSubGrid($data[$this->getIdColumnName()]);
				
			$rowNr++;
		//	echo $result;
		}
		while ($data = $queryResult->fetchRow(DB_FETCHMODE_ASSOC));

		return $result;	
	
	}
	
	//--------------------------------------------------------------------------------
	
	public function fillGrid($renderHtml)
	{
		if ($this->fRecurseQuery == '')
		{
			return $this->fillGridNormal($renderHtml);	
		}
		else
		{
			return $this->fillGridRecurse();
		}
	}
	public function renderHtmlGrid($onlyCode = 0, $recurse = true, $renderHtml = true)
	{
		$this->recurse = $recurse;
		$width = $this->getGridWidth();
		$gridAlign = $this->getGridAlign();
		$gridTableBegin = "<table class=\"Grid\" width=\"$width\" align=\"$gridAlign\" cellspacing=\"1\" cellpadding=\"0\">";
		$gridTableEnd = '</table>';
		$colCount = $this->colCount();
		$cols = $colCount;
		
		if ($this->fDelAction)
			$cols++;
		if ($this->fEditAction)
			$cols++;
		if ($this->fChooseAction)
			$cols++;
		if ($this->fCallBackAction)
			$cols++;
		if (count($this->fActions)>0)
			$cols += count($this->fActions);
		
			  
		$gridTitle = "<tr class=\"gridTitle\"><td colspan=\"$cols\" width=\"100%\" align=\"center\">";
		$gridTitle .= $this->getTitle().'</td></tr>';
		
		$gridHeader = '<tr class="gridHeader">';
		//echo $this->colCount();
		
		if ($this->fEditAction != '')
		{
			$gridHeader .= '<td width="25" align="center"></td>';
		}
		
		if ($this->fDelAction != '')
		{
			$gridHeader .= '<td width="25" align="center"></td>';
		}
		if ($this->fChooseAction != '')
		{
			$gridHeader .= '<td width="25" align="center"></td>';
		}
		if ($this->fCallBackAction != '')
		{
			$gridHeader .= '<td width="25" align="center"></td>';
		}
		if (count($this->fActions) > 0)
		{
		
			for ($i=0; $i < count($this->fActions); $i++)
			{
				$gridHeader .= '<td width="25" align="center"></td>';
			}
		}
		
		for ($i=0; $i < $colCount; $i++)
		{
			if ( ($this->getColName($i) != $this->getIdColumnName()) && ($this->getColName($i) != $this->getValueColumnName()) ) //jezeli nie jest kol id
			{
				$gridHeader .= '<td width='.$this->getColHeaderWidth($i).'>'.$this->getColHeaderText($i);
				$gridHeader .= '</td>';
			} 
			
		}
		$gridHeader .= '</tr>';
		$gridData = $this->fillGrid($renderHtml);
		
		if ($onlyCode == 0)
		{
			echo $gridTableBegin.$gridTitle.$gridHeader.$gridData.$gridTableEnd;
		}
		else
		{
			return $gridTableBegin.$gridTitle.$gridHeader.$gridData.$gridTableEnd;
		}
	}
}

