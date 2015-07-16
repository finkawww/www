<?php /* Smarty version 2.6.17, created on 2013-10-20 12:48:46
         compiled from modules/ZamowieniePotwierdzenieForm.tpl */ ?>
﻿<center>
<table align = "center" width="530" cellspacing="20">
	<tr><td align="justify" colspan="2"><div class="granat">Podsumowanie zamówienia</div></td></tr>
	<tr><td colspan="2">
	<!-- Pozycje -->
	<table width="100%" border="1" align="ceneter">
	<?php if ($this->_tpl_vars['prnRabat']): ?>
	<tr>
		<td width="250" align="center"><div class="font"><b><?php echo $this->_tpl_vars['txtNazwaTow']; ?>
</b><div class="font"></td><td align="center"><div class="font"><b><?php echo $this->_tpl_vars['txtZdjecieTow']; ?>
</b></div></td><td width="50" align="center"><div class="font"><b><?php echo $this->_tpl_vars['txtIloscTow']; ?>
</b></div></td><td align="center" width="50"><div class="font"><b><?php echo $this->_tpl_vars['txtIloscFirm']; ?>
</b><div></td><td width="80" align="center"><div class="font"><b><?php echo $this->_tpl_vars['txtCenaTow']; ?>
 w PLN</b></div></td><td>Zastosowany rabat (%)</td>
	</tr>
	<?php $_from = $this->_tpl_vars['pozycje']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pozycje'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pozycje']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['printItem']):
        $this->_foreach['pozycje']['iteration']++;
?>
	
	<tr>
		<td align="center"><div class="font"><?php echo $this->_tpl_vars['printItem']->nazwaTowaru; ?>
</div></td>
		<td align="center"><img src="/FrontPage/Files/ImgShop/<?php echo $this->_tpl_vars['printItem']->zdjecieMin; ?>
" width="100"/></td>
		<td align="center"><div class="font"><?php echo $this->_tpl_vars['printItem']->ilosc; ?>
</div></td>
		<td align="center"><div class="font"><?php echo $this->_tpl_vars['printItem']->iloscFirm; ?>
</div></td>
		<td align="center"><div class="font"><?php echo $this->_tpl_vars['printItem']->cenaNetto; ?>
</div></td>
		<td align="center"><div class="font"><?php echo $this->_tpl_vars['printItem']->rabat; ?>
</div></td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	<tr><td colspan="5" align="left"><div class="granat"><?php echo $this->_tpl_vars['txtRazem']; ?>
</div></td><td align="right"><div class="granat"><?php echo $this->_tpl_vars['razem']; ?>
</div></td></tr>
	<tr><td colspan="5" align="left"><div class="granat"><?php echo $this->_tpl_vars['txtRazemBrutto']; ?>
</div></td><td align="right"><div class="granat"><?php echo $this->_tpl_vars['razemBrutto']; ?>
</div></td></tr>
	<tr><td colspan="5" align="left"><div class="font"><?php echo $this->_tpl_vars['txtFormaDostawy']; ?>
</div></td><td align="right"><div class="font"><?php echo $this->_tpl_vars['txtCena']; ?>
</div></td>
	<tr><td colspan="5" align="left"><div class="font"><?php echo $this->_tpl_vars['dostawaNazwa']; ?>
</div></td><td align="right"><div class="font"><?php echo $this->_tpl_vars['dostawaCena']; ?>
</div></td>
	<tr><td colspan="5" align="center"><div class="bordo"><?php echo $this->_tpl_vars['txtWartoscZam']; ?>
 w PLN</div></td><td align="right"><div class="bordo"><?php echo $this->_tpl_vars['wartoscZam']; ?>
</div></td></tr>
	</table>
	<?php else: ?>
	<tr>
		<td width="250" align="center"><div class="font"><b><?php echo $this->_tpl_vars['txtNazwaTow']; ?>
</b><div class="font"></td><td align="center"><div class="font"><b><?php echo $this->_tpl_vars['txtZdjecieTow']; ?>
</b></div></td><td width="50" align="center"><div class="font"><b><?php echo $this->_tpl_vars['txtIloscTow']; ?>
</b></div></td><td align="center" width="50"><div class="font"><b><?php echo $this->_tpl_vars['txtIloscFirm']; ?>
</b><div></td><td width="80" align="center"><div class="font"><b><?php echo $this->_tpl_vars['txtCenaTow']; ?>
 w PLN</b></div></td>
	</tr>
	<?php $_from = $this->_tpl_vars['pozycje']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pozycje'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pozycje']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['printItem']):
        $this->_foreach['pozycje']['iteration']++;
?>
	
	<tr>
		<td align="center"><div class="font"><?php echo $this->_tpl_vars['printItem']->nazwaTowaru; ?>
</div></td>
		<td align="center"><img src="/FrontPage/Files/ImgShop/<?php echo $this->_tpl_vars['printItem']->zdjecieMin; ?>
" width="100"/></td>
		<td align="center"><div class="font"><?php echo $this->_tpl_vars['printItem']->ilosc; ?>
</div></td>
		<td align="center"><div class="font"><?php echo $this->_tpl_vars['printItem']->iloscFirm; ?>
</div></td>
		<td align="center"><div class="font"><?php echo $this->_tpl_vars['printItem']->cenaNetto; ?>
</div></td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
	
	<tr><td colspan="4" align="left"><div class="granat"><?php echo $this->_tpl_vars['txtRazem']; ?>
</div></td><td align="right"><div class="granat"><?php echo $this->_tpl_vars['razem']; ?>
</div></td></tr>
	<tr><td colspan="4" align="left"><div class="granat"><?php echo $this->_tpl_vars['txtRazemBrutto']; ?>
</div></td><td align="right"><div class="granat"><?php echo $this->_tpl_vars['razemBrutto']; ?>
</div></td></tr>
	<tr><td colspan="4" align="left"><div class="font"><?php echo $this->_tpl_vars['txtFormaDostawy']; ?>
</div></td><td align="right"><div class="font"><?php echo $this->_tpl_vars['txtCena']; ?>
</div></td>
	<tr><td colspan="4" align="left"><div class="font"><?php echo $this->_tpl_vars['dostawaNazwa']; ?>
</div></td><td align="right"><div class="font"><?php echo $this->_tpl_vars['dostawaCena']; ?>
</div></td>
	<tr><td colspan="4" align="center"><div class="bordo"><?php echo $this->_tpl_vars['txtWartoscZam']; ?>
 w PLN</div></td><td align="right"><div class="bordo"><?php echo $this->_tpl_vars['wartoscZam']; ?>
</div></td></tr>
	</table>
	<?php endif; ?>	
	<!-- Dane osobowe i dane do faktury   -->
	<tr valign="top">
	<td>
		<table border="1" width="265"><tr><td><b><div class="granat">Dane zamawiającego</div></td></tr><tr><td>
		<table>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtImie']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['imie']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtNazwisko']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['nazwisko']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtNipFaktura']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['NIPFaktura']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtUlica']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['ulica']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtNrDomu']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['nrDomu']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtNrMieszkania']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['nrMieszkania']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtKodPocztowy']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['kodPocztowy']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtMiasto']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['miasto']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtEmail']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['email']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtNrTel']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['nrTel']; ?>
</div></td></tr>
		</table>
		</td></tr>
		<tr><td align="center"><button onClick = "document.location.href='?a=<?php echo $this->_tpl_vars['poprawOsobActn']; ?>
&strona=<?php echo $this->_tpl_vars['stronaOsobActn']; ?>
'"><b><div class="font"><?php echo $this->_tpl_vars['txtPopraw']; ?>
</div></b></button></td></tr>
		</table>
	</td>
	<td valign="top">
		<table border="1" width="265"><tr><td><div class="granat">Dane do faktury</div></td></tr><tr><td>
		<table>
			<?php if ($this->_tpl_vars['czyFirmaFaktura'] == 'T'): ?> 
				<tr><td><div class="font"><?php echo $this->_tpl_vars['txtNazwaFaktura']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['nazwaFaktura']; ?>
</div></td></tr>
			<?php else: ?>
				<tr><td><div class="font"><?php echo $this->_tpl_vars['txtImie']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['imieFaktura']; ?>
</div></td></tr>
				<tr><td><div class="font"><?php echo $this->_tpl_vars['txtNazwisko']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['nazwiskoFaktura']; ?>
</div></td></tr>
			<?php endif; ?>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtNipFaktura']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['NIPFaktura']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtUlica']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['ulicaFaktura']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtNrDomu']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['nrDomuFaktura']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtNrMieszkania']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['nrMieszkaniaFaktura']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtKodPocztowy']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['kodPocztowyFaktura']; ?>
</div></td></tr>
			<tr><td><div class="font"><?php echo $this->_tpl_vars['txtMiasto']; ?>
:<div></td><td><div class="font"><?php echo $this->_tpl_vars['miastoFaktura']; ?>
</div></td></tr>
			<tr><td> </td><td></td> </tr>
			<tr><td> </td><td></td> </tr>
		</table>
		</td></tr>
		<tr><td align="center"><button onClick = "document.location.href='?a=<?php echo $this->_tpl_vars['poprawFaktActn']; ?>
&strona=<?php echo $this->_tpl_vars['stronaFaktActn']; ?>
'"><b><div class="font"><?php echo $this->_tpl_vars['txtPopraw']; ?>
</div></b></button></td></tr>
		</table>
	</td></tr>
	
	<!--platnosci -->
	<tr><td colspan="2">
		<table border="1" width="550"><tr><td align="center"><div class="granat">Pozostałe informacje</div></td></tr><tr><td>
		<table border="1">
			<tr><td width="275"><div class="bordo">Płatność</div></td><td align="center" width="275"><div class="font"><?php echo $this->_tpl_vars['txtUwagi']; ?>
</div></td></tr>
			<tr><td align="center"><div class="font"><?php echo $this->_tpl_vars['nazwaPlatnosci']; ?>
</div></td><td align="center"><div class="font"><?php echo $this->_tpl_vars['uwagi']; ?>
</div></td></tr>
		</table>
		</td></tr>
		<tr><td align="center"><button onClick = "document.location.href='?a=<?php echo $this->_tpl_vars['poprawPozostaleActn']; ?>
&strona=<?php echo $this->_tpl_vars['stronaPozostaleActn']; ?>
'"><b><div class="font"><?php echo $this->_tpl_vars['txtPopraw']; ?>
</div></b></button></td></tr>
		</table>
	</td></tr>
	<!--przyciski akcji -->
	<tr><td colspan="2" width="550" align="center">
		<button onClick = "document.location.href='?a=<?php echo $this->_tpl_vars['anulujActn']; ?>
'"><b><div class="font"><?php echo $this->_tpl_vars['txtAnuluj']; ?>
</div></b></button>
		<button onClick = "document.location.href='?a=<?php echo $this->_tpl_vars['zatwierdzActn']; ?>
'"><b><div class="font"><?php echo $this->_tpl_vars['txtZatwierdz']; ?>
</div></b></button>
	</td></tr>	
</table>
</center>