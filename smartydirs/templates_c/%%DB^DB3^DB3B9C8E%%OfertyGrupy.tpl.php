<?php /* Smarty version 2.6.17, created on 2014-11-06 16:16:59
         compiled from modules/OfertyGrupy.tpl */ ?>
﻿<div class="bordo"><?php echo $this->_tpl_vars['nazwaGrupy']; ?>
</div>
<?php $_from = $this->_tpl_vars['grupy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['grupy'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['grupy']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['grupaItem']):
        $this->_foreach['grupy']['iteration']++;
?>
<br/>
<b><?php echo $this->_tpl_vars['grupaItem']->nazwaOferty; ?>
</b>
<table align="center">
    <tr><td width="300"><div class="font"><b>Opis</b></td><td width="40" align="center"><div class="font"><b>Ilość egz</b></td><td width="20" align="center"><div class="font" align="center"><b>Ilość firm</b></td><td width="80" align="center"><div class="font"><b>Cena</b></td><?php if (( $this->_tpl_vars['rabat'] )): ?><td width="80" align="center"><div class="font"><b>Cena po rabacie</b></div></td><?php endif; ?><td align="center" width="50"><div class="font"><b>Kup</b></td></tr>
<?php $_from = $this->_tpl_vars['towar']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['towar'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['towar']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['towarItem']):
        $this->_foreach['towar']['iteration']++;
?>
	<?php if ($this->_tpl_vars['towarItem']->idOferty == $this->_tpl_vars['grupaItem']->idOferty): ?>
	<tr>
		<td><?php echo $this->_tpl_vars['towarItem']->opisTowaru; ?>
</td>
		<td align="right"><div class="font"><input type="edit"  size="3" maxlength="3" value="1" id="egz<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
"
							onChange="
								checkControls('egz<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
', 'firmy<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
');
								<?php if ($this->_tpl_vars['towarItem']->algCeny == 0): ?>
								calculatePriceLocal('cena<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
',<?php echo $this->_tpl_vars['towarItem']->cenaTowaru; ?>
, this.value, document.getElementById('firmy<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
').value);
                                                                <?php if ($this->_tpl_vars['rabat']): ?>
                                                                calculatePriceLocalParams('cena<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
Params',<?php echo $this->_tpl_vars['towarItem']->cenaTowaru; ?>
, this.value, document.getElementById('firmy<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
').value, <?php echo $this->_tpl_vars['param1Zwykl']; ?>
, <?php echo $this->_tpl_vars['param2Zwykl']; ?>
);
                                                                <?php endif; ?>
								<?php else: ?>
								calculatePriceNet('cena<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
',<?php echo $this->_tpl_vars['towarItem']->cenaTowaru; ?>
, this.value, document.getElementById('firmy<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
').value);
                                                                <?php if ($this->_tpl_vars['rabat']): ?>                                                                    
                                                                    calculatePriceNetParams('cena<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
Params',<?php echo $this->_tpl_vars['towarItem']->cenaTowaru; ?>
, this.value, document.getElementById('firmy<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
').value, <?php echo $this->_tpl_vars['param1Net']; ?>
, <?php echo $this->_tpl_vars['param2Net']; ?>
);
                                                                <?php endif; ?>
								<?php endif; ?>
								updateAction('addAct<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
', 
											<?php echo $this->_tpl_vars['towarItem']->actionDoKoszyka; ?>
, 
											<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
,
											this.value,
											document.getElementById('firmy<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
').value)"/></td>
		<td align="right"><select size="1" id="firmy<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
"
							onChange="
								checkControls('egz<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
', 'firmy<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
');
								<?php if ($this->_tpl_vars['towarItem']->algCeny == 0): ?>
								calculatePriceLocal('cena<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
',<?php echo $this->_tpl_vars['towarItem']->cenaTowaru; ?>
, document.getElementById('egz<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
').value, this.value);
                                                                <?php if ($this->_tpl_vars['rabat']): ?>
                                                                calculatePriceLocalParams('cena<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
Params',<?php echo $this->_tpl_vars['towarItem']->cenaTowaru; ?>
,  document.getElementById('egz<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
').value, this.value, <?php echo $this->_tpl_vars['param1Zwykl']; ?>
, <?php echo $this->_tpl_vars['param2Zwykl']; ?>
);
                                                                <?php endif; ?>
								<?php else: ?>
								calculatePriceNet('cena<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
',<?php echo $this->_tpl_vars['towarItem']->cenaTowaru; ?>
, document.getElementById('egz<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
').value, this.value);
                                                                <?php if ($this->_tpl_vars['rabat']): ?>                                                                    
                                                                    calculatePriceNetParams('cena<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
Params',<?php echo $this->_tpl_vars['towarItem']->cenaTowaru; ?>
, document.getElementById('egz<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
').value, this.value, <?php echo $this->_tpl_vars['param1Net']; ?>
, <?php echo $this->_tpl_vars['param2Net']; ?>
);
                                                                <?php endif; ?>
								<?php endif; ?>
								updateAction('addAct<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
', 
											<?php echo $this->_tpl_vars['towarItem']->actionDoKoszyka; ?>
, 
											<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
,
											document.getElementById('egz<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
').value,
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
		<td align="right"><span id="cena<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
" class="font"><?php echo $this->_tpl_vars['towarItem']->cenaTowaruFormatted; ?>
</span></td>
                <?php if ($this->_tpl_vars['rabat']): ?>
                <td align="right"><span id="cena<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
Params" class="font"><?php echo $this->_tpl_vars['towarItem']->cena2TowaruFormatted; ?>
</span></td>
                <?php endif; ?>
		<td align="center"><span id="addAct<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
"><a href="?a=<?php echo $this->_tpl_vars['towarItem']->actionDoKoszyka; ?>
&towarId=<?php echo $this->_tpl_vars['towarItem']->idTowaru; ?>
"><img src="/FrontPage/Files/Img/koszyk_small.jpg" border="0"/></a></span></td>
	</tr>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<table>
<?php endforeach; endif; unset($_from); ?>
