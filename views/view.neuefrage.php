Stelle deine eigenen Fragen.<br>

<form id="regsitrierenForm" method="post" action="?task=neuefrage" data-ajax="false">
Wie lautet die Frage?:
<input name="Fragestellung" id="Fragestellung" placeholder="Fragestellung" value="" >
<br>
Zu welcher Kategorie gehört diese?
<select name="Kategorie" id="Kategorie">
    
 <option value="0">Zahlen und Fakten</option> 
 <option value="1">Professoren</option> 
 <option value="2">Studentenleben</option> 
 <option value="3">Vorlesungen</option> 
 <option value="4">Mensa</option>
 <option value="5">Initiativen</option>
 <option value="6">Pforzheim</option>

</select>
<br>
Die richtige Antwort lautet:
<input name="Antwort0" id="Text0" placeholder="Antwort" value="" >
<br>
Weitere Antwortmöglichkeit 1:
<input name="Antwort1" id="Text0" placeholder="Antwort" value="" >
<br>
Weitere Antwortmöglichkeit 2:
<input name="Antwort2" id="Text0" placeholder="Antwort" value="" >
<br>
Weitere Antwortmöglichkeit 3:
<input name="Antwort3" id="Text0" placeholder="Antwort" value="" >
<br>
<button type="submit" name="update" id="insert" value="1" >Speichern</button>
</form>
