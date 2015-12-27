main.controller('privacyController',['utilities',function(utilities){
	var self = this;
	
    self.faqList = [
        {
            title : 'Dati raccolti',
            content : 'I dati che raccogliamo includono informazioni personali e informazioni tecniche. I dati tecnici sono informazioni necessarie al corretto funzionamento di alcune funzionalità del sito; la mancanza di tali informazioni non impedisce una normale navigazione del sito, ma, se memorizzate, abilitano un insieme di funzionalità avanzate, altrimenti impossibile da offrire (ad esempio la creazione di un’utenza e la gestione del proprio profilo, il pagamento tramite PayPal, etc). Le informazioni personali sono dati che invece non sono strettamente legate alle funzionalità avanzate del sito (ad esempio, nome, cognome, immagine del profilo, etc.) e sono fornite su base volontaria. Tali informazioni consentono ad esempio di personalizzare la pagina del proprio profilo, di collezionare informazioni sull’uso e la frequenza di visita del sito. Alcune delle informazioni da noi raccolte potrebbero far uso di servizi di terzi (ad esempio, Google Analytics) ed è nostra cura applicare una procedura di anonimizzazione.'
        },
        {
            title : 'Modalità di utilizzo dei dati raccolti',
            content : 'Utilizziamo i dati da te forniti solo per finalità statistiche o per contattarti. Dati personali quali nome, cognome o data di nascita non sono obbligatori e sono acquisiti solo a fini statistici. In generale, i dati personali da noi raccolti sono funzionali solo ad una migliore navigazione del sito, sia in termini di presentazione che di suggerimento dei nostri contenuti.'
        },
        {
            title : 'Accesso ai dati personali e aggiornamento',
            content : 'In fase di iscrizione verrà richiesto di fornire alcune informazioni personali, quali nome, cognome, una password, un indirizzo mail e un nome utente di propria invenzione. Qualora in futuro ti venga richiesto di inserire altre informazioni, sarà nostra cura garantirti la possibilità di modificare, aggiungere o cancellare qualunque tua informazione personale.'
        },
        {
        	title: 'Sicurezza delle informazioni',
        	content: 'Le informazioni da noi raccolte sono crittografate utilizzando SSL. L’accesso a tali informazioni è protetto e riservato ai soli soci.'
        },
        {
        	title: 'Modifiche alle norme sulla privacy di reSeed.it',
        	content: 'E’ possibile che le nostre norme sulla privacy possano subire leggeri cambiamenti di tanto in tanto. Sarà nostra premura avvisarti quando questo accadrà, tramite un apposito banner dedicato. Questo verrà visualizzato al tuo primo accesso successivo alle modifiche al testo e ti verrà chiesto di confermarci di aver letto la nuova informativa sulla privacy.'
        }
    ];
    
    self.getColours = function(index){
        return utilities.getColours(index,self.faqList.length);
    };
    
}]);