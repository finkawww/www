<?php /* Smarty version 2.6.17, created on 2011-08-11 01:38:43
         compiled from modules/KlientMainPage.tpl */ ?>
<?php echo $this->_tpl_vars['txtPowitanie']; ?>


<button onClick="document.location.href='?a=<?php echo $this->_tpl_vars['actnZmianaDanych']; ?>
';">
<?php echo $this->_tpl_vars['txtZmianaDanych']; ?>

</button>

<button onClick="document.location.href='?a=<?php echo $this->_tpl_vars['actnZmianaHasla']; ?>
';">
<?php echo $this->_tpl_vars['txtZmianaHasla']; ?>

</button>
<br/>

<?php echo $this->_tpl_vars['txtZamowienia']; ?>

<br/>
<?php $_from = $this->_tpl_vars['zamowienia']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['zamowienia'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['zamowienia']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['zamowienieItem']):
        $this->_foreach['zamowienia']['iteration']++;
?>
	<lf>
	<?php echo $this->_tpl_vars['txtNumerZam']; ?>
:<?php echo $this->_tpl_vars['zamowienieItem']->numer; ?>
<br/>
	<?php echo $this->_tpl_vars['txtStatus']; ?>
:<?php echo $this->_tpl_vars['zamowienieItem']->status; ?>
<br/>
	<?php echo $this->_tpl_vars['txtNazwa']; ?>
:<?php echo $this->_tpl_vars['zamowienieItem']->nazwa; ?>
<br/>
	<?php echo $this->_tpl_vars['txtOpis']; ?>
:<?php echo $this->_tpl_vars['zamowienieItem']->opis; ?>
<br/>
	<?php echo $this->_tpl_vars['txtAutor']; ?>
:<?php echo $this->_tpl_vars['zamowienieItem']->autor; ?>
<br/>
	<?php echo $this->_tpl_vars['txtTechnika']; ?>
:<?php echo $this->_tpl_vars['zamowienieItem']->technika; ?>
<br/>
	<?php echo $this->_tpl_vars['txtRok']; ?>
:<?php echo $this->_tpl_vars['zamowienieItem']->rok; ?>
<br/>
	<?php echo $this->_tpl_vars['txtRozmiar']; ?>
:<?php echo $this->_tpl_vars['zamowienieItem']->rozmiar; ?>
<br/>
	<?php echo $this->_tpl_vars['txtCena']; ?>
:<?php echo $this->_tpl_vars['zamowienieItem']->cena; ?>
<br/>
	<?php echo $this->_tpl_vars['zamowienieItem']->obrazMin; ?>
<br/>
	
<?php endforeach; endif; unset($_from); ?>