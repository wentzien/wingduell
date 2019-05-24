 $("#regsitrierenForm").validate({
    rules: {
        nachname: {
            required: true
            
        },
        vorname: {
            required: true           
        },
        kennung: {
            required: true,
            minlength: 4
        },
        passwort: {
            required: true,
            minlength: 4
            
       }, 
    },
    messages: {
        nachname: {
            required: "Der Nachname ist ein Pflichtfeld"
            
         },     
        vorname: {
            required: "Plichtfeld"
           
        },
       
        kennung: {
            required: "Plichtfeld"
        },
        passwort: {
            required: "Plichtfeld"
        },
        
    }
   
});