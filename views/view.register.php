

<form id="regsitrierenForm" method="post" action="?task=newregister" data-ajax="false">
    <div class="ui-field-contain">
        
             <label for="nachname">Nachname:</label><input  name="Nachname" id="nachname" placeholder="Nachname" value="" />
              <label for="vorname">Vorname:</label><input  name="Vorname" id="vorname" placeholder="Vorname" value="" />
               <label for="kennung">Kennung:</label><input  name="Kennung" id="kennung" placeholder="Kennung" value="" />         
              <label for="passwort">Passwort:</label><input  name="Passwort" id="passwort" placeholder="Passwort" value="" type="password" /> 
            <label for="update">Registrieren:</label><button type="submit" name="update" id="insert" value="1" >Registrieren</button>
    </div>
</form>

<?php