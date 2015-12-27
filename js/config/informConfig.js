/* Configures Angular Inform */
main.config(function(informProvider) {

    var myDefaults = {
      /* default time to live for each notification */
      ttl: 4000,
      /* default type of notification */
      type: 'success'
    };

    informProvider.defaults(myDefaults);
});