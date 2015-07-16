<br/>
{$tresc}
<br/><br/>
{$txtDaneZamowienia}

<table>
<tr><td>{$txtNumerZam}:</td><td>{$numerZam}</td></tr>
</table>
{$txtPozycjeZam}:<br/>
<table>
{foreach from=$pozycjeZam item=ZamowieniaItems name=pozycjeZam}
	<tr>
		<td>{$txtNazwaTow}</td><td>{$txtCenaTow}</td><td>{$txtIloscTow}</td>
	</tr>
	<tr>
		<td>{$printItem->nazwaTowaru}</td>
		<td>{$printItem->cena}</td>
		<td>{$printItem->ilosc}</td>
	</tr>
	{/foreach}
</table>

<table>
	<tr><td>{$txtFormaDostawy}</td><td>{$dostawaNazwa}</td></tr>
	<tr><td>{$txtCenaDostawy}</td><td>{$dostawaCena}</td></tr>
	<tr><td><b>{$txtRazem}</b></td><td>{$wartoscZam}</td></tr>
	<tr><td>{$txtFormaPlatnosci}</td><td>{$platnoscNazwa}</td></tr>
</table>

<table>
<tr><td>
		<table>
			<tr><td colspan="2">{$txtDaneDostawy}</td></tr>
			<tr><td>{$txtImie}</td><td>{$imie}</td></tr>
			<tr><td>{$txtNazwisko}</td><td>{$nazwisko}</td></tr>
			<tr><td>{$txtKraj}</td><td>{$kraj}</td></tr>
			<tr><td>{$txtMiasto}</td><td>{$miasto}</td></tr>
			<tr><td>{$txtUlica}</td><td>{$ulica}</td></tr>
			<tr><td>{$txtNrDomu}</td><td>{$nrDomu}</td></tr>
			<tr><td>{$txtNrMieszkania}</td><td>{$nrMieszkania}</td></tr>
			<tr><td>{$txtEmail}</td><td>{$email}</td></tr>
			<tr><td>{$txtKodPocztowy}</td><td>{$kodPocztowy}</td></tr>
			<tr><td>{$txtNrTel}</td><td>{$nrTel}</td></tr>
		</table>
	</td></tr>
	<tr><td>
		<table>
			<tr><td colspan="2">{txtDaneDoFaktury}</td></tr>
			{if $czyFirmaFaktura eq 'T'}
				<tr><td>{$txtNazwa}</td><td>{$nazwaFirmy}</td></tr>
				<tr><td>{$txtNIP}</td><td>{$NIPFaktura}</td></tr>
			{else}
				<tr><td>{$txtImie}</td><td>{$imieFaktura}</td></tr>
				<tr><td>{$txtNazwisko}</td><td>{$nazwiskoFaktura}</td></tr>
	{/if}
	
			<tr><td>{$txtKraj}</td><td>{$krajFaktura}</td></tr>
			<tr><td>{$txtMiasto}</td><td>{$miastoFaktura}</td></tr>
			<tr><td>{$txtUlica}</td><td>{$ulicaFaktura}</td></tr>
			<tr><td>{$txtNrDomu}</td><td>{$nrDomuFaktura}</td></tr>
			<tr><td>{$txtNrMieszkania}</td><td>{$nrMieszkaniaFaktura}</td></tr>
			<tr><td>{$txtKodPocztowy}</td><td>{$kodPocztowyFaktura}</td></tr>
		</table>
	</td></tr>
</table>
<br>
<font face="arial" size="2">Dzia³ Obs³ugi Klienta<br>
<b>TIK-SOFT Sp. z o.o.</b><br>
Aleja Wilanowska 5 lok.19, 02-765 Warszawa<br>
tel. (22) 408 48 00, fax: (22) 408 48 00 w. 107<br>
e-mail: <u>finka@finka.pl</u>,
   <a href="http://www.finka.pl">www.finka.pl</a><br>
S¹d Rej. dla m. st. Warszawy, XIII Wydzia³ Gospodarczy<br>
KRS 0000170845, Kapita³ zak³adowy: 1 132 200,00 PLN
</font>