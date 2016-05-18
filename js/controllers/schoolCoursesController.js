main.controller('schoolCoursesController',["utilities",function(utilities){
    var self = this;
    
    self.tabs = [
        {
            id : 'organizzazione',
            faName : 'fa-cog',
            title : 'Organizzazione',
            content : "Decidiamo assieme alla scuola i giorni e gli orari migliori per tenere i corsi. Costi, gratuità, etc possono a loro volta essere aggiustati, siamo flessibili!",
        },
        {
            id : 'lezione',
            faName : 'fa-clock-o',
            title : 'Lezione',
            content : "Teniamo i corsi come prestabilito, alternando momenti di spiegazione a momenti di esercitazione per assicurarci che i concetti siano stati recepiti.",
        },
        {
            id : 'donazione',
            faName : 'fa-gift',
            title : 'Donazione',
            content : "Al termine di ogni corso il 20% del ricavato sarà donato dalla scuola.",
        }
    ];
    
    self.sizes = utilities.spacedSizes(self.tabs.length);
    
    self.spacedTabs = function($first){
        if(imOnResponsive) return "col-100";
        if($first) return "col-" + self.sizes.elementsWidth + " offset-" + self.sizes.outerWidth;
        else return "col-" + self.sizes.elementsWidth + " offset-" + self.sizes.spacerWidth;
    };
    
    self.getStyleTabs = function($first){
    	return self.spacedTabs($first);
    };
    
    
    
}]);