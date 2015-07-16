{$tresc}

{$txtDaneZamowienia}


{$txtNumerZam}: {$numerZam}

{$txtPozycjeZam}:

{foreach from=$pozycjeZam item=ZamowieniaItems name=pozycjeZam}
	{$txtNazwaTow}: {$ZamowieniaItems->nazwaTowaru}
	{$txtCenaTow}: {$ZamowieniaItems->cena_poz}
	{$txtIloscStan}: {$ZamowieniaItems->ilosc_stan}
	{$txtIloscFirm}: {$ZamowieniaItems->ilosc_firm}
	{/foreach}

	
{$txtFormaDostawy}: {$dostawaNazwa}
{$txtCenaDostawy}(brutto): {$dostawaCena}
{$txtRazem}(brutto): {$wartoscZam}
{$txtFormaPlatnosci}: {$platnoscNazwa}

{$txtDaneDostawy}

{$txtImie}: {$imie}
{$txtNazwisko}: {$nazwisko}
{$txtKraj}: {$kraj}
{$txtMiasto}: {$miasto}
{$txtUlica}: {$ulica}
{$txtNrDomu}: {$nrDomu}
{$txtNrMieszkania}: {$nrMieszkania}
{$txtEmail}: {$email}
{$txtKodPocztowy}: {$kodPocztowy}
{$txtNrTel}: {$nrTel}
	
{$txtDaneDoFaktury}		

{if $czyFirmaFaktura eq 'T'}
{$txtNazwaFaktura}: {$nazwaFaktura}
{$txtNipFaktura}: {$NIPFaktura}
{else}
{$txtImieFaktura}: {$imieFaktura}
{$txtNazwiskoFaktura}: {$nazwiskoFaktura}
{/if}
{$txtKraj}: {$krajFaktura}
{$txtMiasto}: {$miastoFaktura}
{$txtUlica}: {$ulicaFaktura}
{$txtNrDomu}: {$nrDomuFaktura}
{$txtNrMieszkania}: {$nrMieszkaniaFaktura}
{$txtKodPocztowy}: {$kodPocztowyFaktura}


Dzia³ Obs³ugi Klienta
---------------------
TIK-SOFT Sp. z o.o. 
Aleja Wilanowska 5 lok.19, 02-765 Warszawa
tel. (22) 408 48 00, fax: (22) 408 48 00 w. 107
e-mail:  finka@finka.pl,    www.finka.pl
S¹d Rej. dla m. st. Warszawy, XIII Wydzia³ Gospodarczy
KRS 0000170845, Kapita³ zak³adowy: 1 132 200,00 PLN 
