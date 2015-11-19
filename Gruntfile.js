module.exports = function(grunt) {
    // Do grunt-related things in here
    
    grunt.initConfig({
        ngtemplates:  {
            app: 
            {
                src: 'templates/**.php',
                dest: 'angular-modules/templates.js',
                options: {
                    module: 'Main',
                    htmlmin:  { collapseWhitespace: true, collapseBooleanAttributes: true }
                }
            }
        },
        // sass: {                              // Task 
        //     dist: {                            // Target 
        //         options: {                       // Target options 
        //             style: 'compressed',
        //             trace: true,
        //             precision: 10,
                    
        //         },
        //         files: {                         // Dictionary of files 
        //             'stylesheets/screen.css': 'sass/screen.scss',       // 'destination': 'source' 
        //         }
        //     }
        // },
        watch: {
            ngtemplates: {
              files: 'templates/**.php',
              tasks: ['ngtemplates'],
            }
        }
    });
    
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-angular-templates');
};