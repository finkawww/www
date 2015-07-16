function cookiepolicyclose(){
   document.getElementById('politykacookie').style.display="none";
   document.cookie = "politykacookie=true; path=/; max-age=2592000;";
}

var txPolitykaCookie='<div id="politykacookie" style="padding-top: 10px; height: 60px; width: 100%;background: #d6e4e9;line-height: 24px; text-align: center; color: #006097;font-size: 11px; font-family: tahoma; font-weight: bold; text-shadow: 0 1px 0 #94CAFF;  box-shadow: 0 0 15px #00214B; position: fixed; bottom: 0; z-index: 999"><div onclick="cookiepolicyclose()" style="cursor:pointer;float: right;text-align: center;margin-right: 10px;border: 1px solid #003366;font-size: 10px;line-height: 16px;height: 16px; width: 16px">X</div> <div style="text-align: center; margin: auto; width: 960px;line-height: 24px">Strona www.finka.pl oraz powiązane z nią serwisy korzystają z plików cookies w celu realizacji usług zgodnie z <a style="text-decoration: underline" target="_blank" href="http://www.finka.pl/FrontPage/Files/OtherFiles/polityka_plikow_cookies.pdf">Polityką Plików Cookies</a>. Warunki przechowywania lub dostępu do plików cookies możesz określić w Twojej przeglądarce.</div></div>';

if (document.cookie.indexOf('politykacookie=true') === -1){
   document.write(txPolitykaCookie);
}
