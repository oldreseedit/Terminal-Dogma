main.config(function($provide){
    $provide.decorator('taOptions', ['taRegisterTool', '$delegate', function(taRegisterTool, taOptions){
        // $delegate is the taOptions we are decorating
        // register the tool with textAngular
        taRegisterTool('colourRed', {
            iconclass: "fa fa-square pond",
            action: function(){
                // this.$editor().wrapSelection('forecolor', 'red');
            	this.$editor().wrapSelection('insertHTML', '<span class="pond">'+document.getSelection()+'</span>');
            }
        });
        // add the button to the default toolbar definition
        taOptions.toolbar[1].push('colourRed');
        return taOptions;
    }]);
});