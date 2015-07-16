<HTML>
	<HEAD>
    	<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8" />
    	<META NAME="Keywords" CONTENT="{$keywords}" />
    	<META HTTP-EQUIV="Content-Language" CONTENT="PL" />
    	<META NAME="Author" CONTENT="{$author}" />
    	<META NAME="Robots" CONTENT="{$robots}" />
    	<META HTTP-EQUIV="Pragma" CONTENT="{$cache}" />
    	<META NAME="Description" CONTENT="{$desc}" />
    	<LINK REL="Shortcut icon" HREF="{$ikona}" />
    	<LINK REL="Stylesheet" HREF="/FrontPage/Style/style.css" TYPE="text/css" />
    	<TITLE>{$title}</TITLE>

    </HEAD>
	<BODY>
		<DIV id="wrapperAll">
			<DIV id="wrapperHeader">
				<span class="txt">wrapperHeader</span>
			</DIV>
			<DIV id="wrapperTopMenu">
				{$topMenu}
			</DIV>
			<DIV id="wrapperColLeft">
				{$leftMenu}
			</DIV>
			<DIV id="wrapperContent">
				{$content}
			</DIV>
			<DIV id="wrapperColRight">
				{$menuRight}
			</DIV>
			<DIV id="wrapperFooter">
				{$menuBottom}
			</DIV>
		</DIV>		
  	</BODY>
</HTML>

