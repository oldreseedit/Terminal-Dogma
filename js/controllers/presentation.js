main.controller('presentationController',["utilities",function(utilities){
    var self = this;
    
    self.tabs = [
        {
            id : 'apprendimento',
            faName : 'fa-user',
            title : 'Disponibili',
            content : "Siamo ragazzi come voi. Aggiungeteci su Facebook per informazioni e consigli prima, dopo e durante il corso!",
            url : '/courses'
        },
        {
            id : 'simulazione',
            faName : 'fa-cog',
            title : 'Pratici',
            content : "Vogliamo insegnarvi quello che sappiamo fare in maniera pratica.",
            url : '/courses'
        },
        {
            id : 'pubblicazione',
            faName : 'fa-globe',
            title : 'Accessibili',
            content : "I nostri corsi sono economici e leggeri: possono essere seguiti da chiunque e accostati alla scuola, all’università o al lavoro.",
            url : '/courses'
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