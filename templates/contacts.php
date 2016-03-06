<div id="contacts" ng-controller="contactsController as contacts">
    <div class="container">
        <h3>Contatti</h3>
        <p class="introduction">Hai bisogno di informazioni? Ti serve qualche chiarimento? Hai una voglia incontenibile di seguire un corso ma hai un dubbio? Per qualsiasi domanda non esitare a contattarci!</p>
        <div id="contact-form-wrapper" ng-class="contacts.getClass(0)">
            <div class="container">
                <h4>Contattaci</h4>
                <div id="contact-form">
                    <div class="container">
                        <form id="contactForm" name="contactForm" ng-submit="contacts.submit()" novalidate>
                            <bootstrap-input form="contactForm" type="text" name="name" placeholder="Nome e Cognome" ng-model="contacts.contactsForm.name" ng-minlength="2" required="required"></bootstrap-input>
                            <bootstrap-input form="contactForm" type="email" name="from" placeholder="Indirizzo e-mail" ng-model="contacts.contactsForm.from" required="required"></bootstrap-input>
                            <bootstrap-input form="contactForm" type="text" name="subject" placeholder="Oggetto" ng-model="contacts.contactsForm.subject" ng-minlength="4" required="required"></bootstrap-input>
                            <bootstrap-textarea form="contactForm" rows="3" name="message" placeholder="Inserisci qui il tuo messaggio" ng-model="contacts.contactsForm.message" ng-minlength="10" ng-maxlength="1000" required="required"></bootstrap-textarea>
                            <input type="submit" id="contacts-submit" class="btn-success" ng-disabled="contactForm.$invalid" value="Invia"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="how-to-map-wrapper" ng-class="contacts.getClass(1)">
            <div class="container">
                <h4>Come arrivare</h4>
                <ul id="contacts-list">
                    <li>Con i mezzi:
                        <ul>
                            <li>Dalla <b>stazione Termini</b>: prendere la metro B fino alla stazione metro Rebibbia, 2 minuti a piedi.</li>
                            <li>Dalla <b>stazione Tiburtina</b>: prendere la metro B fino alla stazione metro Rebibbia, 2 minuti a piedi.</li>
                        </ul>
                    </li>
                    <li>Con auto/moto:
                        <ul>
                            <li>Dal Grande Raccordo Anulare, uscita 13 per Tiburtina in direzione Centro, continuare per 2.8 km.</li>
                            <li>Dal centro raggiungere via Tiburtina in direzione Grande Raccordo Anulare, continuare su via Tiburtina fino all'arrivo alla stazione metro Rebibbia.</li>
                        </ul>
                    </li>
                </ul>
                
                <div class="message-with-symbol">
                	<div><i class="fa fa-4x fa-pull-left text-danger fa-exclamation-circle"></i></div>
                	<div class="text-align"><p><strong>Nota:</strong> I corsi si svolgono presso le aule del Centro Studi Castro Pretorio, all'interno di un grande consorzio. Per accedere alla palazzina del centro studi <strong>chiedere al portiere</strong>.</p></div>
                </div>
                
                <div class="message-with-symbol">
                	<div><i class="fa fa-4x fa-pull-left text-primary fa-info-circle"></i></div>
                	<div class="text-align"><p>Il consorzio offre ampia disponibilità di <strong>parcheggio per motorini e auto</strong>!</p></div>
                </div>
                
                <div id="contacts-map" ng-if="contacts.mapIsReady">
                    <ui-gmap-google-map center="contacts.map.center" zoom="contacts.map.zoom" options="contacts.map.options" control="contacts.map.control">
                        <ui-gmap-marker idKey="contacts.marker.id" coords="contacts.marker.coords" options="contacts.marker.options">
                            <ui-gmap-window templateUrl="contacts.infoUrl">
                            </ui-gmap-window>
                        </ui-gmap-marker>
                    </ui-gmap-google-map>
                </div>
            </div>
        </div>
    </div>
</div>