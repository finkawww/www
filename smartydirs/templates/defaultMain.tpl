
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
	<table class="MainTbl" bgcolor="#FFFFFF" align="center" >

		<tr>
			<td colspan="2" width="1000px" >
				<table width="100%" >
				<tr>
				<td>				
					 <a href="/"><img src="/FrontPage/Files/Img/finka_logo.jpg" border="0"/></a> 	
				</td>
				
				<td align="center">				
					<a href="https://www.facebook.com/programyFINKA"><img src="/FrontPage/Files/Img/fb_finka.png" border="0" title="Dołącz do fanów Tik-Soft na FaceBook'u"></a>	
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
			<td height="266" width="100%" align="center">
				<table width="1000px">	
				<tr>
					<td align="right" width="800px">
						<div id="banerSlider" style="text-align: right; display: block;">
						    <a href="./Promocje.htm"><img src="/FrontPage/Files/Img/baner_nowe_firmy_big.png" width="800" border="0"/></a>		
                                                    <a href="./Programy.htm"><img src="/FrontPage/Files/Img/baner_gora1.jpg" width="800" border="0"/></a>
                                                    <a href="./WersjeProbne.htm"><img src="/FrontPage/Files/Img/baner_gora3.jpg" width="800" border="0"/></a>
						</div>
					</td>
					<td valign="top" width="200px">
					<table width="200px" align="right">
						<tr><td>
							<div class="font_sm"><big>Nasi Konsultanci</big><br /> 22 408 48 00<br />22 885 66 99
							</div>
						</td></tr>
						<tr><td>
							<div class="font_sm">
							{$KontaktHeader}
<br/><br/>
							</div>
						</td></tr>
					</table>
                                        </td>
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
		</tr>
		<tr>
			<td colspan="2" width="*" align="center">{$menuBottom}</td>
		</tr>
	</table>	
	</center>
</td></tr>
<tr><td width="100%" align="center"><a href="http://www.payu.pl"><img src="./images/banki.jpg" border="0"></td></tr>
</table>
</center>
{literal}
<script type="text/javascript">$('#banerSlider').cycle({fx:'fade',random:1,delay:-300,width:800,height:266});</script> 
{/literal}
							</td></tr>	

   	</BODY>
</HTML>

