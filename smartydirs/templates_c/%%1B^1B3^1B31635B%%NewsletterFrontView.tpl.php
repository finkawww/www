<?php /* Smarty version 2.6.17, created on 2014-12-09 16:51:55
         compiled from modules/NewsletterFrontView.tpl */ ?>
﻿
							<div id="form" style="height: 100%">
								<form id="newsletter">
									<div class="font_sm"><big>Newsletter</big><br></div>
									<div class="font_kontakt" style="height: 100%;">
                                                                            Zapisz się na newsletter programów FINKA. Będziesz na bieżąco otrzymywać informacje o aktualizacjach, promocjach, wpisach do Bazy wiedzy. 
                                                                            <br><br><b>Adres e-mail:</b>

                                                                            <div><input type="text" name="email" id="emailTxt" /><div id="errLabel" style="display: none; color: red;">Błędny email</div></div>
                                                                            <div><button id="sendButton">Wyślij</button></div>
                                                                        </div>
								</form>

								<div class="font_kontakt" id="result" style="display: none;">
									Dziękujemy za rejestrację w Newsletter!
								</div>
								<div class="font_kontakt" id="error" style="display: none;">
									Wystąpiły problemy techniczne, adres email nie został zarejestrowany. 
								</div>
							</div>
    
<?php echo '
        
    <script>
     
     function  valid()
     {
         var regex = /^([a-zA-Z0-9_.+-])+\\@(([a-zA-Z0-9-])+\\.)+([a-zA-Z0-9]{2,4})+$/;
         var res = true;
         if (!regex.test($("#emailTxt").val()))
         {
             $("#errLabel").show();
             res = false;
         }
         else
         {
             $("#errLabel").hide();
         }
         
         return res;
     }
    
    $(document).ready(function() {        
        $("#sendButton").click(function(event)
        {
            event.preventDefault();
            var rawUrl = \'https://finka.pl\';
            var action ='; ?>
<?php echo $this->_tpl_vars['action']; ?>
<?php echo ';
            var url = rawUrl;
            var email = $("#emailTxt").val();
            
            if (valid())            
            {               
                
                $.ajax({
                    url: "http://finka.pl",
                    type: "GET",
                    data: {email: email, a: action},
                    crossDomain: true,
                    success: function()
                    {
                       
                        $("#newsletter").hide();                        
                        $("#result").show();
                    },
                    
                    error: function()
                    {    
                        $("#newsletter").hide();                                                
                        $("#error").show();
                        
                        //$("#error").show(200, 
                         //   setTimeout(function(){
                        //        $("#error").hide();                        
                        //        $("#newsletter").show();
                      // }
                      // ,3000));
                    }
                });
            }
            else
            {
                
            }
        });
    });
</script>
'; ?>
