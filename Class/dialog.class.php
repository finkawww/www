<?php


class dialog
{
	private $fTitle = '';
	private $fText = '';
	private $fKind = '';
	private $fWidth = 0;
	private $fHeight = 0;
	private $fOkAction = '';
	private $fCancelAction = '';
        private $fOtherAction = '';
	private $fOkCaption = 'OK';
	private $fCancelCaption = 'Anuluj';
        private $fOtherCaption = 'Other';
	private $fIcon = '';
	private $fId = -1;
	private $fAlign = "left"; 
			
	public function __construct($title, $text, $kind, $width, $height)
	{
		$this->fTitle = $title;
		$this->fText = $text;
		$this->fKind = $kind;
		$this->fWidth = $width;
		$this->fHeight = $height;
		if ($kind == 'query')
		{
			 $this->fIcon = '../Cms/Files/Img/help-48x48.png';
		}
		else if ($kind == 'alert')
		{
			$this->fIcon = '../Cms/Files/Img/delete-48x48.png';
		}
		else
		{
			$this->fIcon = '../Cms/Files/Img/info-48x48.png'; 
		}
	}
	
	public function setOkAction($action)
	{
		$this->fOkAction = $action;		
	}
	public function setCancelAction($action)
	{
		$this->fCancelAction = $action;
	}
	public function setOkCaption($caption)
	{
		$this->fOkCaption = $caption;
	}
        public function setOtherAction($action)
	{
		$this->fOtherAction = $action;		
	}
        public function setOtherCaption($caption)
	{
		$this->fOtherCaption = $caption;
	}
	public function setCancelCaption($caption)
	{
		$this->fCancelCaption = $caption;		
	}
	public function setId($id)
	{
		$this->fId = $id;
	}
	public function setAlign($align)
	{
		$this->fAlign = $align;
	}
	public function show($html = 1)
	{
		$iconColWidth = 50; 
		$width = $this->fWidth - $iconColWidth; 
		$result="<br/><table class=\"DialogWindow\" align=\"$this->fAlign\" border=0 width=\"$this->fWidth\" height=\"$this->fHeight\">".
				"<tr>".
					"<td colspan=\"2\" class=\"DialogHeader\">$this->fTitle</td>".
				"</tr>".
				"<tr>".
					"<td class=\"DialogContent\" width=\"10\" align=\"center\" border=\"1\"><img src=\"$this->fIcon\" border=\"0\" /></td>".
					"<td class=\"DialogContent\" width=\"$width\" align=\"left\">$this->fText</td>".
				"</tr>".	
				"<tr>".
					"<td colspan=\"2\" class=\"DialogButtons\" height=\"10\">";
					if ($this->fCancelAction != '')
					{		
						$cancelButton = new button('', $this->fCancelCaption, $this->fCancelAction, $this->fId);
						$result .= $cancelButton->show(1);
					}
					if ($this->fOkAction != '')
					{
						$okButton = new button('', $this->fOkCaption, $this->fOkAction, $this->fId);
						$result .= $okButton->show(1);		
					}
                                        if ($this->fOtherAction != '')
					{
						$otherButton = new button('', $this->fOtherCaption, $this->fOtherAction, $this->fId);
						$result .= $otherButton->show(1);		
					}
										
		$result.= 	"</td></tr>".
					"</table>";
		if ($html == 1)
			return $result;
		else
			echo $result;
	}
}
