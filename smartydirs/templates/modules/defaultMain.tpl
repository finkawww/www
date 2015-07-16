
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
    	<link rel="shortcut icon" href="/images/ico/favico.ico" type="image/x-icon" />
    	<TITLE>{$title}</TITLE>
		<script type="text/javascript" src="/FrontPage/JS/scripts.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/jquery-1.2.6.min.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/jquery.cycle.all.pack.js"></script>


    	
    </HEAD>
	<BODY  bgcolor="white">
<script type="text/javascript" src="/FrontPage/JS/cookies.js"></script>
<noscript>
<div style="padding-top: 10px; height: 60px; width: 100%;background: #dddddd;line-height: 24px; 
text-align: center; color: #042E64;font-size: 14px; font-family: sans-serif; font-weight: bold; 
text-shadow: 0 1px 0 #94CAFF;  box-shadow: 0 0 15px #00214B; position: fixed; bottom: 0; z-index: 999">
<div style="text-align: center; margin: auto; width: 960px;line-height: 24px">
Strona korzysta z plik?w cookies w celu realizacji us?ug i zgodnie
z <a style="text-decoration: underline" target="_blank" href="http://www.finka.pl/FrontPage/Files/OtherFiles/polityka_plikow_cookies.pdf">Polityk? Plik?w Cookies</a>.
Mo?esz okre?li? warunki przechowywania lub dost?pu do plik?w cookies w Twojej przegl?darce.
</div>
</div>
</noscript>
<center>
<table class="Content" width="1000px" align="center">
<tr><td width="100%">
	<center>
	<table class="MainTbl" bgcolor="#FFFFFF" align="center" width="100%">

		<tr>
			<td colspan="2" width="1000px" align="left" valign="middle">
				<table width="100%">
				<tr>
				<td align="left">				
					 <img src="/FrontPage/Files/Img/finka_logo.jpg" border="0"/> 	
				</td>
				<td align="right">				
					 <img src="/FrontPage/Files/Img/gorna_belka.jpg" border="0"/> 	
				</td>
				</tr>
				<tr>
					<td colspan="2">				
					  	{$topMenu}{$PokazKoszykStatus}
					</td>
				</tr>
				</table>
			</td>
		</tr>
	<tr>
			<td height="300" width="100%" align="right">
				<table width="1000">	
				<tr>
					<td width="800">
						<div id="banerSlider">
						<a href="?mp=43"><img src="/FrontPage/Files/Img/baner_gora1.jpg" width="800" border="0"/></a>
						<a href="?mp=43"><img src="/FrontPage/Files/Img/baner_gora2.jpg" width="800" border="0"/></a>
						<a href="?mp=43"><img src="/FrontPage/Files/Img/baner_gora3.jpg" width="800" border="0"/></a>
						</div>
					</td>
					<td valign="top">
					<table>
					<tr><td>
					<img src="/FrontPage/Files/Img/kontakt.jpg" border="0" align="left">
					</td></tr>
					<tr><td><{$KontaktHeader}</td></tr>
					</table>
					
				</tr>	
				</table>


					

			</td>	
		</tr>
		<tr>
		
		
			<td valign="top" width = "100" height="450" bgcolor="white" align="center">
				<table width="900">
					
					<tr><td>{$content}</td></tr>
				</table>
			</td>
		<tr>
			<td colspan="1" width="*" align="center">{$menuBottom}</td>
		</tr>
	</table>	
	</center>
</td></tr>
<tr><td width="100%" align="center"><a href="http://www.payu.pl"><img src="./images/banki.jpg" border="0"></td></tr>
</table>
</center>
{literal}
<script type="text/javascript">$('#banerSlider').cycle({fx:'fade',random:1,delay:-300,width:600,height:300});</script> 
{/literal}
							</td></tr>	

   	</BODY>
</HTML>

