<center>
<table align = "center" width="530" cellspacing="20">
	<tr><td align="justify" colspan="2"><div class="granat">Podsumowanie zamówienia</div></td></tr>
	<tr><td colspan="2">
	<!-- Pozycje -->
	<table width="100%" border="1" align="ceneter">
	{if $prnRabat}
	<tr>
		<td width="250" align="center"><div class="font"><b>{$txtNazwaTow}</b><div class="font"></td><td align="center"><div class="font"><b>{$txtZdjecieTow}</b></div></td><td width="50" align="center"><div class="font"><b>{$txtIloscTow}</b></div></td><td align="center" width="50"><div class="font"><b>{$txtIloscFirm}</b><div></td><td width="80" align="center"><div class="font"><b>{$txtCenaTow} w PLN</b></div></td><td>Zastosowany rabat (%)</td>
	</tr>
	{foreach from=$pozycje item=printItem name=pozycje}
	
	<tr>
		<td align="center"><div class="font">{$printItem->nazwaTowaru}</div></td>
		<td align="center"><img src="/FrontPage/Files/ImgShop/{$printItem->zdjecieMin}" width="100"/></td>
		<td align="center"><div class="font">{$printItem->ilosc}</div></td>
		<td align="center"><div class="font">{$printItem->iloscFirm}</div></td>
		<td align="center"><div class="font">{$printItem->cenaNetto}</div></td>
		<td align="center"><div class="font">{$printItem->rabat}</div></td>
	</tr>
	{/foreach}
	<tr><td colspan="5" align="left"><div class="granat">{$txtRazem}</div></td><td align="right"><div class="granat">{$razem}</div></td></tr>
	<tr><td colspan="5" align="left"><div class="granat">{$txtRazemBrutto}</div></td><td align="right"><div class="granat">{$razemBrutto}</div></td></tr>
	<tr><td colspan="5" align="left"><div class="font">{$txtFormaDostawy}</div></td><td align="right"><div class="font">{$txtCena}</div></td>
	<tr><td colspan="5" align="left"><div class="font">{$dostawaNazwa}</div></td><td align="right"><div class="font">{$dostawaCena}</div></td>
	<tr><td colspan="5" align="center"><div class="bordo">{$txtWartoscZam} w PLN</div></td><td align="right"><div class="bordo">{$wartoscZam}</div></td></tr>
	</table>
	{else}
	<tr>
		<td width="250" align="center"><div class="font"><b>{$txtNazwaTow}</b><div class="font"></td><td align="center"><div class="font"><b>{$txtZdjecieTow}</b></div></td><td width="50" align="center"><div class="font"><b>{$txtIloscTow}</b></div></td><td align="center" width="50"><div class="font"><b>{$txtIloscFirm}</b><div></td><td width="80" align="center"><div class="font"><b>{$txtCenaTow} w PLN</b></div></td>
	</tr>
	{foreach from=$pozycje item=printItem name=pozycje}
	
	<tr>
		<td align="center"><div class="font">{$printItem->nazwaTowaru}</div></td>
		<td align="center"><img src="/FrontPage/Files/ImgShop/{$printItem->zdjecieMin}" width="100"/></td>
		<td align="center"><div class="font">{$printItem->ilosc}</div></td>
		<td align="center"><div class="font">{$printItem->iloscFirm}</div></td>
		<td align="center"><div class="font">{$printItem->cenaNetto}</div></td>
	</tr>
	{/foreach}
	
	<tr><td colspan="4" align="left"><div class="granat">{$txtRazem}</div></td><td align="right"><div class="granat">{$razem}</div></td></tr>
	<tr><td colspan="4" align="left"><div class="granat">{$txtRazemBrutto}</div></td><td align="right"><div class="granat">{$razemBrutto}</div></td></tr>
	<tr><td colspan="4" align="left"><div class="font">{$txtFormaDostawy}</div></td><td align="right"><div class="font">{$txtCena}</div></td>
	<tr><td colspan="4" align="left"><div class="font">{$dostawaNazwa}</div></td><td align="right"><div class="font">{$dostawaCena}</div></td>
	<tr><td colspan="4" align="center"><div class="bordo">{$txtWartoscZam} w PLN</div></td><td align="right"><div class="bordo">{$wartoscZam}</div></td></tr>
	</table>
	{/if}	
	<!-- Dane osobowe i dane do faktury   -->
	<tr valign="top">
	<td>
		<table border="1" width="265"><tr><td><b><div class="granat">Dane zamawiającego</div></td></tr><tr><td>
		<table>
			<tr><td><div class="font">{$txtImie}:<div></td><td><div class="font">{$imie}</div></td></tr>
			<tr><td><div class="font">{$txtNazwisko}:<div></td><td><div class="font">{$nazwisko}</div></td></tr>
			<tr><td><div class="font">{$txtNipFaktura}:<div></td><td><div class="font">{$NIPFaktura}</div></td></tr>
			<tr><td><div class="font">{$txtUlica}:<div></td><td><div class="font">{$ulica}</div></td></tr>
			<tr><td><div class="font">{$txtNrDomu}:<div></td><td><div class="font">{$nrDomu}</div></td></tr>
			<tr><td><div class="font">{$txtNrMieszkania}:<div></td><td><div class="font">{$nrMieszkania}</div></td></tr>
			<tr><td><div class="font">{$txtKodPocztowy}:<div></td><td><div class="font">{$kodPocztowy}</div></td></tr>
			<tr><td><div class="font">{$txtMiasto}:<div></td><td><div class="font">{$miasto}</div></td></tr>
			<tr><td><div class="font">{$txtEmail}:<div></td><td><div class="font">{$email}</div></td></tr>
			<tr><td><div class="font">{$txtNrTel}:<div></td><td><div class="font">{$nrTel}</div></td></tr>
		</table>
		</td></tr>
		<tr><td align="center"><button onClick = "document.location.href='?a={$poprawOsobActn}&strona={$stronaOsobActn}'"><b><div class="font">{$txtPopraw}</div></b></button></td></tr>
		</table>
	</td>
	<td valign="top">
		<table border="1" width="265"><tr><td><div class="granat">Dane do faktury</div></td></tr><tr><td>
		<table>
			{if $czyFirmaFaktura eq 'T'} 
				<tr><td><div class="font">{$txtNazwaFaktura}:<div></td><td><div class="font">{$nazwaFaktura}</div></td></tr>
			{else}
				<tr><td><div class="font">{$txtImie}:<div></td><td><div class="font">{$imieFaktura}</div></td></tr>
				<tr><td><div class="font">{$txtNazwisko}:<div></td><td><div class="font">{$nazwiskoFaktura}</div></td></tr>
			{/if}
			<tr><td><div class="font">{$txtNipFaktura}:<div></td><td><div class="font">{$NIPFaktura}</div></td></tr>
			<tr><td><div class="font">{$txtUlica}:<div></td><td><div class="font">{$ulicaFaktura}</div></td></tr>
			<tr><td><div class="font">{$txtNrDomu}:<div></td><td><div class="font">{$nrDomuFaktura}</div></td></tr>
			<tr><td><div class="font">{$txtNrMieszkania}:<div></td><td><div class="font">{$nrMieszkaniaFaktura}</div></td></tr>
			<tr><td><div class="font">{$txtKodPocztowy}:<div></td><td><div class="font">{$kodPocztowyFaktura}</div></td></tr>
			<tr><td><div class="font">{$txtMiasto}:<div></td><td><div class="font">{$miastoFaktura}</div></td></tr>
			<tr><td> </td><td></td> </tr>
			<tr><td> </td><td></td> </tr>
		</table>
		</td></tr>
		<tr><td align="center"><button onClick = "document.location.href='?a={$poprawFaktActn}&strona={$stronaFaktActn}'"><b><div class="font">{$txtPopraw}</div></b></button></td></tr>
		</table>
	</td></tr>
	
	<!--platnosci -->
	<tr><td colspan="2">
		<table border="1" width="550"><tr><td align="center"><div class="granat">Pozostałe informacje</div></td></tr><tr><td>
		<table border="1">
			<tr><td width="275"><div class="bordo">Płatność</div></td><td align="center" width="275"><div class="font">{$txtUwagi}</div></td></tr>
			<tr><td align="center"><div class="font">{$nazwaPlatnosci}</div></td><td align="center"><div class="font">{$uwagi}</div></td></tr>
		</table>
		</td></tr>
		<tr><td align="center"><button onClick = "document.location.href='?a={$poprawPozostaleActn}&strona={$stronaPozostaleActn}'"><b><div class="font">{$txtPopraw}</div></b></button></td></tr>
		</table>
	</td></tr>
	<!--przyciski akcji -->
	<tr><td colspan="2" width="550" align="center">
		<button onClick = "document.location.href='?a={$anulujActn}'"><b><div class="font">{$txtAnuluj}</div></b></button>
		<button onClick = "document.location.href='?a={$zatwierdzActn}'"><b><div class="font">{$txtZatwierdz}</div></b></button>
	</td></tr>	
</table>
</center>