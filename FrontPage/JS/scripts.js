/*
 * Skrypty pomocnicze do strony
 * 
 * Autor: Piotr Brodziński; 
 * mailto: brodzinski[@]{1}interia.pl
 * 
 * Utworzono : 01.06.2007 
 * Modyfikacja :  19.08.2011
 */

function CheckAnkieta()
{
	var res = false;

	if (document.Ankieta.uwagi.value=="")
	{
		alert('Polę [Z których programów FINKA Państwo korzystają?] jest wymagane.');
		res = false;
	}
	else
	{
		res =  true;
	}
	return res;
	
}

// Sprawdzenie, czy liczby w kontrolkach ilosci
function checkControls(control1, control2)
{
	var iloscEgz = document.getElementById(control1).value;
	var iloscFirm = document.getElementById(control2).value;

	//jakikolwiek znak ^[0-9]
	var regex = /\D/;		
	
	if (regex.test(iloscEgz))
	{
		document.getElementById(control1).value = 1;
		alert('Wpisano nieprawidłową liczbę!');
	}
	if (regex.test(iloscFirm))
	{
		document.getElementById(control2).value = 3;
		alert('Wpisano nieprawidłową liczbę!');
	}
	if (document.getElementById(control1).value ==0)
	{
		document.getElementById(control1).value = 1;
	}
	if (document.getElementById(control2).value ==0)
	{
		document.getElementById(control2).value = 3;
	}
}

// Oblicza cene dla stanowisk na pojedynczych komputerach 
function calculatePriceLocal(control, defPrice, iloscEgz, iloscFirm)
{
	document.getElementById(control).innerHTML = calculatePrice(defPrice, iloscEgz, iloscFirm, 0.7);	
}

// Oblicza cene dla stanowisk sieciowych 
function calculatePriceNet(control, defPrice, iloscEgz, iloscFirm)
{
	document.getElementById(control).innerHTML = calculatePrice(defPrice, iloscEgz, iloscFirm, 0.4);	
}

function calculatePriceLocalParams(control, defPrice, iloscEgz, iloscFirm, param1, param2)
{
	document.getElementById(control).innerHTML = calculatePriceRabat(defPrice, iloscEgz, iloscFirm, param1, param2);	
}

// Oblicza cene dla stanowisk sieciowych 
function calculatePriceNetParams(control, defPrice, iloscEgz, iloscFirm, param1, param2)
{
	document.getElementById(control).innerHTML = calculatePriceRabat(defPrice, iloscEgz, iloscFirm, param1, param2);	
}



// Wolana przez funkcje wyzej z odpowiednio ustaiwonym argumentem "przeliczania"
function calculatePrice(defPrice, iloscEgz, iloscFirm, param)
{	
	var priceEgz = 0; 
	var price = 0; 
	
	//egzemplarze	
	priceEgz = defPrice + (iloscEgz-1)*defPrice*param;
	//firmy
	//priceFirmy = (iloscFirm<3) ? 1 : (iloscFirm<=10)?(0.01*iloscFirm+1.1):;
//alert(iloscFirm);
	//alert(defPrice*(Math.floor(iloscFirm/10)+2)*0.1);
	if (iloscFirm <= 3)
	{
		price = priceEgz;
	}
	else /*if (iloscFirm <= 10)*/
	{
                var res = (Math.floor(iloscFirm/10)+1)*0.1;
		price = priceEgz + priceEgz*((Math.floor(iloscFirm/10)+1)*0.1);
	}
	/*
	else if (iloscFirm > 10)
	{
		11/10 1+1 = 
		price = priceEgz + priceEgz*((Math.floor(iloscFirm/10)+1)*0.1);
	}*/
	//alert(price);	
	return roundNumber(price, 2);
}

// Wolana przez funkcje wyzej z odpowiednio ustaiwonym argumentem "przeliczania"
function calculatePriceRabat(defPrice, iloscEgz, iloscFirm, param1, param2)
{	
	var priceEgz = 0; 
	var price = 0; 
	
	//egzemplarze	
	priceEgz = defPrice*param1 + (iloscEgz-1)*defPrice*param2;
	//firmy
	//priceFirmy = (iloscFirm<3) ? 1 : (iloscFirm<=10)?(0.01*iloscFirm+1.1):;
//alert(iloscFirm);
	//alert(defPrice*(Math.floor(iloscFirm/10)+2)*0.1);
	if (iloscFirm <= 3)
	{
		price = priceEgz;
	}
	else /*if (iloscFirm <= 10)*/
	{
            
            price = priceEgz + priceEgz*((Math.floor(iloscFirm/10)+1)*0.1);
	}
	/*
	else if (iloscFirm > 10)
	{
		11/10 1+1 = 
		price = priceEgz + priceEgz*((Math.floor(iloscFirm/10)+1)*0.1);
	}*/
	//alert(price);	
	return roundNumber(price, 2);
}

// Podmienia akcje KoszykAdd
function updateAction(actionControl, idActn, idTow, iloscEgz, iloscFirm)
{
	
	actnTxt='<a href="?a='+idActn+'&towarId='+idTow+'&iloscEgz='+iloscEgz+'&iloscFirm='+iloscFirm+'"><img src="/FrontPage/Files/Img/koszyk_small.jpg" border="0"/></a>';
	document.getElementById(actionControl).innerHTML = actnTxt;
}

// Zaokrąglenie do 2 miejsc po przecinku
function roundNumber(num, dec) 
{
	var result = String(Math.round(num*Math.pow(10,dec))/Math.pow(10,dec));
	var formattedRes = '';
	if(result.indexOf('.')<0) 
	{
		result += '.';
	}
	while(result.length-result.indexOf('.')<=dec) 
	{
		result += '0';
	}
	
	result = result.replace('.', ',');
	thousendSep = result.indexOf(',');
	if (thousendSep > 3)
	{
		for(i=0; i<result.length;i++)
		{
			if (thousendSep-3 == i)
			{
				formattedRes += ' ';
			}
			formattedRes += result.charAt(i);
		}
	}
	else
	{
		formattedRes = result;
	}	
	
	return formattedRes;
}

$(document).ready(function(){
	$('#mobile-button').click(function(){
		$('#menu').slideToggle(300, function(){
			var menu = $("#menu");
			if(menu.is(':visible'))
				$('#menu-box').css('height', '350px')
			else
				$('#menu-box').css('height', '40px')
		});
	});
});