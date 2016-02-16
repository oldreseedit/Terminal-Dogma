main.factory('utilities',function(){
    
    // Implementazione dell'algoritmo euclideo esteso - costruisce l'identità di Bezout.
    
    this.bezout = function(a,b,c){ // di modo che risulti c = k_1 * a + k_2 * b
        c = c || 1;
        
        var temp, q;
        var s=0, sold=1, t=1, told=0, r=b, rold=a;
        
        while(r != 0)
        {
            q = (rold - rold%r)/r;
            
            temp = r;
            r = rold - q*r;
            rold = temp;
            
            temp = s;
            s = sold - q*s;
            sold = temp;
            
            temp = t;
            t = told - q*t;
            told = temp;
        }
        
        /*  I coefficienti di Bezout sono sold e told, l'MCD è rold, n/MCD = t, n-1/MCD = s */
        /*  Questo vuol dire che l'identità di Bezout è rold = sold*n + told*(n-1), e per ottenere l'equazione voluta devo moltiplicare tutto per c/rold. */
        
        var k1 = sold*c/rold;
        var k2 = told*c/rold;
        
        return {
            k1 : k1,
            k2 : k2,
            gcd : rold
        };
    };
    
    // Restituisce l'MCD tra due numeri.
    
    this.gcd = function(a,b){
        return this.bezout(a,b).gcd;
    };
    
    // Restituisce i valori elementsWidth, spacerWidth, outerWidth che un insieme di "numberOfDivs" deve possedere per essere considerato "spaced".
    
    this.spacedSizes = function(numberOfDivs, outerWidth){
        
        outerWidth = outerWidth || 0;
        if(outerWidth == 100) return 0;
        
        /*  Qui dovrei chiamare la funzione "bezout" definita sopra, perché vorrei sapere per quali k1 e k2 (che rappresentano le lunghezze rispettivamente dei div e degli spacer), 
                    100 = k1*numberOfDivs + k2*(numberOfDivs-1)  *** eq. 1 ***
            ove (numberOfDivs-1) è il numero degli spazi contenuti tra "numberOfDivs" elementi.
            Tuttavia questo non è necessario, poiché nel caso specifico di "n" e "n-1", si ottiene facilmente che 1 = n - (n-1), e quindi 100 = 100*n - 100*(n-1)
            (vd. sotto per outerWidth)
        */
        
        var elementsWidth = 100-2*outerWidth;
        var spacerWidth = -100+2*outerWidth;
        
        /*  Numeri negativi non hanno significato per lunghezze di elementi, ed inoltre vorrei che gli elementi non vengano appiccicati, quindi
            1.  Poiché, data una soluzione (k1, k2) dell'equazione diofantea ***1*** sono soluzioni anche (k1 - u*(numberOfDivs-1), k2 + u*(numberOfDivs)) per ogni u \in Z,
                cerco la u minimale affinché k2 sia positivo (ovvero, gli spacer non abbiano lunghezza negativa o nulla).
                Questo è possibile, conti alla mano, prendendo u > (100-100%n)/n, che quindi (per garantire la minimalità) porrò a (100-100%n)/n + 1.
                
            2.  Potrebbe ben accadere che per l'u trovato in questo modo, tuttavia, il k1 - u*(numberOfDivs-1) venga negativo o nullo: un esempio è per numberOfDivs = 11.
                Infatti, per 11 risulterebbe u = 9 + 1 = 10. Ma allora elementsWidth diventerebbe 100 - 10*(11-1) = 0.
                Allo stesso modo, potrebbe essere indesiderato il risultato per cui la lunghezza degli elementi è più piccola di quella dello spacer.
                Quel che farò in questi casi sarà dunque aggiungere un margine esterno, chiamato "outerWidth", il più piccolo possibile, e reiterare quanto appena fatto tenendo presente
                che lo spazio da riempire (ad esempio nel caso outerWidth = 3) non è più del 100%, ma del 94%.
                
            3.  Se poi voglio controllare che gli elementi non vengano appiccicati, e quindi garantire un minimo spacerWidth, controllo direttamente tale asserzione, e nel caso,
                prima di continuare, aumento u. Allo stesso modo, se desiderato, posso garantire che gli spazi si avvicinino ad un certo fissato rapporto che decidiamo essere
                ottimale. i.e. phi, pi, 1/e, ecc.
        */
        
        var u = ((100-2*outerWidth)-(100-2*outerWidth)%numberOfDivs)/numberOfDivs + 1;
        elementsWidth -= u*(numberOfDivs-1);
        spacerWidth += u*(numberOfDivs);
        
        if(spacerWidth == 0)
        {
            elementsWidth -= numberOfDivs-1;
            spacerWidth += numberOfDivs;
        }
        
        if(elementsWidth <= spacerWidth)
        {
            return this.spaced(numberOfDivs,outerWidth+1); /*   Vi è una soluzione più elegante di questa, matematicamente, ma non sapendo se i numeri a cui siamo arrivati siano
                                                                coprimi oppure no, bisognerebbe comunque applicare un algoritmo che ci mette O(log(n)), e in più controllare l'effettivo
                                                                valore dell'MCD. Fatica sprecata: anche se apparentemente questo è un O(n), penso si potrebbe dimostrare che non accade
                                                                mai che vi siano più di 5-6 iterazioni.
                                                            */
        }
        
        return {
            elementsWidth : elementsWidth,
            spacerWidth : spacerWidth,
            outerWidth : outerWidth
        };
    };
    
    // Restituisce i valori elementsWidth, spacerWidth, outerWidth che un insieme di "numberOfDivs" deve possedere per essere considerato "centered".
    
    this.centeredSizes = function(numberOfDivs){
       
        var widths = this.bezout(2,numberOfDivs,100);
        
        var outerWidth = widths.k1;
        var elementsWidth = widths.k2;
        var gcd = this.gcd(2,numberOfDivs);
        
        // Questa u è quella che minimizza la lunghezza dei bordi esterni
        
        var u = ((outerWidth*gcd)-(outerWidth*gcd)%numberOfDivs)/numberOfDivs;
        
        elementsWidth += u*(2/gcd);
        outerWidth -= u*(numberOfDivs/gcd);
        
        if(outerWidth < 0){
            elementsWidth -= 2/gcd;
            outerWidth += numberOfDivs/gcd;
        }
       
        return{
            elementsWidth : elementsWidth,
            spacerWidth : 0,
            outerWidth : outerWidth
        };
        
    };
    
    // Restituisce i valori elementsWidth, spacerWidth, outerWidth che un insieme di "numberOfDivs" deve possedere per essere considerato "normal".
    
    this.normalSizes = function(numberOfDivs){
        
        return {
            elementsWidth : (100-100%numberOfDivs)/numberOfDivs,
            spacerWidth : 0,
            outerWidth : 0
        };
        
    };
    
    /* Given the width (in %) of the spacer and the number of elements, it returns the correct styles for the single elements */
    this.sizesWithSpacer = function(spacer,numberOfDivs){
        return {
            elementsWidth : ((100-(numberOfDivs-1)*spacer)/numberOfDivs)/100,
            spacerWidth : spacer,
            outerWidth : 0
        };
    };
    
    this.printCentered = function(n){
        console.log(this.centered(n));
    };
    
    this.printSpaced = function(n){
        console.log(this.spaced(n));
    };
    
    this.printNormal = function(n){
        console.log(this.normal(n));
    };
    
    this.getColours = function(i,total){
        total = (total > 6 ? 6 : total);
        
        // var module = Math.round(((i%6)*5)/(total-1)); // To use all the colors
    	var module = i%6; // To use all the colors in turn (round-robin)
    	
        var colour = '';
        switch (module) {
            case 0:
                colour = 'olive';
                break;
            case 1:
                colour = 'lawn';
                break;
            case 2:
                colour = 'green';
                break;
            case 3:
                colour = 'leaf';
                break;
            case 4:
                colour = 'pond';
                break;
            case 5:
                colour = 'water';
                break;
        }
        return colour;
    };
    
    return {
    	bezout : this.bezout,
    	gcd : this.gcd,
    	spacedSizes : this.spacedSizes,
    	centeredSizes : this.centeredSizes,
    	normalSizes : this.normalSizes,
    	sizesWithSpacer : this.sizesWithSpacer,
    	printCentered : this.printCentered,
    	printSpaced : this.printSpaced,
    	printNormal : this.printNormal,
    	getColours: this.getColours
    	
    }
    
});


