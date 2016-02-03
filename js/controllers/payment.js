main.controller('paymentController',['utilities','$uibModal','$sce','$cookies','$server',function(utilities,$modal,$sce,$cookies,$server){
    var self = this;
    
    self.step1 = false;
    self.step2 = false;
    self.step3 = false;
    self.content = '';
    self.numberOfCourses = 0;
    
    self.checkStep1 = function(){
        if(self.gameDesign || self.gameMaker || self.studioMax) self.step1 = true;
        else
        {
            self.step1 = false;
            self.step2 = false;
            self.step3 = false;
            
            self.rate = self.paymentChoice = false;
        }
        
        self.countNumberOfCourses();
        
        self.setContent();
    };
    
    self.checkStep2 = function(){
        if(self.rate) self.step2 = true;
        else
        {
            self.step2 = false;
            self.step3 = false;
            
            self.paymentChoice = false;
        }
        
        self.setContent();
    };
    
    self.checkStep3 = function(){
        if(self.paymentChoice)
        {
            self.step3 = true;
            self.setContent();
        }
        else self.step3 = false;
        
        self.setContent();
    };
    
    self.coursesPaid = function(){
        
        $server.post('payment_interface/get_payment', {username : $cookies.get('username'), courseID : ['gameDesign','gameMaker','3DStudioMax']}).then(function(response){
            self.coursesAlreadyPaid = response.data;
            self.ready = true;
        },function(error){
            console.log(error);
        });
    };
    
    self.alreadyPaid = function(course){
        // console.log(self.coursesAlreadyPaid);
        // console.log(self.coursesAlreadyPaid[course]);
        return self.coursesAlreadyPaid[course] ? true : false;
    };
    
    self.countNumberOfCourses = function(){
        self.numberOfCourses = (self.gameDesign ? 1 : 0) + (self.gameMaker ? 1 : 0) + (self.studioMax ? 1 : 0);
    };
    
    self.openDisclaimer = function(){
        var modalInstance = $modal.open({
            templateUrl: 'templates/paymentDisclaimer.php',
            controller: 'paymentDisclaimerController as paymentDisclaimer',
            animation: true,
            backdrop: 'static',
            size: 'lg',
            
        });
        
        modalInstance.result.then(function(){
            
        },function(){
            
        });
    };
    
    self.setPendingPayment = function(){
        var expire = moment().add(1,'hour').toDate();
        $cookies.put('pendingPayment','1',{path:'/',expires: expire});
        var choices = {};
        if(self.gameDesign) choices.gameDesign = '1';
        else choices.gameDesign = '0';
        if(self.gameMaker) choices.gameMaker = '1';
        else choices.gameMaker = '0';
        if(self.studioMax) choices.studioMax = '1';
        else choices.studioMax = '0';
        choices.rate = self.rate;
        choices.paymentChoice = self.paymentChoice;
        $cookies.putObject('choices',choices,{path:'/',expires: expire});
    };
    
    self.setContent = function(){
        
        if(self.paymentChoice === 'contanti'){
            if(self.rate === 'rate'){
                self.content = '<ul>'+
                '<li>Con le modalità da te scelte dovrai effettuare tre pagamenti dell\'ammontare di <b>' + Math.round((self.numberOfCourses*450 - 25*self.numberOfCourses*(self.numberOfCourses-1))*100/3)/100 + '€ ciascuno</b>.</li>'+
                '<li>I pagamenti dovranno essere effettuati alla prima lezione del mese che intendi pagare, qual' + (self.numberOfCourses>1?'i':'e') + ' che sia' + (self.numberOfCourses>1?'no':'') + ' i' + (self.numberOfCourses>1?'':'l') +' cors'+ (self.numberOfCourses>1?'i':'o') + ' a cui sei iscritto.</li>'+
                '<li>Contestualmente al pagamento stesso ti rilasceremo una ricevuta di effettuato pagamento.</li>';
            }
            if(self.rate === 'oneShot'){
                self.content = '<ul>'+
                '<li>Con le modalità da te scelte dovrai effettuare un unico pagamento dell\'ammontare di <b>' + (self.numberOfCourses*450 - 25*self.numberOfCourses*(self.numberOfCourses-1))*95/100 + '€</b>.</li>'+
                '<li>Il pagamento dovrà essere effettuato alla prima lezione che seguirai, qual' + (self.numberOfCourses>1?'i':'e') + ' che sia' + (self.numberOfCourses>1?'no':'') + ' i' + (self.numberOfCourses>1?'':'l') +' cors'+ (self.numberOfCourses>1?'i':'o') + ' a cui sei iscritto.</li>'+
                '<li>Contestualmente al pagamento stesso ti rilasceremo una ricevuta di effettuato pagamento.</li>';
            }
            self.button = $sce.trustAsHtml('<button class="btn btn-success btn-lg subscriptionButton">Iscriviti!</button>');
        }
        
        if(self.paymentChoice === 'bonifico'){
            if(self.rate === 'rate'){
                self.content = '<ul>'+
                '<li>Con le modalità da te scelte dovrai effettuare tre pagamenti dell\'ammontare di <b>' + Math.round((self.numberOfCourses*450 - 25*self.numberOfCourses*(self.numberOfCourses-1))*100/3)/100 + '€ ciascuno</b>.</li>'+
                '<li>I dati per effettuare il bonifico sono i seguenti:'+
                    '<ul>'+
                        '<li><b>IBAN</b>: IT29L0832703243000000002465</li>'+
                        '<li><b>Intestatario</b>: Flati Tiziano</li>'+
                        '<li><b>Causale</b>: <i>TUO_NOME_E_COGNOME</i>, <i>NOME_CORS' + (self.numberOfCourses>1?'I':'O') + '</i>, rata numero <i>NUMERO_RATA</i></li>'+
                        '<li>Esempio: Se Mario Rossi deve pagare la seconda rata dei corsi di 3D Studio Max e Game Design la sua causale sarà: <b>Mario Rossi, 3D Studio Max e Game Design, rata numero 2</b></li>'+
                    '</ul>'+    
                '</li>'+
                '<li>Quando la tua banca avrà effettuato il bonifico ti rilascerà il <a href="https://goo.gl/92OGYD">CRO</a>. Scrivi una mail a <a href="mailto:info@reseed.it">info@reseed.it</a> indicando il CRO nel testo della mail e scrivendo la causale nell’oggetto della mail. Quando avremo verificato il pagamento risponderemo alla tua mail. </li>'+
                '<li>I bonifici dovranno essere effettuati alla prima lezione del mese che intendi pagare, qual' + (self.numberOfCourses>1?'i':'e') + ' che sia' + (self.numberOfCourses>1?'no':'') + ' i' + (self.numberOfCourses>1?'':'l') +' cors'+ (self.numberOfCourses>1?'i':'o') + ' a cui sei iscritto.</li>'+
                '<li>Come ricevuta di pagamento farà testo quella rilasciata dalla banca.</li>';
            }
            if(self.rate === 'oneShot'){
                self.content = '<ul>'+
                '<li>Con le modalità da te scelte dovrai effettuare un unico pagamento dell\'ammontare di <b>' + (self.numberOfCourses*450 - 25*self.numberOfCourses*(self.numberOfCourses-1))*95/100 + '€</b>.</li>'+
                '<li>I dati per effettuare il bonifico sono i seguenti:'+
                    '<ul>'+
                        '<li><b>IBAN</b>: IT29L0832703243000000002465</li>'+
                        '<li><b>Intestatario</b>: Flati Tiziano</li>'+
                        '<li><b>Causale</b>: <i>TUO_NOME_E_COGNOME</i>, <i>NOME_CORS' + (self.numberOfCourses>1?'I':'O') + '</i>, saldo'+
                        '<li>Esempio: Se Mario Rossi deve pagare l\'intero costo dei corsi di 3D Studio Max e Game Design la sua causale sarà: <b>Mario Rossi, 3D Studio Max e Game Design, saldo</b></li>'+
                    '</ul>'+    
                '</li>'+
                '<li>Quando la tua banca avrà effettuato il bonifico ti rilascerà il <a href="https://goo.gl/92OGYD">CRO</a>. Scrivi una mail a <a href="mailto:info@reseed.it">info@reseed.it</a> indicando il CRO nel testo della mail e scrivendo la causale nell’oggetto della mail. Quando avremo verificato il pagamento risponderemo alla tua mail. </li>'+
                '<li>Il bonifico dovrà essere effettuato alla prima lezione che seguirai, qual' + (self.numberOfCourses>1?'i':'e') + ' che sia' + (self.numberOfCourses>1?'no':'') + ' i' + (self.numberOfCourses>1?'':'l') +' cors'+ (self.numberOfCourses>1?'i':'o') + ' a cui sei iscritto.</li>'+
                '<li>Come ricevuta di pagamento farà testo quella rilasciata dalla banca.</li>';
            }
            self.button = $sce.trustAsHtml('<button class="btn btn-success btn-lg subscriptionButton">Iscriviti!</button>');
        }
        
        if(self.paymentChoice === 'paypal'){
            if(self.rate === 'oneShot'){
                if(self.numberOfCourses===0) {
                    self.content = '';
                }
                else{
                    if(self.numberOfCourses===1) self.button = $sce.trustAsHtml('<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="AKCHNTK8HMWE2"><button type="submit" class="btn btn-success btn-lg subscriptionButton" name="submit" alt="PayPal è il metodo rapido e sicuro per pagare e farsi pagare online."><img class="resp-img" src="imgs/caccia.png" /></button></form>');
                    if(self.numberOfCourses===2) self.button = $sce.trustAsHtml('<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="EB3V9C96T47A6"><button type="submit" class="btn btn-success btn-lg subscriptionButton" name="submit" alt="PayPal è il metodo rapido e sicuro per pagare e farsi pagare online."><img class="resp-img" src="imgs/caccia.png" /></button></form>');
                    if(self.numberOfCourses===3) self.button = $sce.trustAsHtml('<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="75VUU252L767L"><button type="submit" class="btn btn-success btn-lg subscriptionButton" name="submit" alt="PayPal è il metodo rapido e sicuro per pagare e farsi pagare online."><img class="resp-img" src="imgs/caccia.png" /></button></form>');
                    
                    self.content = '<ul>'+
                    '<li>Con le modalità da te scelte dovrai effettuare un unico pagamento dell\'ammontare di <b>' + (self.numberOfCourses*450 - 25*self.numberOfCourses*(self.numberOfCourses-1))*95/100 + '€</b>.</li>'+
                    '<li>Come ricevuta di pagamento farà testo quella rilasciata da Paypal stessa.</li>'+
                    '<li>Clicca sul pulsante per iniziare la procedura di pagamento tramite PayPal. Verrai reindirizzato su una pagina esterna e perfettamente sicura gestita da PayPal stesso.</li>';
                }
            }
            if(self.rate === 'rate'){
                if(self.numberOfCourses===0) {
                    self.subscriptionButton = $sce.trustAsHtml('');
                    self.content = '';
                }
                else{
                    if(self.numberOfCourses===1) self.button = $sce.trustAsHtml('<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="6U9UNY6PHZN4N"><button type="submit" class="btn btn-success btn-lg subscriptionButton" name="submit" alt="PayPal è il metodo rapido e sicuro per pagare e farsi pagare online."><img class="resp-img" src="imgs/caccia.png" /></button></form>');
                    if(self.numberOfCourses===2) self.button = $sce.trustAsHtml('<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="X4Z9D4J3S6EDG"><button type="submit" class="btn btn-success btn-lg subscriptionButton" name="submit" alt="PayPal è il metodo rapido e sicuro per pagare e farsi pagare online."><img class="resp-img" src="imgs/caccia.png" /></button></form>');
                    if(self.numberOfCourses===3) self.button = $sce.trustAsHtml('<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="7S46YANHWMDTU"><button type="submit" class="btn btn-success btn-lg subscriptionButton" name="submit" alt="PayPal è il metodo rapido e sicuro per pagare e farsi pagare online."><img class="resp-img" src="imgs/caccia.png" /></button></form>');
                
                    self.content = '<ul>'+
                    '<li>Con le modalità da te scelte dovrai effettuare tre pagamenti dell\'ammontare di <b>' + Math.round((self.numberOfCourses*450 - 25*self.numberOfCourses*(self.numberOfCourses-1))*100/3)/100 + '€ ciascuno</b>. Ognuna di queste tre rate verrà prelevata automaticamente da Paypal, scaduto il termine delle quali l\'<i>abbonamento</i> scadrà automaticamente.</li>'+
                    '<li>Come ricevuta di pagamento farà testo quella rilasciata da Paypal stessa.</li>'+
                    '<li>Clicca sul pulsante per iniziare la procedura di pagamento tramite PayPal. Verrai reindirizzato su una pagina esterna e perfettamente sicura gestita da PayPal stesso.</li>';
                }
            }
        }
        
    };
    
}]);
