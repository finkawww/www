<?php

/*DEFINE('buttonAddIcon', '../Cms/Files/Img/add-16x16.png');
DEFINE('buttonBackIcon', '../Cms/Files/Img/back-16x16.png');
DEFINE('buttonEditIcon', '../Cms/Files/Img/stock_edit-16.png');
DEFINE('buttonDelIcon', '../Cms/Files/Img/stock_delete-16.png');
DEFINE('buttonChooseIcon', '../Cms/Files/Img/accept-16x16.png');*/

class button
{
	private $fIcon;
	private $fText;
	private $fAction = -1;
	private $fIdParam = -1;
	private $callBack = 0;
	private $actionText = '';
	protected $argsName = array();
	
	protected $argsValues = array();  
	
	public function __construct($icon, $text, $action, $idParam, $callBack = 0, $actionText = '')
	{
		$this -> fIcon = $icon;
		$this -> fText = $text;
		$this -> fAction = $action;
		$this -> fIdParam = $idParam;
		$this->callBack = $callBack;
		$this->actionText = $actionText;
	}
	public function addOtherActionArgs($argName, $argValue)
	{
		$this -> argsName[count($this -> argsName)] = $argName;
		$this -> argsValues[count($this -> argsValues)] = $argValue;
	}
	public function show($onlyCode = 0, $buttonStyle = '')
	{
		if ($this->fIdParam > -1) 
		{
			$actnText = "a=" . $this->fAction . "&id=" . $this->fIdParam;
		}
		else
		{
			$actnText = "a=" . $this->fAction;
		}
		
		if (count($this->argsName) > 0)
		{
			for ($i=0; $i<count($this->argsName); $i++)
			{
				$actnText .='&'.$this->argsName[$i].'='.$this->argsValues[$i];
			}  
		}
		
		if ($this->fIcon != '')
		{
			$iconText = "<img src=\"$this->fIcon\" height=\"16\" border=\"0\" />";
		}
		else
		{
			$iconText = '';
		}
		
		if ($this->fText !='')
		{
			$textText = $this->fText;
		}
		else
		{
			$textText = '';
		}
		
		if ($this->fAction > -1)
		{
		  if ($this->callBack != 0)
		  {
		  	
		  	$buttonAction = "onClick=\"$this->actionText='$this->fIdParam';window.close();\"";
		  }
		  else
		  {
		  	$buttonAction = "onClick=\"document.location.href='?".$actnText."';\"";
		  }
		}
		else
		{
			$buttonAction = '';
		}

		if ($buttonStyle == '')
			$buttonStyle = 'defaultButton';
		
					
		$smarty = new mySmarty();
		$smarty -> assign('buttonAction', $buttonAction);
		$smarty -> assign('iconText', $iconText);
		$smarty -> assign('textText', $textText);
		$smarty -> assign('buttonStyle', $buttonStyle);
		
		if ($onlyCode == 0)
		{ 
			$smarty -> display('cms/button.tpl');
		}
		else
		{
			$a = '';
			$a = $smarty -> fetch('cms/button.tpl');
			return $a;
		}
	
	}
}
?>