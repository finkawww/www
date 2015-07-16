{$txtPowitanie}

<button onClick="document.location.href='?a={$actnZmianaDanych}';">
{$txtZmianaDanych}
</button>

<button onClick="document.location.href='?a={$actnZmianaHasla}';">
{$txtZmianaHasla}
</button>
<br/>

{$txtZamowienia}
<br/>
{foreach from=$zamowienia item=zamowienieItem name=zamowienia}
	<lf>
	{$txtNumerZam}:{$zamowienieItem->numer}<br/>
	{$txtStatus}:{$zamowienieItem->status}<br/>
	{$txtNazwa}:{$zamowienieItem->nazwa}<br/>
	{$txtOpis}:{$zamowienieItem->opis}<br/>
	{$txtAutor}:{$zamowienieItem->autor}<br/>
	{$txtTechnika}:{$zamowienieItem->technika}<br/>
	{$txtRok}:{$zamowienieItem->rok}<br/>
	{$txtRozmiar}:{$zamowienieItem->rozmiar}<br/>
	{$txtCena}:{$zamowienieItem->cena}<br/>
	{$zamowienieItem->obrazMin}<br/>
	
{/foreach}