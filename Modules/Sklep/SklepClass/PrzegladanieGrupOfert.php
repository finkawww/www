<?php
class PrzegladanieGrupOfert
{
	private $GrupaOfertView = null;
	
	public function ShowGrupyOfert()
	{
		$this->GrupaOfertView = new GrupaOfertView();
		return $this->GrupaOfertView->Show();
	}
	
}
