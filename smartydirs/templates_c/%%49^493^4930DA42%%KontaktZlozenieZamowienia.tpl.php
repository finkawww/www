<?php /* Smarty version 2.6.17, created on 2012-05-16 13:48:37
         compiled from modules/KontaktZlozenieZamowienia.tpl */ ?>
<br/>
<?php echo $this->_tpl_vars['tresc']; ?>

<br/><br/>
<?php echo $this->_tpl_vars['txtDaneZamowienia']; ?>


<table>
<tr><td><?php echo $this->_tpl_vars['txtNumerZam']; ?>
:</td><td><?php echo $this->_tpl_vars['numerZam']; ?>
</td></tr>
</table>
<br/>
<table width="500" border="1">

	<tr>
		<td width="250" align="left"><?php echo $this->_tpl_vars['txtNazwaTow']; ?>
</td><td width="83" align="right"><?php echo $this->_tpl_vars['txtCenaTow']; ?>
</td><td width="83" align="right"><?php echo $this->_tpl_vars['txtIloscStan']; ?>
</td><td width="83" align="right"><?php echo $this->_tpl_vars['txtIloscFirm']; ?>
</td>
	</tr>
<?php $_from = $this->_tpl_vars['pozycjeZam']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pozycjeZam'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pozycjeZam']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['ZamowieniaItems']):
        $this->_foreach['pozycjeZam']['iteration']++;
?>
	<tr>
		<td width="250" align="left"><?php echo $this->_tpl_vars['ZamowieniaItems']->nazwaTowaru; ?>
</td>
		<td width="83" align="right"><?php echo $this->_tpl_vars['ZamowieniaItems']->cena_poz; ?>
</td>
		<td width="83" align="right"><?php echo $this->_tpl_vars['ZamowieniaItems']->ilosc_stan; ?>
</td>
		<td width="83" align="right"><?php echo $this->_tpl_vars['ZamowieniaItems']->ilosc_firm; ?>
</td>
	</tr>
	<?php endforeach; endif; unset($_from); ?>
</table>

<table>
	<tr><td><?php echo $this->_tpl_vars['txtFormaDostawy']; ?>
: <?php echo $this->_tpl_vars['dostawaNazwa']; ?>
</td></tr>
	<tr><td>Koszt dostawy(brutto) : <?php echo $this->_tpl_vars['dostawaCena']; ?>
zl</td></tr><br>
	<tr><td><b><u><?php echo $this->_tpl_vars['txtRazem']; ?>
(brutto): <?php echo $this->_tpl_vars['wartoscZam']; ?>
zl</u></b></td></tr>
	<tr><td><b><?php echo $this->_tpl_vars['platnoscNazwa']; ?>
</b><br></td></tr>
</table>

<table>
<tr><td>
		<table>
			<tr><td colspan="2"><u><?php echo $this->_tpl_vars['txtDaneDostawy']; ?>
</u></td></tr>
			<tr><td><?php echo $this->_tpl_vars['txtImie']; ?>
 i <?php echo $this->_tpl_vars['txtNazwisko']; ?>
:</td><td><?php echo $this->_tpl_vars['imie']; ?>
 <?php echo $this->_tpl_vars['nazwisko']; ?>
</td></tr>
			<tr><td><?php echo $this->_tpl_vars['txtUlica']; ?>
:</td><td><?php echo $this->_tpl_vars['ulica']; ?>
 <?php echo $this->_tpl_vars['nrDomu']; ?>
/<?php echo $this->_tpl_vars['nrMieszkania']; ?>
</td></tr>
			<tr><td><?php echo $this->_tpl_vars['txtKodPocztowy']; ?>
:</td><td><?php echo $this->_tpl_vars['kodPocztowy']; ?>
</td></tr>
			<tr><td><?php echo $this->_tpl_vars['txtMiasto']; ?>
:</td><td><?php echo $this->_tpl_vars['miasto']; ?>
</td></tr>
			<tr><td><?php echo $this->_tpl_vars['txtEmail']; ?>
:</td><td><?php echo $this->_tpl_vars['email']; ?>
</td></tr>
			<tr><td><?php echo $this->_tpl_vars['txtNrTel']; ?>
:</td><td><?php echo $this->_tpl_vars['nrTel']; ?>
</td></tr>
		</table>
	</td></tr>
	<tr><td>
		<table>
			<tr><td colspan="2"><u><?php echo $this->_tpl_vars['txtDaneDoFaktury']; ?>
</u></td></tr>
			<?php if ($this->_tpl_vars['czyFirmaFaktura'] == 'T'): ?>
				<tr><td><?php echo $this->_tpl_vars['txtNazwaFaktura']; ?>
:</td><td><?php echo $this->_tpl_vars['nazwaFaktura']; ?>
</td></tr>
				<tr><td><?php echo $this->_tpl_vars['txtNipFaktura']; ?>
:</td><td><?php echo $this->_tpl_vars['NIPFaktura']; ?>
</td></tr>
			<?php else: ?>
				<tr><td><?php echo $this->_tpl_vars['txtImieFaktura']; ?>
, <?php echo $this->_tpl_vars['txtNazwiskoFaktura']; ?>
:</td><td><?php echo $this->_tpl_vars['imieFaktura']; ?>
 <?php echo $this->_tpl_vars['nazwiskoFaktura']; ?>
</td></tr>
			<?php endif; ?>
	
			<tr><td><?php echo $this->_tpl_vars['txtUlica']; ?>
:</td><td><?php echo $this->_tpl_vars['ulicaFaktura']; ?>
 <?php echo $this->_tpl_vars['nrDomuFaktura']; ?>
/<?php echo $this->_tpl_vars['nrMieszkaniaFaktura']; ?>
</td></tr>
			<tr><td><?php echo $this->_tpl_vars['txtKodPocztowy']; ?>
:</td><td><?php echo $this->_tpl_vars['kodPocztowyFaktura']; ?>
</td></tr>
			<tr><td><?php echo $this->_tpl_vars['txtMiasto']; ?>
:</td><td><?php echo $this->_tpl_vars['miastoFaktura']; ?>
</td></tr>
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