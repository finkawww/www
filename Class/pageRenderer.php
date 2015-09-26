<?php

/************************************
 *		Moduł pageRenderer		   	*
 * 	Renderuje stronę (dla frontend)	*
 *	Autor: Piotr Brodziński			*
 *									*
 *									*
 ************************************/

 class pageRenderer
 {
 	//tablica css-ow
 	private $styleSheetsPaths = array();
 	// nazwa szablonu smarty
 	private $templateName = '';
 	// czy dostep jedynie dla autoryzowanych uzytkownikow
 	private $athorizedOnly = 0;
 	
 	private $objContentRenderer = null;
 	private $objMenuRenderer = null;
 	private $objModulesMgr = null;

 	// pobieram parametry strony 
 	private function getPageParams()
 	{
 		
 	}
 	private function assignMetaValues()
 	{
 		$module->loadModule('Config');
		$title = $module->moduleExecuteAction('getMainPageTitle');
		
		assign('title', $title);
 	}
 	private function assignMenu()
 	{
 		assign('left_menu', $this->objMenuRenderer->render(1, 'l'));
		assign('top_menu', $this->objMenuRenderer->render(1, 't'));
		assign('bottom_menu', $this->objMenuRenderer->render(1,'b'));
		assign('right_menu', $this->objMenuRenderer->render(1, 'r')); 
 	}
 	private function assignContent()
 	{
 		assign('page_content', $contentRnd->renderContent($m, $a));
 	}
 	
 	public function __construct()
 	{
 		$this->objContentRenderer = new contentRenderer();
 		$this->objMenuRenderer = new menuRenderer("public");
 		$this->objModulesMgr = new modulesMgr();
 	}
  	public function render()
 	{
 		$this->getPageParams();
 		
 		$smarty = new mySmarty();

 		if ($smarty->template_exists($this->templateName))
		{
			$this->assignMetaValues();
			$this->assignMenu();
			$this->assignContent();
			//wyswietlam
			$smarty->display($this->templateName);
									
		}
		else
		{
			throw new exception("Brak zdefiniowanego szablonu o nazwie $this->templateName");
		}
 	}

 }
?>