main.controller('disclaimerController',['utilities',function(utilities){
	var self = this;
	
    self.faqList = [
        {
            title : 'Privacy',
            content : 'reSeed ha a cuore la tua privacy. Tutte le informazioni che raccogliamo sono raccolte per soli fini statistici o per contattarti.'
        },
        {
            title : 'Sicurezza',
            content : 'Nonostante sia nostra continua premura cercare di offrire la massima sicurezza, tale obiettivo non dipende solo da noi. Abbiamo bisogno che tutti gli utenti registrati su reseed.it contribuiscano attivamente a tenere il sito un luogo sicuro. E’ responsabilità degli utenti non caricare materiale protetto da copyright, pornografico o in grado di ledere diritti altrui, ivi incluso materiale dannoso (virus, malware, codici dannosi in generale).'
        },
        {
            title : 'Usi consentiti',
            content : 'È vietato l’utilizzo di questo sito Web se non per scopi di carattere privato e non commerciale. È altresì vietato l’utilizzo di qualsiasi sistema automatico o di applicazioni software volti ad estrarre dati a scopo commerciale (screen scaping).'
        },
        {
        	title : 'Diritti di proprietà intellettuale',
        	content: 'È fatto divieto il riuso non autorizzato di tutto il materiale presente su reseed.it, ivi inclusi nomi, logo, prezzi e così via, nonché lo schema di colori e il layout del sito Web, sono soggetti a copyright. È possibile utilizzare tali contenuti esclusivamente per gli scopi privati e non commerciali. Ogni altro utilizzo o riproduzione non autorizzata rappresenta una violazione delle presenti Condizioni d’uso e una violazione dei diritti di proprietà intellettuale di reseed.it.'
        },
        {
        	title: 'Pagamenti online tramite PayPal',
        	content: 'reSeed offre la possibilità di effettuare il pagamento di uno o più corsi tramite apposito pulsante PayPal. E’ cura dell’utente leggere accuratamente i termini d’uso di Paypal al seguente indirizzo <a href=”https://www.paypal.com/it/webapps/mpp/ua/useragreement-full” target=”_”>https://www.paypal.com/it/webapps/mpp/ua/useragreement-full</a>.'
        }
    ];
    
    self.getColours = function(index){
        return utilities.getColours(index,self.faqList.length);
    };
    
}]);