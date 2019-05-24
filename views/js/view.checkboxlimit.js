
	// Counter für bereits markierte
	var count;
	count = 0;
	// Maximal auswählbar
	var maxChecks;
	maxChecks = 2;

	function checkCheckbox(checknNum){
		// wenn Counterwert größer ist der maximale Auswahlwert
		if (count > maxChecks){
			// Den Checkbox mit der "CheckNum" nicht aktivieren
			document.Form.Kategorienwahl_[checknNum].checked = false;
		}else{
			// Counterwert erhöhen
			count++;
			// Den Checkbox mit der "CheckNum"  aktivieren
			document.Form.Kategorienwahl_[checknNum].checked = true;
		}
	}
