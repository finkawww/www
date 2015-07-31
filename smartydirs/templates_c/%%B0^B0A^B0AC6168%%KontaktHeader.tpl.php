<?php /* Smarty version 2.6.17, created on 2015-07-22 09:50:54
         compiled from modules/KontaktHeader.tpl */ ?>
﻿<?php echo '
<script type="text/javascript">
var nazwaTxt = "Imie, nazwisko, firma*";
var emailTxt = "E-mail*";
var nrTelTxt = "Telefon*";
var pytanieTxt = "Pytanie*";
	
function valid()
{
	var regex = /^([a-zA-Z0-9_.+-])+\\@(([a-zA-Z0-9-])+\\.)+([a-zA-Z0-9]{2,4})+$/;
	var validRes = true;
    if (!regex.test($("#khEmail").val()))
	{
		validRes = false;
		$("#khEmail").css("background", "red");
	}
	
	if (($("#khNazwa").val()=="")||($("#khNazwa").val()==nazwaTxt))
	{
		validRes = false;
		$("#khNazwa").css("background", "red");
	}
	if (($("#khNrTel").val()=="")||($("#khNrTel").val()==nrTelTxt))
	{
		validRes = false;
		$("#khNrTel").css("background", "red");
	}
	if (($("#khPytanie").val()=="")||($("#khPytanie").val()==pytanieTxt))
	{
		$("#khPytanie").css("background", "red");
		validRes = false;
	}
	return validRes;
}

function setValues()
{	
	$("#khNazwa").val(nazwaTxt);
	$("#khEmail").val(emailTxt);
	$("#khNrTel").val(nrTelTxt);
	$("#khPytanie").val(pytanieTxt);
}
function GetDefText(element)
{
	if (element == "khNazwa")
	{
		return nazwaTxt;
	}
	else if (element == "khEmail")
	{
		return emailTxt;
	}
	else if (element == "khNrTel")
	{
		return nrTelTxt;
	}
	else if (element == "khPytanie")
	{
		return pytanieTxt;
	}
	else
	{
		return "";
	}
}

$(document).ready(
	function()
		{
						
			$("#khNazwa").val(nazwaTxt);
			$("#khEmail").val(emailTxt);
			$("#khNrTel").val(nrTelTxt);
			$("#khPytanie").val(pytanieTxt);
			
						
			$("#khForm").bind("submit", function(event){
					event.preventDefault();
					nazwa = $(\'#khNazwa\').val();
					email = $("#khEmail").val();
					pytanie = $("#khPytanie").val();
					nrtel = $("#khNrTel").val();
					ap = $("#khAp").val();
					
					if (valid())
					{
						$.ajax({
							url: "index.php",
							type: "GET",
							data: { nazwa: nazwa, nrTel: nrtel, email: email, pytanie: pytanie, a: ap },
							success: function(msg)
							{
								
								$("#form").hide(200);								
								$("#komunikat").show(200,setTimeout(function(){																																			
									$("#komunikat").hide(200);
									$("#form").show(200);									
									setValues();									
								}
								,3000));	
							},
							error: function()
							{
								
								$("#form").hide();
								$("#komunikat").show();
								
							}
						});
					}
					else {}//blad walidacji
				}
			);
			$("#khNazwa,#khEmail,#khNrTel,#khPytanie").focus(
				function()
				{
				    $(this).css("background", "#F0F0F0");
					if ($(this).val() == GetDefText($(this).attr("id")))
						$(this).val("");
				}
			);
			$("#khNazwa,#khEmail,#khNrTel,#khPytanie").blur(
				function(){
					if($(this).val()=="")
					{
						$(this).val(GetDefText($(this).attr("id")));
					}
				}
			);
		}
)
</script>
'; ?>


<div id="kontener" style="width: 100%;">
	<div id="form" border="1" style="width: 100%;">
		<form id="khForm" name="KontaktHeader" action="" >
			<div class="KontaktHeaderRow" height="0">
				<input id="khAp" type="hidden" value="<?php echo $this->_tpl_vars['action']; ?>
"  />
			</div>
			<div class="KontaktHeaderRow" style="height: 22px; text-align: center;">
				<input id="khNazwa" font="tahoma" type="text" size="27" style="border: 1px solid #006097; background: #F0F0F0; font: tahoma; width: 100%; margin: 1px 0; padding: 1px "></input>
			</div>
			<div class="KontaktHeaderRow" style="height: 22px; text-align: center;">
				<input id="khEmail" font="tahoma" type="text" size="27" style="border: 1px solid #006097; background: #F0F0F0; font: tahoma; width: 100%; margin: 1px 0; padding: 1px "></input>
			</div>
			<div class="KontaktHeaderRow" style="height: 22px; text-align: center;">
				<input id="khNrTel" font="tahoma" type="text" size="27" style="border: 1px solid #006097; background: #F0F0F0; font: tahoma; width: 100%; margin: 1px 0; padding: 1px "></input>
			</div>
			<div class="KontaktHeaderRow" style="height: 22px; text-align: center;">                                 
				<textarea id="khPytanie" cols="21" style="border: 1px solid #006097; background: #F0F0F0; font: tahoma; width: 100%; margin: 1px 0; padding: 1px "></textarea>
			</div>
			<div class="KontaktHeaderRow" style="height: 22px; text-align: center;" align="center"><br><br>
                            <input type="submit" id="khWyslij" Value="Wyślij"  />
			</div>
		</form>
	</div>
	<div id="komunikat" style="display:none">	   
		<img src="/FrontPage/Files/Img/form_2str.jpg" />
	</div>
</div>