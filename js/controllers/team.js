main.controller('teamController',["utilities",function(utilities){
    var self = this;
    
    self.people = [
        {
            id : 'lorenzo',
            name : 'Lorenzo',
            urlImg : 'imgs/team/Lorenzo.jpg',
            socialNetworks : [
                {
                    id: 'facebook',
                    faName: 'fa-facebook',
                    url : 'https://www.facebook.com/lorenzo.bellincampi',
                    responsiveHide : false
                },
                {
                    id: 'twitter',
                    faName: 'fa-twitter',
                    url : 'https://twitter.com/PixelSapiens',
                    responsiveHide : false
                },
                {
                    id: 'google-plus',
                    faName: 'fa-google-plus',
                    url : 'https://plus.google.com/u/0/111505057979464274942/',
                    responsiveHide : true
                },
                {
                    id: 'linkedin',
                    faName: 'fa-linkedin',
                    url : 'https://www.linkedin.com/pub/lorenzo-bellincampi/21/814/117',
                    responsiveHide : true
                },
                {
                    id: 'mail',
                    faName: 'fa-envelope-o',
                    url : 'mailto:lbellincampi@reseed.it',
                    responsiveHide : false
                },
            ]
        },
        {
            id : 'alessandro',
            name : 'Alessandro',
            urlImg : 'imgs/team/Alessandro.jpg',
            socialNetworks : [
                {
                    id: 'facebook',
                    faName: 'fa-facebook',
                    url : 'https://www.facebook.com/FerlFlanty',
                    responsiveHide : false
                },
                {
                    id: 'twitter',
                    faName: 'fa-twitter',
                    url : 'https://twitter.com/AlessandroFlati',
                    responsiveHide : false
                },
                {
                    id: 'google-plus',
                    faName: 'fa-google-plus',
                    url : 'https://plus.google.com/u/0/+AlessandroFlati',
                    responsiveHide : true
                },
                {
                    id: 'linkedin',
                    faName: 'fa-linkedin',
                    url : 'https://it.linkedin.com/pub/alessandro-flati/ba/9b1/b50',
                    responsiveHide : true
                },
                {
                    id: 'mail',
                    faName: 'fa-envelope-o',
                    url : 'mailto:aflati@reseed.it',
                    responsiveHide : false
                },
            ]
        },
        {
            id : 'tiziano',
            name : 'Tiziano',
            urlImg : 'imgs/team/Tiziano.jpg',
            socialNetworks : [
                {
                    id: 'facebook',
                    faName: 'fa-facebook',
                    url : 'https://www.facebook.com/tiziano.flati?fref=ts',
                    responsiveHide : false
                },
                {
                    id: 'twitter',
                    faName: 'fa-twitter',
                    url : 'https://twitter.com/tiziano_flati',
                    responsiveHide : false
                },
                {
                    id: 'google-plus',
                    faName: 'fa-google-plus',
                    url : 'https://plus.google.com/111238241897956505214',
                    responsiveHide : true
                },
                {
                    id: 'linkedin',
                    faName: 'fa-linkedin',
                    url : 'https://it.linkedin.com/pub/tiziano-flati/ab/81/783',
                    responsiveHide : true
                },
                {
                    id: 'mail',
                    faName: 'fa-envelope-o',
                    url : 'mailto:tflati@reseed.it',
                    responsiveHide : false
                },
            ]
        }
    ];
    
    self.sizesIcons = utilities.spacedSizes(self.people[0].socialNetworks.length);
    self.sizesPeople =imOnResponsive ? utilities.spacedSizes(1) : utilities.spacedSizes(self.people.length);
    
    self.spacedIcons = function($first){
        if($first) return ["col-" + self.sizesIcons.elementsWidth, "offset-" + self.sizesIcons.outerWidth];
        else return ["col-" + self.sizesIcons.elementsWidth, "offset-" + self.sizesIcons.spacerWidth];
    };
    
    self.spacedPeople = function($first){
        if($first) return "col-" + self.sizesPeople.elementsWidth + " offset-" + self.sizesPeople.outerWidth;
        else return "col-" + self.sizesPeople.elementsWidth + " offset-" + self.sizesPeople.spacerWidth;
    };
    
    self.getColors = function(icon,hover){
        var style = {
            'white': hover,
            'slightly-darker-grey' : !hover
        };
        return style;
    };
    
    self.getColorsInverse = function(icon,hover){
        var style = {'white': !hover};
        style[icon.id] = hover;
        return [icon.faName,style];
    };
    
    self.getTeacherInfo = function(teacherName){
    	for(var i=0; i<self.people.length; i++)
    		if(self.people[i].name === teacherName)
    			return self.people[i];
    	
    	return null;
    }
    
}]);