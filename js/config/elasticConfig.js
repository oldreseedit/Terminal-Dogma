/* Configures msd-elastic plugin for textareas */
main.config(['msdElasticConfig', function(config) {
  config.append = '\n';
}]).
/* Configures Google Maps SDK */
config(function(uiGmapGoogleMapApiProvider) {
    uiGmapGoogleMapApiProvider.configure({
        //    key: 'your api key',
        v: '3.20', //defaults to latest 3.X anyhow
        libraries: 'weather,geometry,visualization'
    });
})