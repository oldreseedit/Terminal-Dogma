main.controller('faqController',['utilities',function(utilities){
    var self = this;
    
    self.faqList = [
		{
		    question : 'Dove si tengono le lezioni?',
		    answer : 'Nel Centro Studi Castro Pretorio, a due passi dalla metro Rebibbia. <a href="/contacts">Guarda la mappa</a>!'
		},
		{
		    question : 'Cosa è l’On-The-Job Training?',
		    answer : 'Si tratta di un periodo di apprendistato in cui gli studenti di diversi corsi collaborano tra loro applicando ciò che hanno imparato durante i corsi all’interno di un progetto reale, fornito da aziende esterne o da noi stessi.'
		},
		{
		    question : 'Come vengono pubblicati i lavori degli studenti?',
		    answer : 'I prodotti dell’On-The-Job Training vengono pubblicati nella maniera più coerente con il tipo di prodotto. Ad esempio se è stato sviluppato un gioco per dispositivi mobili verrà pubblicato sui principali market (Google Play, etc.)'
		},
		{
		    question : 'Come funziona il meccanismo dei punti esperienza?',
		    answer : 'È molto semplice. Svolgendo azioni didatticamente positive, come essere presenti a lezione, partecipare attivamente o svolgere esercitazioni, lo studente guadagna punti esperienza. Raggiunte determinate soglie lo studente sale di livello sbloccando ricompense e medaglie, come gadget, materiale di studio aggiuntivo, interviste, etc.'
		},
		{
		    question : 'Come funzionano i vostri eventi Open Day?',
		    answer : 'Sono eventi gratuiti in cui presentiamo i nostri docenti (noi!) e i nostri corsi. Tipicamente vengono strutturati a mo’ di workshop/clinic, ovvero con dimostrazioni da parte nostra di cosa è possibile realizzare con le tecnologie che insegniamo'
		},
		{
		    question : 'Quanto sono effettivamente pratici i vostri corsi?',
		    answer : 'Molto. Tutti i corsi prevedono frequenti esercitazioni sia durante le lezioni che in sessioni dedicate. '
		},
        {
            question : 'Perché dovrei seguire uno dei vostri corsi?',
            answer : 'Per due motivi. Il primo è che i nostri docenti sono innanzitutto professionisti che lavorano quotidianamente con gli strumenti che insegnano. Il secondo è che tramite le simulazioni di On-The-Job Training gli studenti hanno la possibilità di toccare con mano il funzionamento delle cose al di fuori dell’ambiente accademico, realizzando al tempo stesso un prodotto di qualità sufficiente per essere inserito nel curriculum'
        },
        {
            question : 'Cosa vi differenzia dagli altri istituti di formazione?',
            answer : 'reSeed è un insieme di ragazzi che vogliono insegnare ad altre persone quello che sanno fare e condividere con loro le proprie esperienze. Non ci sono altre persone, infrastrutture o intermediari: è fatto solo da docenti per gli studenti.'
        },
        {
            question : 'Sono interessato a un corso. Come faccio ad avere più informazioni?',
            answer : 'Puoi contattarci tramite la pagina contatti in qualsiasi momento e per qualsiasi cosa. Inoltre organizziamo in continuazione eventi a porte aperte e di orientamento gratuiti durante i quali diamo a chiunque la possibilità di farsi un’idea di come funzionano le cose da noi.'
        },
        {
            question : 'Rilasciate un certificato a fine corso?',
            answer : 'Certamente. Tutti gli studenti avranno un certificato di frequenza che attesterà la partecipazione a quel corso.'
        },
        {
            question : 'E’ possibile pagare a rate?',
            answer : 'Yep. Una rata per ogni mese di corso!'
        },
        {
            question : 'Sono interessato a un corso ma non posso seguirlo in quegli orari/giorni',
            answer : 'Scrivici! Se si riesce a radunare un numero di studenti sufficiente è spesso possibile attivare un’altra classe!'
        },
        {
        	question : 'A quali condizioni parte un corso? Cosa succede se mi sono iscritto un corso che ha pochi studenti?',
        	answer: 'Un corso parte con almeno 5 iscrizioni. Qualora non si raggiungesse il numero minimo fissato, gli iscritti verranno rimborsati.'
        },
        {
        	question: 'Entro quando posso iscrivermi?',
        	answer: 'Le iscrizioni sono aperte fino a un mese prima dell\'effettiva partenza di un corso. Puoi iscriverti tutto l\'anno!'
        }
    ];
    
    self.getColours = function(index){
        return utilities.getColours(index,self.faqList.length);
    };
    
}]);