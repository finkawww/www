<?php /* Smarty version 2.6.17, created on 2012-03-10 18:16:06
         compiled from modules/KoszykFull.tpl */ ?>
﻿<!-- sprawdzic za pomoca DOM - forms.elemnts[i] -->
<center>
<div class="bordo">Zawartość koszyka</div><br>
<form name="formularz" action="" method="POST">
<input type="hidden" name="a" value="<?php echo $this->_tpl_vars['przeliczAct']; ?>
">
<table align = "center">
	<!-- Pozycje -->
	<?php $_from = $this->_tpl_vars['pozycje']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pozycje'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pozycje']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['pozycjeItem']):
        $this->_foreach['pozycje']['iteration']++;
?>
	<tr><td>
		<table>
			<tr>
				
				<td rowspan="5"><img src="/FrontPage/Files/ImgShop/<?php echo $this->_tpl_vars['pozycjeItem']->zdjecieMin; ?>
" width="100"></td>
				<td align="right"><div class="font">Program:</td><td align="left"><b><div class="font"><?php echo $this->_tpl_vars['pozycjeItem']->nazwaTowaru; ?>
</b></td>
				
				<td align="right"><input type="button" value="Usuń" onClick="document.location.href='?a=<?php echo $this->_tpl_vars['usunPozAct']; ?>
&towarId=<?php echo $this->_tpl_vars['pozycjeItem']->id; ?>
'"></td>
			</tr>
			<input type="hidden" name="towId<?php echo ($this->_foreach['pozycje']['iteration']-1); ?>
" value="<?php echo $this->_tpl_vars['pozycjeItem']->id; ?>
">
			<tr><td align="right"><div class="font">Szczegóły:</td><td align="left"><div class="font"><?php echo $this->_tpl_vars['pozycjeItem']->opis; ?>
</td></tr>
			<?php if (! $this->_tpl_vars['rezerwacje']): ?>
			<tr><td align="right"><div class="font">Ilość stanowisk:</td><td align="left"><input type="text" size="3" maxLength="3" name="il<?php echo ($this->_foreach['pozycje']['iteration']-1); ?>
" id="il<?php echo ($this->_foreach['pozycje']['iteration']-1); ?>
" value="<?php echo $this->_tpl_vars['pozycjeItem']->ilosc; ?>
" onChange="checkControls('il<?php echo ($this->_foreach['pozycje']['iteration']-1); ?>
', 'ilFirm<?php echo ($this->_foreach['pozycje']['iteration']-1); ?>
')"></td></tr>
			<tr><td align="right"><div class="font">Ilość firm:</td>
			<td align="left">
				<select size="1" name="ilFirm<?php echo ($this->_foreach['pozycje']['iteration']-1); ?>
" id="ilFirm<?php echo ($this->_foreach['pozycje']['iteration']-1); ?>
" value="<?php echo $this->_tpl_vars['pozycjeItem']->iloscFirm; ?>
">
							<option value="3" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 3): ?>selected<?php endif; ?>>do 3</option>
							<option value="10" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 10): ?>selected<?php endif; ?>>4-10</option>
							<option value="20" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 20): ?>selected<?php endif; ?>>11-20</option>
							<option value="30" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 30): ?>selected<?php endif; ?>>21-30</option>
							<option value="40" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 40): ?>selected<?php endif; ?>>31-40</option>
							<option value="50" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 50): ?>selected<?php endif; ?>>41-50</option>
							<option value="60" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 60): ?>selected<?php endif; ?>>51-60</option>
							<option value="70" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 70): ?>selected<?php endif; ?>>61-70</option>
							<option value="80" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 80): ?>selected<?php endif; ?>>71-80</option>
							<option value="90" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 90): ?>selected<?php endif; ?>>81-90</option>
							<option value="100" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 100): ?>selected<?php endif; ?>>91-100</option>
							<option value="110" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 110): ?>selected<?php endif; ?>>101-110</option>
							<option value="120" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 120): ?>selected<?php endif; ?>>111-120</option>
							<option value="130" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 130): ?>selected<?php endif; ?>>121-130</option>
							<option value="140" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 140): ?>selected<?php endif; ?>>131-140</option>
							<option value="150" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 150): ?>selected<?php endif; ?>>141-150</option>
							<option value="160" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 160): ?>selected<?php endif; ?>>151-160</option>
							<option value="170" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 170): ?>selected<?php endif; ?>>161-170</option>
							<option value="180" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 180): ?>selected<?php endif; ?>>171-180</option>
							<option value="190" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 190): ?>selected<?php endif; ?>>181-190</option>
							<option value="200" <?php if ($this->_tpl_vars['pozycjeItem']->iloscFirm == 200): ?>selected<?php endif; ?>>191-200</option>
				</select>
			</td>
			</tr>
			<?php else: ?>
			<tr><td align="right"><div class="font">Ilość:</td><td align="left"><b><div class="font"><?php echo $this->_tpl_vars['pozycjeItem']->ilosc; ?>
</td></tr>
			<?php endif; ?>
			<tr><td align="right"><div class="font">Cena:</td><td align="left"><div class="font"><?php echo $this->_tpl_vars['pozycjeItem']->cenaNetto; ?>
zł + 23%VAT zł = <?php echo $this->_tpl_vars['pozycjeItem']->cenaBrutto; ?>
zł</td></tr>
		<hr>
		</table>
	</td></tr>
	<?php endforeach; endif; unset($_from); ?>
	<!--razem -->
	<tr><td align="right">
		<table>
			<tr><td align="right"><br><div class="font">Podsumowanie zamówienia: </div><br><div class="bordo"><?php echo $this->_tpl_vars['razem']; ?>
zł + 23% VAT = <?php echo $this->_tpl_vars['razemBrutto']; ?>
zł</div><br></td></tr>
		</table>
	</td></tr>
	<!-- Akcje -->
	<tr><td align="center">
		<table align = "center">
			<tr align = "center">
			<?php if ($this->_tpl_vars['backAct'] != "-1"): ?>
				<!--<td><input type="button" font color="red" value="Wroc do oferty" onClick="document.location.href='<?php echo $this->_tpl_vars['backAct']; ?>
'"></td>-->
				<input type="button" font color="red" value="Wroc do oferty" onClick="document.location.href='?mp=46'">
				
			<?php endif; ?>
				<td><input type="button" value="Wyczyść" onClick="document.location.href='?a=<?php echo $this->_tpl_vars['wyczyscAct']; ?>
'"></td>
			<?php if (! $this->_tpl_vars['rezerwacje']): ?>
				<td><input type="submit" value="Przelicz"></td>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['ilePoz'] != 0): ?>
				<td><input type="button" value="Zamow" onClick="document.location.href='?a=<?php echo $this->_tpl_vars['ZamowAct']; ?>
'"></td>
			<?php endif; ?>
			
			</tr>
		</table>
	</td></tr>
</table>
</form>
</center>