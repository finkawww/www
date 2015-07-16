<?php /* Smarty version 2.6.17, created on 2012-05-16 13:24:38
         compiled from modules/KontaktZlozenieZamowieniaAlter.tpl */ ?>
<?php echo $this->_tpl_vars['tresc']; ?>


<?php echo $this->_tpl_vars['txtDaneZamowienia']; ?>



<?php echo $this->_tpl_vars['txtNumerZam']; ?>
: <?php echo $this->_tpl_vars['numerZam']; ?>


<?php echo $this->_tpl_vars['txtPozycjeZam']; ?>
:

<?php $_from = $this->_tpl_vars['pozycjeZam']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pozycjeZam'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pozycjeZam']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['ZamowieniaItems']):
        $this->_foreach['pozycjeZam']['iteration']++;
?>
	<?php echo $this->_tpl_vars['txtNazwaTow']; ?>
: <?php echo $this->_tpl_vars['ZamowieniaItems']->nazwaTowaru; ?>

	<?php echo $this->_tpl_vars['txtCenaTow']; ?>
: <?php echo $this->_tpl_vars['ZamowieniaItems']->cena_poz; ?>

	<?php echo $this->_tpl_vars['txtIloscStan']; ?>
: <?php echo $this->_tpl_vars['ZamowieniaItems']->ilosc_stan; ?>

	<?php echo $this->_tpl_vars['txtIloscFirm']; ?>
: <?php echo $this->_tpl_vars['ZamowieniaItems']->ilosc_firm; ?>

	<?php endforeach; endif; unset($_from); ?>

	
<?php echo $this->_tpl_vars['txtFormaDostawy']; ?>
: <?php echo $this->_tpl_vars['dostawaNazwa']; ?>

<?php echo $this->_tpl_vars['txtCenaDostawy']; ?>
(brutto): <?php echo $this->_tpl_vars['dostawaCena']; ?>

<?php echo $this->_tpl_vars['txtRazem']; ?>
(brutto): <?php echo $this->_tpl_vars['wartoscZam']; ?>

<?php echo $this->_tpl_vars['txtFormaPlatnosci']; ?>
: <?php echo $this->_tpl_vars['platnoscNazwa']; ?>


<?php echo $this->_tpl_vars['txtDaneDostawy']; ?>


<?php echo $this->_tpl_vars['txtImie']; ?>
: <?php echo $this->_tpl_vars['imie']; ?>

<?php echo $this->_tpl_vars['txtNazwisko']; ?>
: <?php echo $this->_tpl_vars['nazwisko']; ?>

<?php echo $this->_tpl_vars['txtKraj']; ?>
: <?php echo $this->_tpl_vars['kraj']; ?>

<?php echo $this->_tpl_vars['txtMiasto']; ?>
: <?php echo $this->_tpl_vars['miasto']; ?>

<?php echo $this->_tpl_vars['txtUlica']; ?>
: <?php echo $this->_tpl_vars['ulica']; ?>

<?php echo $this->_tpl_vars['txtNrDomu']; ?>
: <?php echo $this->_tpl_vars['nrDomu']; ?>

<?php echo $this->_tpl_vars['txtNrMieszkania']; ?>
: <?php echo $this->_tpl_vars['nrMieszkania']; ?>

<?php echo $this->_tpl_vars['txtEmail']; ?>
: <?php echo $this->_tpl_vars['email']; ?>

<?php echo $this->_tpl_vars['txtKodPocztowy']; ?>
: <?php echo $this->_tpl_vars['kodPocztowy']; ?>

<?php echo $this->_tpl_vars['txtNrTel']; ?>
: <?php echo $this->_tpl_vars['nrTel']; ?>

	
<?php echo $this->_tpl_vars['txtDaneDoFaktury']; ?>
		

<?php if ($this->_tpl_vars['czyFirmaFaktura'] == 'T'): ?>
<?php echo $this->_tpl_vars['txtNazwaFaktura']; ?>
: <?php echo $this->_tpl_vars['nazwaFaktura']; ?>

<?php echo $this->_tpl_vars['txtNipFaktura']; ?>
: <?php echo $this->_tpl_vars['NIPFaktura']; ?>

<?php else: ?>
<?php echo $this->_tpl_vars['txtImieFaktura']; ?>
: <?php echo $this->_tpl_vars['imieFaktura']; ?>

<?php echo $this->_tpl_vars['txtNazwiskoFaktura']; ?>
: <?php echo $this->_tpl_vars['nazwiskoFaktura']; ?>

<?php endif; ?>
<?php echo $this->_tpl_vars['txtKraj']; ?>
: <?php echo $this->_tpl_vars['krajFaktura']; ?>

<?php echo $this->_tpl_vars['txtMiasto']; ?>
: <?php echo $this->_tpl_vars['miastoFaktura']; ?>

<?php echo $this->_tpl_vars['txtUlica']; ?>
: <?php echo $this->_tpl_vars['ulicaFaktura']; ?>

<?php echo $this->_tpl_vars['txtNrDomu']; ?>
: <?php echo $this->_tpl_vars['nrDomuFaktura']; ?>

<?php echo $this->_tpl_vars['txtNrMieszkania']; ?>
: <?php echo $this->_tpl_vars['nrMieszkaniaFaktura']; ?>

<?php echo $this->_tpl_vars['txtKodPocztowy']; ?>
: <?php echo $this->_tpl_vars['kodPocztowyFaktura']; ?>



Dzia³ Obs³ugi Klienta
---------------------
TIK-SOFT Sp. z o.o. 
Aleja Wilanowska 5 lok.19, 02-765 Warszawa
tel. (22) 408 48 00, fax: (22) 408 48 00 w. 107
e-mail:  finka@finka.pl,    www.finka.pl
S¹d Rej. dla m. st. Warszawy, XIII Wydzia³ Gospodarczy
KRS 0000170845, Kapita³ zak³adowy: 1 132 200,00 PLN 