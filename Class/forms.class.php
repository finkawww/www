<?php
/*
-------------------------------------------------
Module forms - 
Tworzy instancje formularza, zmienia jego styl 
Created 22.08.2007
Mod: 22.08.2007
Autho: P. Brodzinski
-------------------------------------------------
*/

  require_once '/home4/finka/php/HTML/QuickForm.php';
  require_once '/home4/finka/php/HTML/QuickForm/Renderer/ArraySmarty.php';
  require_once '/home4/finka/php/HTML/QuickForm/Action.php';
  require_once '/home4/finka/php/HTML/QuickForm/Action/Display.php';
//  require_once 'HTML/QuickForm/CAPTCHA.php';
 // require_once 'HTML/QuickForm/CAPTCHA/Figlet.php';  
  class form
  {
  	private $formRef = null;
  	private $renderer;
  	//zmiana stylu formularza
  	public function setStyle($colCount)
  	{
  		// pobieram referencje do DefaultRenderer...
  		if ($colCount == 2)
  		{
  			$this->renderer = &$this->formRef->DefaultRenderer();
  			//... i podmieniam styl (korzystajac z style.css)
  			$this->renderer->setFormTemplate('<table class="QuickFormWindow" border="0"><form{attributes}>{content}</form></table>');
  			$this->renderer->setElementTemplate('<tr><td align="right" class="QuickFormLabel"><!-- BEGIN required --><span style="color: #F00;">*</span><!-- END required -->{label}</td><td class="QuickFormElem" align="left"><!-- BEGIN error --><span style="color: #F00;">{error}</span><br/><!-- END error -->{element}</td></tr>');
  			$this->renderer->setElementTemplate('<tr><td width=100% class="QuickFormButtons" colspan="2">{element}</td></tr>', 'Group');
  			$this->renderer->setHeaderTemplate('<tr><td class="QuickFormHeader" colspan="2">{header}</td></tr>');
	  		$this->renderer->setRequiredNoteTemplate('<tr><td class="QuickFormAlert" colspan="2">Pola oznaczone <span style="color: #F00;">*</span> są wymagane</td></tr>');
  		}
 		
  	}
  	
  	// zwraca referencje do instancji QuickForm
  	public function getFormInstance()
  	{
  		return $this->formRef;
  	}
  	public function __construct($formName, $method='get', $action='')
  	{
  
  		if (isset($this->formRef))
  		{
  			unset($this->formRef);
  			$this->formRef = null;
  		}
  		$this->formRef = new HTML_QuickForm($formName, $method, $action);

  		
 		//$this->setStyle();  		
  	}
  	public function __destruct()
  	{
  		unset($this->formRef);
  	}
  }
  
  class PageForm
  {
  	private $pageRef;
  	
  	public function GetInstance()
  	{
  		return $this->pageRef;
  	}
  	public function __construct($pageName, $method='POST')
  	{
		if (isset($this->pageRef))
  		{
  			unset($this->pageRef);
  			$this->pageRef = null;
  		}
  		$this->pageRef = new HTML_QuickForm_Page($pageName, $method);
  		$this->pageRef->_formBuilt = true;
  		
  	}
  	
  	public function __destruct()
  	{
  		unset($this->pageRef);
  	}
  }
  
  class SmartyDisplay extends HTML_QuickForm_Action_Display
  {
  	private $formName;
  	private $smarty = null;
  	private $renderer;
  	
  	public function __construct($smarty, $formName)
  	{
  		$this->smarty = $smarty;
  		$this->formName = $formName;
  	}
  	
  	public function _renderForm($page)
  	{
  		$this->renderer = &new HTML_QuickForm_Renderer_ArraySmarty($this->smarty);
        $page->accept($this->renderer);
        $this->smarty->assign($this->formName, $this->renderer->toArray());	
  	} 
  	public function GetRenderer()
  	{
  		return $this->renderer;
  	}
  	
  }
  
?>