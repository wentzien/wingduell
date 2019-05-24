<?php
$userrating = Core::$user->rating;
If ($userrating > 2500)
    {$farbe = "Tomato";
     $Beiname = "Großmeister";
    
    }
    elseif ($userrating > 2000) {
        $farbe = "Orange";
        $Beiname = "Meister";
    
}  
    elseif ($userrating > 1500) {
        $farbe = "DodgerBlue";
        $Beiname = "Experte";
    
}
    elseif ($userrating > 900) {
        $farbe = "MediumSeaGreen";
        $Beiname = "Lehrling";
    
}
    elseif ($userrating > 500) {
        $farbe = "LightGray";
        $Beiname = "Amateur";
    
}
    elseif ($userrating < 500) {
        $farbe = "Violet";
        $Beiname = "Hör lieber auf!";
    
}
$AnzahlSpiele=Core::$view->SpielAnzahl;
$AnzahlGewSpiele=Core::$view->SpielGewAnzahl;
$Siegesquote=Core::$view->Siegesquote;
$Lieblingsgegner=Core::$view->Lieblingsgegner;
$Lieblingsherausforderer=Core::$view->Lieblingsherausforderer;
$Lieblingsherausgeforderter=Core::$view->Lieblingsherausgeforderter;
$Frage=Core::$view->Frage;
$Kategorie=Core::$view->Kategorie;
?>



<fieldset class="ui-grid-b">

    <div class="ui-block-a">
        
    <div class="ui-grid-b ui-responsive">
        <div class="ui-block-a">
            
            
            
            
            
            
            
            
        </div>
    <div class="ui-block-b">
     <br>
     <br>
     <br>
     <br>
    <label style="font-size:1em;font-weight:bold">Ab 2500 Punkte:</label>    
    <div class="Grossmeister"><center><div></div><label style="font-size:2em;font-weight:normal">Großmeister</label></center></div>
    <label style="font-size:1em;font-weight:bold">Ab 2000 Punkte:</label>
    <div class="Meister"><center><div></div><label style="font-size:2em;font-weight:normal">Meister</label></center></div>
    <label style="font-size:1em;font-weight:bold">Ab 1500 Punkte:</label>
    <div class="Experte"><center><label style="font-size:2em;font-weight:normal">Experte</label></center></div>
    <label style="font-size:1em;font-weight:bold">Ab 900 Punkte:</label>
    <div class="Lehrling"><center><div></div><label style="font-size:2em;font-weight:normal">Lehrling</label></center></div>
    <label style="font-size:1em;font-weight:bold">Ab 500 Punkte:</label>
    <div class="Amateur"><center><div></div><label style="font-size:2em;font-weight:normal">Amateur</label></center></div>
    <label style="font-size:1em;font-weight:bold">Unter 500 Punkte:</label>
    <div class="keinWing"><center><div></div><label style="font-size:2em;font-weight:normal">Kein Wing</label></center></div>
    
    </div>
    <div class="ui-block-c"></div>
    
</div>
        
        
    </div>
    <div class="ui-block-b">

        
        
        <center><h2>Deine Statistik im Überblick</h2></center>


        <div class="ui-responsive" style="background-color:<?=("$farbe")?>"><center><label><h2><?=($Beiname) ?></h2></label><label><h1>Rating: <?php echo($userrating) ?></h1></label></center></div>

    

        
        
        
        
        
<font size="4">




<table data-role="table" id="movie-table" data-mode="reflow" class="ui-body-c ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columns to display..." data-column-popup-theme="b">
    <thead>
    <tr>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <body>
    <tr>
        <td>Anzahl gespielter Spiele:</td>
        <td><?php echo($AnzahlSpiele) ?></td>
    </tr>
    <tr>
        <td>Anzahl gewonnener Spiele:</td>
        <td><?php echo($AnzahlGewSpiele) ?></td>
    </tr>
    <tr>
        <td>Siegesquote:</td>
        <td><?php echo($Siegesquote) ?>%</td>
    </tr>
    <tr>
        <td>Lieblingsgegner:</td>
        <td><?php echo($Lieblingsgegner) ?></td>
    </tr>
    <tr>
        <td>Lieblingsherausgeforderter:</td>
        <td><?php echo($Lieblingsherausgeforderter) ?></td>
    </tr>
        <tr>
        <td>Lieblingsherausforderer:</td>
        <td><?php echo($Lieblingsherausforderer) ?></td>
    </tr>
    <tr>
        <td>Häufigste Frage:</td>
        <td><?php echo($Frage) ?></td>
    </tr>
    <tr>
        <td>Häufigste Kategorie:</td>
        <td><?php echo($Kategorie) ?></td>
    </tr>
</body>

</table>
</font>



</div>

<div class="ui-block-c ui-responsive"></div>
</fieldset> 



<style>

.Grossmeister {
background: #B84733;
background: -moz-linear-gradient(top, #B84733 0%, #FF6347 50%, #BA4834 100%);
background: -webkit-linear-gradient(top, #B84733 0%, #FF6347 50%, #BA4834 100%);
background: linear-gradient(to bottom, #B84733 0%, #FF6347 50%, #BA4834 100%);
}
.Grossmeister {
  min-height: 50px;
  text-align: center;
}

.Meister {
background: #C47F00;
background: -moz-linear-gradient(top, #C47F00 0%, #FFA500 50%, #C47F00 100%);
background: -webkit-linear-gradient(top, #C47F00 0%, #FFA500 50%, #C47F00 100%);
background: linear-gradient(to bottom, #C47F00 0%, #FFA500 50%, #C47F00 100%);
}
.Meister {
  min-height: 50px;
  text-align: center;
}


.Experte {
background: #1566B5;
background: -moz-linear-gradient(top, #1566B5 0%, #1E90FF 50%, #1566B5 100%);
background: -webkit-linear-gradient(top, #1566B5 0%, #1E90FF 50%, #1566B5 100%);
background: linear-gradient(to bottom, #1566B5 0%, #1E90FF 50%, #1566B5 100%);
}
.Experte {
  min-height: 50px;
  text-align: center;
}



.Lehrling {
background: #2E8A58;
background: -moz-linear-gradient(top, #2E8A58 0%, #3CB371 50%, #2E8A58 100%);
background: -webkit-linear-gradient(top, #2E8A58 0%, #3CB371 50%, #2E8A58 100%);
background: linear-gradient(to bottom, #2E8A58 0%, #3CB371 50%, #2E8A58 100%);
}
.Lehrling{
  min-height: 50px;
  text-align: center;
}

.Amateur {
background: #9C9C9C;
background: -moz-linear-gradient(top, #9C9C9C 0%, #D3D3D3 50%, #9C9C9C 100%);
background: -webkit-linear-gradient(top, #9C9C9C 0%, #D3D3D3 50%, #9C9C9C 100%);
background: linear-gradient(to bottom, #9C9C9C 0%, #D3D3D3 50%, #9C9C9C 100%);
}
.Amateur {
  min-height: 50px;
  text-align: center;
}



.keinWing {
background: #B864B8;
background: -moz-linear-gradient(top, #B864B8 0%, #EE82EE 50%, #B864B8 100%);
background: -webkit-linear-gradient(top, #B864B8 0%, #EE82EE 50%, #B864B8 100%);
background: linear-gradient(to bottom, #B864B8 0%, #EE82EE 50%, #B864B8 100%);
}
.keinWing {
  min-height: 50px;
  text-align: center;
}

</style>