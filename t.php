<?php
$txt = '<ol>
<li><b>Program pozwala na zapamiêtanie umów zleceñ lub o dzie³o bez daty zakoñczenia. </b><br><br>
Zalecamy ustawienie trybu wyp³aty takich umów "miesiêcznie wg list p³ac" albo "wg rachunków"
– ten pierwszy tryb spowoduje stosowanie takiej samej kwoty co miesi¹c, zaœ drugi pozwoli na wpisywanie ró¿nych wartoœci wyp³at w ró¿nych okresach.<br><br>
<li><b>Dostosowano program do wymagañ zwi¹zanych z rocznym limitem kosztów autorskich. </b><br><br>
<ul>
<li>Program samoczynnie zlicza koszty autorskie danej osoby w danym roku z p³ac etatowych oraz
z umów-zleceñ i o dzie³o. W razie osi¹gniêcia limitu równego po³owie pierwszego progu podatkowego program zmniejsza koszty autorskie w kolejnych wyp³atach, zwiêkszaj¹c odpowiednio zaliczk¹ podatkow¹. <br><br>
<li>Poniewa¿ ustawa nie nakazuje zliczania tych kosztów przez pracodawcê / zleceniodawcê, tryb zliczania mo¿na wy³¹czyæ, zmieniaj¹c parametr w menu:<br><br>
&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  -&gt;  Redagowanie danych sta³ych   <br>
&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;  -&gt;  Parametry obliczania ZUS i PDOF <br>
&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; -&gt;  Czy zliczaæ przekroczenie kosztów autorskich? <br><br>
<li>Jeœli osoba osi¹ga przychody z tytu³u praw autorskich tak¿e z innych Ÿróde³, to mo¿e z³o¿yæ oœwiadczenie o przekroczeniu limitu. Na ekranie wyliczania wynagrodzeñ odnotowuje siê to 
w punkcie 121b "Czy zg³oszono przekroczenie kosztów autorskich". Po wpisaniu "TAK" program przestaje liczyæ te koszty.
</ul><br>
Dla umów-zleceñ i o dzie³o takiego punktu nie wprowadzono, gdy¿ tak¿e w poprzednich wersjach programu mo¿na tam wpisaæ 0% kosztów.
</ol>';
$newTxt = htmlspecialchars($txt,ENT_QUOTES|ENT_IGNORE, 'UTF-8');
echo $newTxt;