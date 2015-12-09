module.exports = function(grunt) {
    // Do grunt-related things in here
    
    grunt.initConfig({
        ngtemplates:  {
            app: 
            {
                src: 'templates/**.php',
                dest: 'js/templates.js',
                options: {
                    module: 'Main',
                    htmlmin:  { collapseWhitespace: true, collapseBooleanAttributes: true }
                }
            }
        },
        
		sass: {                              // Task 
            dist: {                            // Target 
                options: {                       // Target options 
                    style: 'compressed',
                    trace: true,
                    precision: 10,
                },
                files: {                         // Dictionary of files 
                    'stylesheets/screen.css': 'sass/screen.scss',       // 'destination': 'source' 
                }
            }
        },
		
		jshint: {
            js_target: {
                src: ['js/*.js']
            }, //js_target
            options: { force: true }, //report JSHint errors but not fail the task
        }, //jshint
 
        compass: {
            dev: {
                options: {
                    config: 'config.rb'
                } //options
            } //dev
        }, //compass
 
        cssc: {
			build: {
			   options: {
				consolidateViaDeclarations: true,
				consolidateViaSelectors:    true,
				consolidateMediaQueries:    true
			  }
			} //build
		}, //cssc 
	 
		postcss: {
			options: {
				diff: true,
				processors: [
				  // require('autoprefixer')({browsers: ['last 1 version']}),
				  require('cssnano')() // minify the result
				]
			  },
			dist: {
			  src: 'stylesheets/screen.css',
			  dest: 'stylesheets/prefixed-screen.css'
			}
		},
		
		cssmin: {
			build: {
				src: 'stylesheets/screen.css',
				dest: 'stylesheets/screen.min.css'
			} //build
		}, //cssmin
		
		watch: {
            ngtemplates: {
              files: 'templates/**.php',
              tasks: ['ngtemplates'],
            },
			options: { livereload: true }, // reloads browser on save
            scripts: {
                files: ['js/*.js'],
                tasks: ['jshint', 'uglify']
            }, //scripts
            sass: {
                files: ['sass.scss'],
                tasks: ['compass:dev', 'postcss:build', 'cssc:build', 'cssmin:build']
            } //sass
        },
		
		pkg: grunt.file.readJSON('package.json'),
		
		uglify: {
		  options: {
			banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %>\n'
		  },
		  build: {
			src: 'js/*.js',
			dest: 'build/<%= pkg.name %>.min.js'
		  }
		},
		
		htmlSnapshot: {
            all: {
              options: {
                //that's the path where the snapshots should be placed 
                //it's empty by default which means they will go into the directory 
                //where your Gruntfile.js is placed 
                snapshotPath: 'snapshots/',
                //This should be either the base path to your index.html file 
                //or your base URL. Currently the task does not use it's own 
                //webserver. So if your site needs a webserver to be fully 
                //functional configure it here. 
                sitePath: 'http://localhost/',
                //you can choose a prefix for your snapshots 
                //by default it's 'snapshot_' 
                fileNamePrefix: 'sp_',
                //by default the task waits 500ms before fetching the html. 
                //this is to give the page enough time to to assemble itself. 
                //if your page needs more time, tweak here. 
                msWaitForPages: 1000,
                //sanitize function to be used for filenames. Converts '#!/' to '_' as default 
                //has a filename argument, must have a return that is a sanitized string 
                sanitize: function (requestUri) {
                    //returns 'index.html' if the url is '/', otherwise a prefix 
                    if (/\//.test(requestUri)) {
                      return 'index.html';
                    } else {
                      return requestUri.replace(/\//g, 'prefix-');
                    }
                },
                // allow to add a custom attribute to the body 
                bodyAttr: 'data-prerendered',
                //here goes the list of all urls that should be fetched 
                urls: [
                  '#!/profile/Titto'
                ]
              }
            }
        },
		
		svgcss: {
			build: {
			  files: {
				'stylesheets/my_icons.css': ['stylesheets/vectors/*.svg']
			  }
			}
		},
    });
    
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-angular-templates');
	grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-postcss');
    grunt.loadNpmTasks('grunt-cssc');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-html-snapshot');
	grunt.loadNpmTasks('grunt-svg-css');
	
    grunt.registerTask('default', ['ngtemplates']);
};