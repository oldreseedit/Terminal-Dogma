main.config(function($provide){
    $provide.decorator('taOptions', ['taRegisterTool', '$delegate', function(taRegisterTool, taOptions){
        // $delegate is the taOptions we are decorating
        // register the tool with textAngular
        taRegisterTool('codeTool', {
            iconclass: "fa fa-code",
            buttontext: "Aggiungi codice",
            action: function(){
            	language = "javascript";
            	console.log(document.getSelection());
            	this.$editor().wrapSelection('insertHTML', '<pre class="line-numbers"><code class="language-'+language+'">'+ (document.getSelection()+"").replace("<br>","") +'</code></pre>');
            }
        });
        
//        taOptions.keyMappings.push({
//        		commandKeyCode: 'SaveCommand', 
//        	    testForKey: function (event) {
//        	        if ((event.which==83 || event.keyCode==83) && event.ctrlKey && !event.shiftKey && !event.altKey)
//        	        {
//        	        	event.preventDefault();
//        	        	console.log(event);
//        	        	return true;
//        	        }
//        	    }
//        	});
//        
//        taRegisterTool('SaveCommand', {
//        	iconclass: "fa fa-floppy-o",
//        	action: function(){
//        		console.log(this);
//        	},
//        	buttontext: 'Salva',
//        	commandKeyCode: 'SaveCommand'
//        });
        
        // add the button to the default toolbar definition
        taOptions.toolbar[1].push('codeTool');
        return taOptions;
    }]);
});