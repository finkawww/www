{LITERAL}
<script type="text/javascript">
?(document).ready(
	function()
		{
			$("#khWyslij").click(
				function()
				{
					var nazwa = $("#khNazwa").val();
					var email = $("#khEmail").val();
					var ap = $("#khAp").val();
										
					$.ajax({
						url: "index.php",
						type: "POST",
						data: { nazwa: nazwa, email: email, ap: ap },
						success: function(msg)
						{
							$("#kontener").fadeIn(200);
							$("#kontener").html("Dziêki, jak coœ pytaj znowu");
							$("#kontener").fadeOut(200);							
						},
						error: function()
						{
							$("#kontener").fadeIn(200);
							$("#kontener").html("Problemy techniczne spróbuj póŸniej");
							$("#kontener").fadeOut(200);							
						}
					})
				}
			)
			
			$("#khNazwa").enter(
				function()
				{
					$("#khNazwa").text="";
				}
			)
			$("#khNazwa").exit(
				function(){
					if($("#khNazwa").text=="")
					{
						$("#khNazwa").text="Imiê, nazwisko, firma*";
					}
				}
			)
		}
)
</script>
{/LITERAL}

<div id="kontener">
	<form id="khForm" name="KontaktHeader" action="">
		<input id="khAp" type="hidden" value={$action} />
		<input id="khNazwa" type="text">Imiê, nazwisko, firma*</input>
		<input id="khEmail" type="text">Adres e-mail*</input>
		<input id="khNrTel" type="text">Numer telefonu*</input>
		<textarea id="khPytanie">Pytanie*</textarea>
		<input type="submit" id="khWyslij">Wyœlij</input>
	</form>
</div>




<!--
<head>
	<title>Kurs jQuery #3 example 7</title>
	<script type="text/javascript" src="jquery-1.7.1.min.js"></script>
	<script type="text/javascript">
	jQuery(document).ready(function() {
		$("#guzik").click(function() {
			var tekst = $('input[name=tekst]').val();
 
			$.ajax({
				url: "php1.php",
				type: "POST",
				data: "indeks="+tekst,
				success: function(msg) {
					$("#kontener").text(msg);
				}
			});
		});
	});
	</script>
</head>
 
<body>
	<form action="">
		<input type="text" name="tekst" />
		<input type="button" id="guzik" value="KLIK" />
	</form>
	<div id="kontener"></div>
</body>



-->