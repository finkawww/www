<br/>
{$tresc}
<br/><br/>
{$txtDaneZamowienia}

<table>
<tr><td>{$txtNumerZam}:</td><td>{$numerZam}</td></tr>
</table>
<br/>
<table width="500" border="1">

	<tr>
		<td width="250" align="left">{$txtNazwaTow}</td><td width="83" align="right">{$txtCenaTow}</td><td width="83" align="right">{$txtIloscStan}</td><td width="83" align="right">{$txtIloscFirm}</td>
	</tr>
{foreach from=$pozycjeZam item=ZamowieniaItems name=pozycjeZam}
	<tr>
		<td width="250" align="left">{$ZamowieniaItems->nazwaTowaru}</td>
		<td width="83" align="right">{$ZamowieniaItems->cena_poz}</td>
		<td width="83" align="right">{$ZamowieniaItems->ilosc_stan}</td>
		<td width="83" align="right">{$ZamowieniaItems->ilosc_firm}</td>
	</tr>
	{/foreach}
</table>

<table>
	<tr><td>{$txtFormaDostawy}: {$dostawaNazwa}</td></tr>
	<tr><td>Koszt dostawy(brutto) : {$dostawaCena}zl</td></tr><br>
	<tr><td><b><u>{$txtRazem}(brutto): {$wartoscZam}zl</u></b></td></tr>
	<tr><td><b>{$platnoscNazwa}</b><br></td></tr>
</table>

<table>
<tr><td>
		<table>
			<tr><td colspan="2"><u>{$txtDaneDostawy}</u></td></tr>
			<tr><td>{$txtImie} i {$txtNazwisko}:</td><td>{$imie} {$nazwisko}</td></tr>
			<tr><td>{$txtUlica}:</td><td>{$ulica} {$nrDomu}/{$nrMieszkania}</td></tr>
			<tr><td>{$txtKodPocztowy}:</td><td>{$kodPocztowy}</td></tr>
			<tr><td>{$txtMiasto}:</td><td>{$miasto}</td></tr>
			<tr><td>{$txtEmail}:</td><td>{$email}</td></tr>
			<tr><td>{$txtNrTel}:</td><td>{$nrTel}</td></tr>
		</table>
	</td></tr>
	<tr><td>
		<table>
			<tr><td colspan="2"><u>{$txtDaneDoFaktury}</u></td></tr>
			{if $czyFirmaFaktura eq 'T'}
				<tr><td>{$txtNazwaFaktura}:</td><td>{$nazwaFaktura}</td></tr>
				<tr><td>{$txtNipFaktura}:</td><td>{$NIPFaktura}</td></tr>
			{else}
				<tr><td>{$txtImieFaktura}, {$txtNazwiskoFaktura}:</td><td>{$imieFaktura} {$nazwiskoFaktura}</td></tr>
			{/if}
	
			<tr><td>{$txtUlica}:</td><td>{$ulicaFaktura} {$nrDomuFaktura}/{$nrMieszkaniaFaktura}</td></tr>
			<tr><td>{$txtKodPocztowy}:</td><td>{$kodPocztowyFaktura}</td></tr>
			<tr><td>{$txtMiasto}:</td><td>{$miastoFaktura}</td></tr>
		</table>
	</td></tr>
</table>
<br>
<font face="arial" size="2">Dział Obsługi Klienta<br>
<b>TIK-SOFT Sp. z o.o.</b><br>
Aleja Wilanowska 5 lok.19, 02-765 Warszawa<br>
tel. (22) 408 48 00, fax: (22) 408 48 00 w. 107<br>
e-mail: <u>finka@finka.pl</u>,
   <a href="http://www.finka.pl">www.finka.pl</a><br>
Sąd Rej. dla m. st. Warszawy, XIII Wydział Gospodarczy<br>
KRS 0000170845, Kapitał zakładowy: 1 132 200,00 PLN
</font>