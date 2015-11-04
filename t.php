<?php
$txt = '<ol>
<li><b>Program pozwala na zapami�tanie um�w zlece� lub o dzie�o bez daty zako�czenia. </b><br><br>
Zalecamy ustawienie trybu wyp�aty takich um�w "miesi�cznie wg list p�ac" albo "wg rachunk�w"
� ten pierwszy tryb spowoduje stosowanie takiej samej kwoty co miesi�c, za� drugi pozwoli na wpisywanie r�nych warto�ci wyp�at w r�nych okresach.<br><br>
<li><b>Dostosowano program do wymaga� zwi�zanych z rocznym limitem koszt�w autorskich. </b><br><br>
<ul>
<li>Program samoczynnie zlicza koszty autorskie danej osoby w danym roku z p�ac etatowych oraz
z um�w-zlece� i o dzie�o. W razie osi�gni�cia limitu r�wnego po�owie pierwszego progu podatkowego program zmniejsza koszty autorskie w kolejnych wyp�atach, zwi�kszaj�c odpowiednio zaliczk� podatkow�. <br><br>
<li>Poniewa� ustawa nie nakazuje zliczania tych koszt�w przez pracodawc� / zleceniodawc�, tryb zliczania mo�na wy��czy�, zmieniaj�c parametr w menu:<br><br>
&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  -&gt;  Redagowanie danych sta�ych   <br>
&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;  -&gt;  Parametry obliczania ZUS i PDOF <br>
&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; -&gt;  Czy zlicza� przekroczenie koszt�w autorskich? <br><br>
<li>Je�li osoba osi�ga przychody z tytu�u praw autorskich tak�e z innych �r�de�, to mo�e z�o�y� o�wiadczenie o przekroczeniu limitu. Na ekranie wyliczania wynagrodze� odnotowuje si� to 
w punkcie 121b "Czy zg�oszono przekroczenie koszt�w autorskich". Po wpisaniu "TAK" program przestaje liczy� te koszty.
</ul><br>
Dla um�w-zlece� i o dzie�o takiego punktu nie wprowadzono, gdy� tak�e w poprzednich wersjach programu mo�na tam wpisa� 0% koszt�w.
</ol>';
$newTxt = htmlspecialchars($txt,ENT_QUOTES|ENT_IGNORE, 'UTF-8');
echo $newTxt;