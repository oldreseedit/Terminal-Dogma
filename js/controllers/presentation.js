main.controller('presentationController',["utilities",function(utilities){
    var self = this;
    
    self.tabs = [
        {
            id : 'apprendimento',
            faName : 'fa-user',
            title : 'Apprendimento',
            content : "Gli studenti seguono corsi innovativi tenuti da docenti che usano quotidianamente i concetti insegnati.",
            color : 'olive',
            url : '/courses'
        },
        {
            id : 'simulazione',
            faName : 'fa-cog',
            title : 'Simulazione',
            content : "Tramite una rigorosa simulazione di On-The-Job Training gli studenti vengono immersi in un realistico ambiente di lavoro con lo scopo di sviluppare un prodotto.",
            color : 'green',
            url : '/courses'
        },
        {
            id : 'pubblicazione',
            faName : 'fa-globe',
            title : 'Pubblicazione',
            content : "Il prodotto realizzato durante la simulazione viene reso disponibile al pubblico (web, Play Store, App Store, etc.).",
            color : 'water',
            url : '/courses'
        }
    ];
    
    self.sizes = utilities.spacedSizes(self.tabs.length);
    
    self.spacedTabs = function($first){
        if(imOnResponsive) return "col-100";
        if($first) return "col-" + self.sizes.elementsWidth + " offset-" + self.sizes.outerWidth;
        else return "col-" + self.sizes.elementsWidth + " offset-" + self.sizes.spacerWidth;
    };
    
    self.getStyleTabs = function($first, el){
        return 'bg-light-' + el.color + ' ' + self.spacedTabs($first);
    };
    
    self.getColour = function(index)
    {
    	return 'bg-light-' + self.tabs[index%3].color;
    };
    
    self.getDarkColour = function(index)
    {
    	return 'bg-' + self.tabs[index%3].color;
    };
    
    /* NEWS */
    
    
    
    
}]);