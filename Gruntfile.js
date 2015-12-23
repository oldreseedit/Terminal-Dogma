module.exports = function(grunt) {

	grunt.initConfig({
    	
    	pkg: grunt.file.readJSON('package.json'),
		
    	ngtemplates:  {
            app: 
            {
                src: 'templates/*.php',
                dest: 'dist/js/templates.js',
                options: {
                    module: 'Main',
//                    htmlmin:  { collapseWhitespace: true, collapseBooleanAttributes: true }
                }
            }
        },
    	
    	concat: {
		  options: {
		    separator: ';'
		  },
		  dist: {
		    src: [ "js/ie10-viewport-bug-workaround.js",
		           "js/ui-bootstrap-tpls-0.14.3.min.js",
		           "js/elastic.js",
		           "js/utilities-service.js",
		           "js/main.js",
		           "js/server.js",
		           "js/modal.js",
		           "js/navbar.js",
		           "js/header.js",
		           "js/presentation.js",
		           "js/team.js",
		           "js/footer.js",
		           "js/courses.js",
		           "js/course.js",
		           "js/activities.js",
		           "js/activity.js",
		           "js/media.js",
		           "js/contacts.js",
		           "js/infoWindow.js",
		           "js/register.js",
		           "js/exp.js",
		           "js/admin.js",
		           "js/signin.js",
		           "js/signup.js",
		           "js/profile.js",
		           "js/avatar.js",
		           "js/paymentDisclaimer.js",
		           "js/paymentNotRegistered.js",
		           "js/paymentCancel.js",
		           "js/paymentConfirmation.js",
		           "js/payment.js",
		           "js/fitText.js",
		           "js/gridsterResizer.js",
		           "js/faq.js",
		           "js/privacy.js",
		           "js/disclaimer.js",
		           'dist/js/templates.js'],
		    dest: 'dist/js/<%= pkg.name %>.js'
		  }
		},
    	
		uglify: {
		  options: {
			banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n',
			mangle: false
		  },
		  build: {
			src: 'dist/js/<%= pkg.name %>.js',
			dest: 'dist/js/<%= pkg.name %>.min.js'
		  }
		},
		
        compass: {
            dev: {
                options: {
                	sassDir: 'sass/',
                	cssDir: 'dist/stylesheets/',
                	relativeAssets: true,
                	require: 'compass-import-once'
                }
            }
        },
        
//        purifycss: {
//	      target: {
//	        src: ['dist/**/*.js'], // Observe all html files
//	        css: ['dist/stylesheets/screen.css', 'stylesheets/awesome-bootstrap-checkbox.css', 'stylesheets/fontcustom.css'], // Take all css files into consideration
//	        dest: 'dist/stylesheets/reseed.clean.css' // Write to this path
//	      }
//	    },
        
	    cssmin: {
			target: {
				files: { // 'destination': 'source'
                  'dist/stylesheets/reseed.min.css': ['dist/stylesheets/screen.css', 'stylesheets/awesome-bootstrap-checkbox.css', 'stylesheets/fontcustom.css'],
              }
			}
		},
	    
//        cssmin: {
//			target: {
//				files: { // 'destination': 'source'
//                  'dist/stylesheets/screen.min.css': 'dist/stylesheets/screen.css',
//                  'dist/stylesheets/print.min.css': 'dist/stylesheets/print.css',
//                  'dist/stylesheets/ie.min.css': 'dist/stylesheets/ie.css',
//              }
//			}
//		},
		
		copy: {
			website: {
			    files: [
			      // includes files within path and its sub-directories 
			      {expand: true, src: ['application/**'], dest: 'dist/'},
			      {expand: true, src: ['imgs/**'], dest: 'dist/'},
			      {expand: true, src: ['system/**'], dest: 'dist/'},
			      {expand: true, src: ['.htaccess'], dest: 'dist/'},
			      {expand: true, src: ['index.php'], dest: 'dist/'},
			      {expand: true, src: ['php.ini'], dest: 'dist/'},
			      {expand: true, src: ['bower_components/**'], dest: 'dist/'},
			      {src: ['stylesheets/fontcustom_*'], dest: 'dist/'},
			    ],
			  },
		},
		
		clean: {
			all: {
				src: ["dist/"]
			},
			build: {
				src: [
				      "dist/js/templates.js",
				      "dist/js/reseed.js",
				      "dist/stylesheets/screen.css",
				      "dist/stylesheets/print.css",
				      "dist/stylesheets/ie.css",
				      ]
			}
		},
		
		htmlSnapshot: {
            all: {
              options: {
                //that's the path where the snapshots should be placed 
                //it's empty by default which means they will go into the directory 
                //where your Gruntfile.js is placed 
                snapshotPath: 'dist/snapshots/',
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
                	if(/#!/.test(requestUri))
                	{
                		requestUri = requestUri.substr(2);
                	}
                	if(/\/$/.test(requestUri))
                	{
                		requestUri = requestUri.substr(0, requestUri.length -1);
                	}
                	return requestUri;
                    //returns 'index.html' if the url is '/', otherwise a prefix 
//                    if (/\//.test(requestUri)) {
//                      return "index";
//                    } else {
//                      return requestUri.replace(/\//g, 'prefix-');
//                    }
                },
                // allow to add a custom attribute to the body 
                bodyAttr: 'data-prerendered',
                //here goes the list of all urls that should be fetched 
                urls: [
                  '#!/courses/',
                  '#!/course/gameDesign'
                ]
              }
            }
        },
        
//        bower_concat: {
//    	  all: {
//    	    dest: 'dist/js/bower.js',
//    	    cssDest: 'dist/stylesheets/bower.css',
//    	  }
//    	},
        
    	wiredep: {
        	 
        	  task: {
        	    src: [
        	      'dist/application/views/basics/head.php',
        	    ],
        	    options: {
	        	    dependencies: true,
	        	    devDependencies: true,
        	    },
        	    exclude: [ 'bower_components/angular/', 'bower_components/jquery/' ],
        	  }
    	},
    	
//    	injector: {
//    	    options: {
//    	    },
//    	    local_dependencies: {
//    	    	files:
//    	    		{
//    	    			src: ['js/reseed.min.js', 'stylesheets/reseed.min.css'],
//    	    			dest: 'dist/application/views/basics/head.php'
//    	    		}
//    	    },
//    	  },
    	
//		uncss: {
//			  dist: {
//			    files: {
//			      'dist/stylesheets/reseed.clean.css': ['dist/**']
//			    }
//			  }
//			}
		
//		sass: {                              // Task 
//            dist: {                            // Target 
//                options: {                       // Target options 
//                    style: 'compressed',
//                    trace: true,
//                    precision: 10,
//                    relativeAssets: true
//                },
//                files: {                         // Dictionary of files 
//                    'dist/stylesheets/screen.css': 'sass/screen.scss',       // 'destination': 'source' 
//                }
//            }
//        },
		
//		jshint: {
//            js_target: {
//                src: ['js/*.js']
//            }, //js_target
//            options: { force: true }, //report JSHint errors but not fail the task
//        }, //jshint
 
//        cssc: {
//			build: {
//			   options: {
//				consolidateViaDeclarations: true,
//				consolidateViaSelectors:    true,
//				consolidateMediaQueries:    true
//			  }
//			} //build
//		}, //cssc 
	 
//		postcss: {
//			options: {
//				diff: true,
//				processors: [
//				  // require('autoprefixer')({browsers: ['last 1 version']}),
//				  require('cssnano')() // minify the result
//				]
//			  },
//			dist: {
//			  src: 'stylesheets/screen.css',
//			  dest: 'stylesheets/prefixed-screen.css'
//			}
//		},
//		
//		watch: {
//            ngtemplates: {
//              files: 'templates/**.php',
//              tasks: ['ngtemplates'],
//            },
//			options: { livereload: true }, // reloads browser on save
//            scripts: {
//                files: ['js/*.js'],
//                tasks: ['jshint', 'uglify']
//            }, //scripts
//            sass: {
//                files: ['sass.scss'],
//                tasks: ['compass:dev', 'postcss:build', 'cssc:build', 'cssmin:build']
//            } //sass
//        },
//		
//		svgcss: {
//			build: {
//			  files: {
//				'stylesheets/my_icons.css': ['stylesheets/vectors/*.svg']
//			  }
//			}
//		},
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-angular-templates');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-clean');
//    grunt.loadNpmTasks('grunt-purifycss');
    grunt.loadNpmTasks('grunt-html-snapshot');
    grunt.loadNpmTasks('grunt-bower-concat');
    grunt.loadNpmTasks('grunt-wiredep');
    grunt.loadNpmTasks('grunt-injector');
    
//		grunt.loadNpmTasks('grunt-bower-install');
//		grunt.loadNpmTasks('grunt-contrib-sass');
//		grunt.loadNpmTasks('grunt-contrib-watch');
//		grunt.loadNpmTasks('grunt-postcss');
//		grunt.loadNpmTasks('grunt-svg-css');
//		grunt.loadNpmTasks('grunt-contrib-jshint');
//		grunt.loadNpmTasks('grunt-cssc');

//		grunt.registerTask('default', ['ngtemplates', 'concat', 'uglify', 'compass', 'cssmin', 'copy', 'clean', 'bower_concat', 'wiredep']);
//    grunt.registerTask('default', ['ngtemplates', 'concat', 'compass', 'cssmin', 'copy', 'clean', 'bower_concat', 'wiredep']);
    grunt.registerTask('default', ['clean:all', 'ngtemplates', 'concat', 'uglify', 'compass', 'cssmin', 'copy', 'clean:build', 'wiredep', 'injector']);
//    grunt.registerTask('default', ['tags']);
};