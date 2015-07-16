<div class="bordo">{$nazwaGrupy}</div>
{foreach from=$grupy item=grupaItem name=grupy}
<br/>
<b>{$grupaItem->nazwaOferty}</b>
<table align="center">
    <tr><td width="300"><div class="font"><b>Opis</b></td><td width="40" align="center"><div class="font"><b>Ilość egz</b></td><td width="20" align="center"><div class="font" align="center"><b>Ilość firm</b></td><td width="80" align="center"><div class="font"><b>Cena</b></td>{if ($rabat)}<td width="80" align="center"><div class="font"><b>Cena po rabacie</b></div></td>{/if}<td align="center" width="50"><div class="font"><b>Kup</b></td></tr>
{foreach from=$towar item=towarItem name=towar}
	{if $towarItem->idOferty eq $grupaItem->idOferty}
	<tr>
		<td>{$towarItem->opisTowaru}</td>
		<td align="right"><div class="font"><input type="edit"  size="3" maxlength="3" value="1" id="egz{$towarItem->idTowaru}"
							onChange="
								checkControls('egz{$towarItem->idTowaru}', 'firmy{$towarItem->idTowaru}');
								{if $towarItem->algCeny eq 0}
								calculatePriceLocal('cena{$towarItem->idTowaru}',{$towarItem->cenaTowaru}, this.value, document.getElementById('firmy{$towarItem->idTowaru}').value);
                                                                {if $rabat}
                                                                calculatePriceLocalParams('cena{$towarItem->idTowaru}Params',{$towarItem->cenaTowaru}, this.value, document.getElementById('firmy{$towarItem->idTowaru}').value, {$param1Zwykl}, {$param2Zwykl});
                                                                {/if}
								{else}
								calculatePriceNet('cena{$towarItem->idTowaru}',{$towarItem->cenaTowaru}, this.value, document.getElementById('firmy{$towarItem->idTowaru}').value);
                                                                {if $rabat}                                                                    
                                                                    calculatePriceNetParams('cena{$towarItem->idTowaru}Params',{$towarItem->cenaTowaru}, this.value, document.getElementById('firmy{$towarItem->idTowaru}').value, {$param1Net}, {$param2Net});
                                                                {/if}
								{/if}
								updateAction('addAct{$towarItem->idTowaru}', 
											{$towarItem->actionDoKoszyka}, 
											{$towarItem->idTowaru},
											this.value,
											document.getElementById('firmy{$towarItem->idTowaru}').value)"/></td>
		<td align="right"><select size="1" id="firmy{$towarItem->idTowaru}"
							onChange="
								checkControls('egz{$towarItem->idTowaru}', 'firmy{$towarItem->idTowaru}');
								{if $towarItem->algCeny eq 0}
								calculatePriceLocal('cena{$towarItem->idTowaru}',{$towarItem->cenaTowaru}, document.getElementById('egz{$towarItem->idTowaru}').value, this.value);
                                                                {if $rabat}
                                                                calculatePriceLocalParams('cena{$towarItem->idTowaru}Params',{$towarItem->cenaTowaru},  document.getElementById('egz{$towarItem->idTowaru}').value, this.value, {$param1Zwykl}, {$param2Zwykl});
                                                                {/if}
								{else}
								calculatePriceNet('cena{$towarItem->idTowaru}',{$towarItem->cenaTowaru}, document.getElementById('egz{$towarItem->idTowaru}').value, this.value);
                                                                {if $rabat}                                                                    
                                                                    calculatePriceNetParams('cena{$towarItem->idTowaru}Params',{$towarItem->cenaTowaru}, document.getElementById('egz{$towarItem->idTowaru}').value, this.value, {$param1Net}, {$param2Net});
                                                                {/if}
								{/if}
								updateAction('addAct{$towarItem->idTowaru}', 
											{$towarItem->actionDoKoszyka}, 
											{$towarItem->idTowaru},
											document.getElementById('egz{$towarItem->idTowaru}').value,
											this.value)">
							<option value="3" selected>do 3</option>
							<option value="10">4-10</option>
							<option value="20">11-20</option>
							<option value="30">21-30</option>
							<option value="40">31-40</option>
							<option value="50">41-50</option>
							<option value="60">51-60</option>
							<option value="70">61-70</option>
							<option value="80">71-80</option>
							<option value="90">81-90</option>
							<option value="100">91-100</option>
							<option value="110">101-110</option>
							<option value="120">111-120</option>
							<option value="130">121-130</option>
							<option value="140">131-140</option>
							<option value="150">141-150</option>
							<option value="160">151-160</option>
							<option value="170">161-170</option>
							<option value="180">171-180</option>
							<option value="190">181-190</option>
							<option value="200">191-200</option>	
						</select>			
		</td>
		<td align="right"><span id="cena{$towarItem->idTowaru}" class="font">{$towarItem->cenaTowaruFormatted}</span></td>
                {if $rabat}
                <td align="right"><span id="cena{$towarItem->idTowaru}Params" class="font">{$towarItem->cena2TowaruFormatted}</span></td>
                {/if}
		<td align="center"><span id="addAct{$towarItem->idTowaru}"><a href="?a={$towarItem->actionDoKoszyka}&towarId={$towarItem->idTowaru}"><img src="/FrontPage/Files/Img/koszyk_small.jpg" border="0"/></a></span></td>
	</tr>
	{/if}
{/foreach}
<table>
{/foreach}

