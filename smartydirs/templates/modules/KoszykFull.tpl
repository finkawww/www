<!-- sprawdzic za pomoca DOM - forms.elemnts[i] -->
<center>
<div class="bordo">Zawartość koszyka</div><br>
<form name="formularz" action="" method="POST">
<input type="hidden" name="a" value="{$przeliczAct}">
<table align = "center">
	<!-- Pozycje -->
	{foreach from=$pozycje item=pozycjeItem name=pozycje}
	<tr><td>
		<table>
			<tr>
				
				<td rowspan="5"><img src="/FrontPage/Files/ImgShop/{$pozycjeItem->zdjecieMin}" width="100"></td>
				<td align="right"><div class="font">Program:</td><td align="left"><b><div class="font">{$pozycjeItem->nazwaTowaru}</b></td>
				
				<td align="right"><input type="button" value="Usuń" onClick="document.location.href='?a={$usunPozAct}&towarId={$pozycjeItem->id}'"></td>
			</tr>
			<input type="hidden" name="towId{$smarty.foreach.pozycje.index}" value="{$pozycjeItem->id}">
			<tr><td align="right"><div class="font">Szczegóły:</td><td align="left"><div class="font">{$pozycjeItem->opis}</td></tr>
			{if !$rezerwacje}
			<tr><td align="right"><div class="font">Ilość stanowisk:</td><td align="left"><input type="text" size="3" maxLength="3" name="il{$smarty.foreach.pozycje.index}" id="il{$smarty.foreach.pozycje.index}" value="{$pozycjeItem->ilosc}" onChange="checkControls('il{$smarty.foreach.pozycje.index}', 'ilFirm{$smarty.foreach.pozycje.index}')"></td></tr>
			<tr><td align="right"><div class="font">Ilość firm:</td>
			<td align="left">
				<select size="1" name="ilFirm{$smarty.foreach.pozycje.index}" id="ilFirm{$smarty.foreach.pozycje.index}" value="{$pozycjeItem->iloscFirm}">
							<option value="3" {if $pozycjeItem->iloscFirm eq 3}selected{/if}>do 3</option>
							<option value="10" {if $pozycjeItem->iloscFirm eq 10}selected{/if}>4-10</option>
							<option value="20" {if $pozycjeItem->iloscFirm eq 20}selected{/if}>11-20</option>
							<option value="30" {if $pozycjeItem->iloscFirm eq 30}selected{/if}>21-30</option>
							<option value="40" {if $pozycjeItem->iloscFirm eq 40}selected{/if}>31-40</option>
							<option value="50" {if $pozycjeItem->iloscFirm eq 50}selected{/if}>41-50</option>
							<option value="60" {if $pozycjeItem->iloscFirm eq 60}selected{/if}>51-60</option>
							<option value="70" {if $pozycjeItem->iloscFirm eq 70}selected{/if}>61-70</option>
							<option value="80" {if $pozycjeItem->iloscFirm eq 80}selected{/if}>71-80</option>
							<option value="90" {if $pozycjeItem->iloscFirm eq 90}selected{/if}>81-90</option>
							<option value="100" {if $pozycjeItem->iloscFirm eq 100}selected{/if}>91-100</option>
							<option value="110" {if $pozycjeItem->iloscFirm eq 110}selected{/if}>101-110</option>
							<option value="120" {if $pozycjeItem->iloscFirm eq 120}selected{/if}>111-120</option>
							<option value="130" {if $pozycjeItem->iloscFirm eq 130}selected{/if}>121-130</option>
							<option value="140" {if $pozycjeItem->iloscFirm eq 140}selected{/if}>131-140</option>
							<option value="150" {if $pozycjeItem->iloscFirm eq 150}selected{/if}>141-150</option>
							<option value="160" {if $pozycjeItem->iloscFirm eq 160}selected{/if}>151-160</option>
							<option value="170" {if $pozycjeItem->iloscFirm eq 170}selected{/if}>161-170</option>
							<option value="180" {if $pozycjeItem->iloscFirm eq 180}selected{/if}>171-180</option>
							<option value="190" {if $pozycjeItem->iloscFirm eq 190}selected{/if}>181-190</option>
							<option value="200" {if $pozycjeItem->iloscFirm eq 200}selected{/if}>191-200</option>
				</select>
			</td>
			</tr>
			{else}
			<tr><td align="right"><div class="font">Ilość:</td><td align="left"><b><div class="font">{$pozycjeItem->ilosc}</td></tr>
			{/if}
			<tr><td align="right"><div class="font">Cena:</td><td align="left"><div class="font">{$pozycjeItem->cenaNetto}zł + 23%VAT zł = {$pozycjeItem->cenaBrutto}zł</td></tr>
		<hr>
		</table>
	</td></tr>
	{/foreach}
	<!--razem -->
	<tr><td align="right">
		<table>
			<tr><td align="right"><br><div class="font">Podsumowanie zamówienia: </div><br><div class="bordo">{$razem}zł + 23% VAT = {$razemBrutto}zł</div><br></td></tr>
		</table>
	</td></tr>
	<!-- Akcje -->
	<tr><td align="center">
		<table align = "center">
			<tr align = "center">
			{if $backAct ne "-1"}
				<!--<td><input type="button" font color="red" value="Wroc do oferty" onClick="document.location.href='{$backAct}'"></td>-->
				<input type="button" font color="red" value="Wroc do oferty" onClick="document.location.href='?mp=46'">
				
			{/if}
				<td><input type="button" value="Wyczyść" onClick="document.location.href='?a={$wyczyscAct}'"></td>
			{if !$rezerwacje}
				<td><input type="submit" value="Przelicz"></td>
			{/if}
			{if $ilePoz ne 0}
				<td><input type="button" value="Zamow" onClick="document.location.href='?a={$ZamowAct}'"></td>
			{/if}
			
			</tr>
		</table>
	</td></tr>
</table>
</form>
</center>