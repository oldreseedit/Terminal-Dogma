main.controller('footerController',["utilities",function(utilities){
    var self = this;
    
    self.icons = [
        {
            id : 'facebook',
            faName : 'fa-facebook',
            url: 'https://www.facebook.com/reSeedEducation'
        },
        {
            id : 'twitter',
            faName : 'fa-twitter',
            url : 'https://twitter.com/reseededucation'
        },
        {
            id : 'google-plus',
            faName : 'fa-google-plus',
            url : 'https://plus.google.com/114067532078446624336/'
        },
        {
            id : 'youtube',
            faName : 'fa-youtube-play',
            url : 'https://www.youtube.com/channel/UC0nx_udQqFpK0uHGTfU4RmQ/feed'
        },
        {
            id : 'mail',
            faName : 'fa-envelope-o',
            url : 'mailto: info@reseed.it'
        }
    ];
    
    self.tabs = [
        {
            id : 'faq',
            content : 'DOMANDE FREQUENTI'
        },
        {
            id : 'privacy',
            content : 'PRIVACY POLICY'
        },
        {
            id : 'disclaimer',
            content : 'TERMINI D\'USO'
        }
    ];
    
    self.sizes = utilities.spacedSizes(self.tabs.length);
    self.sizesIcons = utilities.spacedSizes(self.icons.length);
    
    self.spaced = function($first){
        if($first) return ["col-" + self.sizes.elementsWidth, "offset-" + self.sizes.outerWidth];
        else return ["col-" + self.sizes.elementsWidth, "offset-" + self.sizes.spacerWidth];
    };
    
    self.spacedIcons = function($first){
        if($first) return ["col-" + self.sizesIcons.elementsWidth, "offset-" + self.sizesIcons.outerWidth, imOnResponsive ? "fa-lg" : "fa-2x"];
        else return ["col-" + self.sizesIcons.elementsWidth, "offset-" + self.sizesIcons.spacerWidth, imOnResponsive ? "fa-lg" : "fa-2x"];
    };
    
    self.getColors = function(icon,hover){
        var style = {'white': hover};
        style[icon.id] = !hover;
        return style;
    };
    
    self.getColorsInverse = function(icon,hover){
        var style = {'white': !hover};
        style[icon.id] = hover;
        return [icon.faName,style];
    };
    
}]);