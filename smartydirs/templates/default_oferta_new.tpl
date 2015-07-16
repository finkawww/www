
<HTML>
	<HEAD>
    	<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8" />
    	<META NAME="Keywords" CONTENT="{$keywords}" />
    	<META HTTP-EQUIV="Content-Language" CONTENT="PL" />
    	<META NAME="Author" CONTENT="{$author}" />
    	<META NAME="Robots" CONTENT="{$robots}" />
    	<META HTTP-EQUIV="Pragma" CONTENT="{$cache}" />
    	<META NAME="Description" CONTENT="{$desc}" />
    	<link rel="shortcut icon" href="/images/ico/favico.ico" type="image/x-icon" />
    	<LINK REL="Stylesheet" HREF="/FrontPage/Style/style.css" TYPE="text/css" />
    	<TITLE>{$title}</TITLE>
		<script type="text/javascript" src="/FrontPage/JS/scripts.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/prototype.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/scriptaculous.js?load=effects,builder"></script>
		<script type="text/javascript" src="/FrontPage/JS/lightbox.js"></script>
		<link rel="stylesheet" href="/FrontPage/JS/css/lightbox.css" type="text/css" media="screen" />

		<link rel="stylesheet" type="text/css" href="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.css" /> 
		<script type="text/javascript" src="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.pack.js"></script> 
    	<script type="text/javascript" src="/FrontPage/JS/scripts.js"></script>
<script type="text/javascript" src="/FrontPage/JS/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/jquery.cycle.all.pack.js"></script>	

    </HEAD>
	<BODY  bgcolor="white">
		{literal}
	<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TH7HWQ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TH7HWQ');</script>
<!-- End Google Tag Manager -->
{/literal}
<center>
<table class="Content" width="100%" align="center">
<tr><td width="100%">
	<center>
	<table class="MainTbl" bgcolor="#FFFFFF" align="center" width="1000px">
		
		<tr>
			<td colspan="2" width="100%" align="left" valign="middle">
			<table width="100%">
				<tr>
				<td align="left">				
					 <a href="/"><img src="/FrontPage/Files/Img/finka_logo.jpg" border="0"/></a> 	
				</td>
				<td align="center">				
					<a href="https://www.facebook.com/programyFINKA"><img src="/FrontPage/Files/Img/fb_finka.png" border="0" title="Dołącz do fanów Tik-Soft na FaceBook'u"></a>	
				</td>
				</tr>
				<tr>
					<td colspan="2">				
						{$topMenu}<font face="Tahoma" font color="#454545">{$PokazKoszykStatus}
					</td>
				</tr>
				</table>
			</td>
		</tr>
<!--
		<tr>
			<td colspan="3" >
			<div class="pics" id="banerSlider">
					<a href="./Programy.htm"><img src="/FrontPage/Files/Img/baner_gora1.jpg" width="800" border="0"/></a>
					<a href="./Promocje.htm"><img src="/FrontPage/Files/Img/baner_gora2.jpg" width="800" border="0"/></a>
					<a href="./WersjeProbne.htm"><img src="/FrontPage/Files/Img/baner_gora3.jpg" width="800" border="0"/></a>			
			</div>
			</td>	
			<td valign="top"><img src="/FrontPage/Files/Img/kontakt.jpg" border="0"></td>
		</tr>
-->		

		<tr><td></td></tr>
		<tr><td></td></tr>
		<tr>
			<td valign="top" width="210px">	
				<table align="left">
					<tr><td width="210px">
					{$leftMenu}<br>
					</td></tr>
					<tr><td align="left">
						<div class="font_sm"><big>Pakiet OPIEKI POSPRZEDAŻNEJ:<div/>
						<div class="font_sm" align="left">
						<font color="grey" size="2" style="tahoma">
						
						<ul>W cenie zakupu programu przez 12 miesięcy:
							<li>terminowe aktualizacje prawne i funkcjonalne</li>
							<li>wsparcie techniczne <br>i merytoryczne</li>
							<li>system pomocy Help</li>
							<li>wdrożenia i szkolenia</li>
						</ul>
						</div>
				</table>

				<table align="left">
					<tr><td width="210px">
					{$leftMenu}<br>
					</td></tr>
					<tr><td align="left">
						<div class="font_sm">	
						<a align="left" class="jump" href="./Uslugi_abonamentowe.htm"> <img src="./FrontPage/Files/Img/ikona_firma.png">Opieka posprzedażna więcej</a></br>
						<a align="left" class="jump" href="./O_firmie.htm"> <img src="./FrontPage/Files/Img/ikona_firma.png">O firmie TIK-SOFT</a></br>
						<a align="left" class="jump" href="./KontaktONAS.htm"> <img src="./FrontPage/Files/Img/ikona_kontakt.png">Kontakt z Konsultantem</a></br>
						</FONT>
						</div>
				</table>		
			</td>
		
		
			<td valign="top" width ="610px" height="500" bgcolor="white">
				<table>
					
					<tr><td>{$content}</td></tr>
				</table>
			</td>
		
	</table>	
	</center>
</td></tr>
<tr>
<td colspan="2" width="*" align="center"><br>{$menuBottom}</td>
</tr>
<tr><td width="100%" align="center" colspan="2"><a href="http://www.payu.pl"><img src="./images/banki.jpg" border="0"></a></td></tr>
</table>
</center>
{literal}
<script type="text/javascript">$('#banerSlider').cycle({fx:'fade',random:1,delay:-300,width:1000,height:300});</script> 
{/literal}
							
   	</BODY>
</HTML>






<HTML>
	<HEAD>
    	<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8" />
    	<META NAME="Keywords" CONTENT="{$keywords}" />
    	<META HTTP-EQUIV="Content-Language" CONTENT="PL" />
    	<META NAME="Author" CONTENT="{$author}" />
    	<META NAME="Robots" CONTENT="{$robots}" />
    	<META HTTP-EQUIV="Pragma" CONTENT="{$cache}" />
    	<META NAME="Description" CONTENT="{$desc}" />
    	<link rel="shortcut icon" href="/images/ico/favico.ico" type="image/x-icon" />
    	<LINK REL="Stylesheet" HREF="/FrontPage/Style/style.css" TYPE="text/css" />
    	<TITLE>{$title}</TITLE>
		<script type="text/javascript" src="/FrontPage/JS/scripts.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/prototype.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/scriptaculous.js?load=effects,builder"></script>
		<script type="text/javascript" src="/FrontPage/JS/lightbox.js"></script>
		<link rel="stylesheet" href="/FrontPage/JS/css/lightbox.css" type="text/css" media="screen" />

		<link rel="stylesheet" type="text/css" href="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.css" /> 
		<script type="text/javascript" src="/FrontPage/JS/fancybox/jquery.fancybox-1.3.4.pack.js"></script> 
    	<script type="text/javascript" src="/FrontPage/JS/scripts.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/jquery-1.2.6.min.js"></script>
		<script type="text/javascript" src="/FrontPage/JS/jquery.cycle.all.pack.js"></script>	
    </HEAD>
	<BODY  bgcolor="white">
<center>
<table class="Content" width="100%" align="center">
<tr><td width="100%">
	<center>
	<table class="MainTbl" bgcolor="#FFFFFF" align="center" width="1000px">
		
		<tr>
			<td colspan="2" width="100%" align="left" valign="middle">
			<table width="100%">
				<tr>
				<td align="left">				
					 <a href="?mp=43"><img src="/FrontPage/Files/Img/finka_logo.jpg" border="0"/></a> 	
				</td>
				<!--
				<td align="right">				
					<a href="/Zmiany_VAT.htm"><img src="/FrontPage/Files/Img/gorna_belka.jpg" border="0"/></a> 	
				</td>
				-->
				</tr>
				<tr>
					<td colspan="2">				
						{$topMenu}<font face="Tahoma" font color="#454545">{$PokazKoszykStatus}
					</td>
				</tr>
				</table>
			</td>
		</tr>
<!--
		<tr>
			<td colspan="3" >
			<div class="pics" id="banerSlider">
					<a href="?mp=43"><img src="/FrontPage/Files/Img/baner_gora1.jpg" width="800" border="0"/></a>
					<a href="?WersjeProbne.htm"><img src="/FrontPage/Files/Img/baner_gora2.jpg" width="800" border="0"/></a>
					<a href="?mp=43"><img src="/FrontPage/Files/Img/baner_gora3.jpg" width="800" border="0"/></a>			
			</div>
			</td>	
			<td valign="top"><img src="/FrontPage/Files/Img/kontakt.jpg" border="0"></td>
		</tr>
-->		

		<tr><td></td></tr>
		<tr><td></td></tr>
		<tr>
			<td valign="top" width="210px">	
				<table>
					<tr><td width="210px">
					{$leftMenu}<br>
					</td></tr>
					<tr><td>
						<div class="font_sm"><big>Pakiet OPIEKI POSPRZEDAŻNEJ:</big><br /></div>
						<div class="font">
						<ul>
							<li>terminowe aktualizacje prawne i funkcjonalne</li>
							<li>wsparcie techniczne i merytoryczne</li>
							<li>system pomocy Help</li>
							<li>wdrożenia i szkolenia</li>
						</ul>	
						<a class="jump" href="./"> <img src="./FrontPage/Files/Img/ikona_firma.png">Opieka posprzedażna więcej</a></br>
						<a class="jump" href="./"> <img src="./FrontPage/Files/Img/ikona_firma.png">O firmie TIK-SOFT</a></br>
						<a class="jump" href="./"> <img src="./FrontPage/Files/Img/ikona_firma.png">Kontakt z Konsultantem</a></br>
						</div>
					</td></tr>
				</table>	
			</td>
		
		
			<td valign="top" width ="610px" height="500" bgcolor="white">
				<table>
					
					<tr><td>{$content}</td></tr>
				</table>
			</td>
		
	</table>	
	</center>
</td></tr>
<tr>
<td colspan="2" width="*" align="center"><br>{$menuBottom}</td>
</tr>
<tr><td width="100%" align="center" colspan="2"><a href="http://www.payu.pl"><img src="./images/banki.jpg" border="0"></a></td></tr>
</table>
</center>
{literal}
<script type="text/javascript">$('#banerSlider').cycle({fx:'fade',random:1,delay:-300,width:1000,height:300});</script> 
{/literal}
							
   	</BODY>
</HTML>

