module.exports = function(grunt) {

	grunt.initConfig({
    	
    	pkg: grunt.file.readJSON('package.json'),
		
    	webfont: {
    		icons: {
    			src: 'stylesheets/vectors/*.svg',
    			dest: 'stylesheets/',
    			options: {
    				fontFilename: 'icon-{hash}',
    				font: 'fontcustom',
    				syntax: 'bootstrap'
    			}
    		}
    	},
    	
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
        
        bower_concat: {
    	  all: {
    	    dest: 'dist/js/bower.js',
    	    cssDest: 'dist/stylesheets/bower.css',
    	    includeDev: true,
    	    exclude: ['angular', 'font-awesome', 'jquery'],
			mainFiles: {
				'fullcalendar': ['dist/fullcalendar.js', 'dist/lang/it.js', 'dist/gcal.js', 'dist/fullcalendar.css']
			},
    	  }
    	},
    	
    	concat: {
		  javascript: {
			  src : [
			          'dist/js/bower.js',
			          'js/controllers/ui-bootstrap-tpls-0.14.3.min.js',
			          'js/controllers/ie10-viewport-bug-workaround.js',
			          'js/directives/fitText.js',
			          'js/directives/elastic.js',
	                  'js/main.js',
	                  'js/filters/*.js',
	                  'js/factories/*.js',
	                  'js/config/*.js',
	                  'js/directives/*.js',
	                  'js/controllers/*.js',
	                  'dist/js/templates.js'],
	          dest: 'dist/js/<%= pkg.name %>.js'
		  },
		  css: {
			  src : [
			        'dist/stylesheets/bower.css',
					'dist/stylesheets/screen.css',
					'stylesheets/fontcustom.css',
					'stylesheets/awesome-bootstrap-checkbox.css',
					],
	          dest: 'dist/stylesheets/reseed.css'
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
        
        autoprefixer: {
        	options: {
        		browsers: ['last 10 versions', 'ie 8', 'ie 9'],
//        		diff: true
        	},
            build: {
            	src: 'dist/stylesheets/reseed.css',
            	dest: 'dist/stylesheets/reseed.autoprefixed.css'
            },
        },
        
	    cssmin: {
			target: {
				files: { // 'destination': 'source'
                  'dist/stylesheets/reseed.min.css': ['dist/stylesheets/reseed.autoprefixed.css'],
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
//			      {expand: true, src: ['bower_components/**'], dest: 'dist/'},
			      {src: ['stylesheets/icon-*'], dest: 'dist/'},
			    ],
			  },
		},
		
		clean: {
			all: {
				src: ["dist/js/", "dist/stylesheets/"]
			},
			build: {
				src: [
				      "dist/js/templates.js",
				      "dist/js/reseed.js",
				      "dist/js/bower.js",
				      "dist/stylesheets/bower.css",
				      "dist/stylesheets/screen.css",
				      "dist/stylesheets/print.css",
				      "dist/stylesheets/ie.css",
				      "dist/stylesheets/reseed.css",
				      "dist/stylesheets/*autoprefixed.css",
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
                sitePath: 'http://localhost/dist/',
                //you can choose a prefix for your snapshots 
                //by default it's 'snapshot_' 
                 fileNamePrefix: '',
                //by default the task waits 500ms before fetching the html. 
                //this is to give the page enough time to to assemble itself. 
                //if your page needs more time, tweak here. 
                msWaitForPages: 5000,
                //sanitize function to be used for filenames. Converts '/' to '_' as default 
                //has a filename argument, must have a return that is a sanitized string 
                sanitize: function (requestUri) {
//                	if(/\//.test(requestUri))
//                	{
//                		requestUri = requestUri.substr(1);
//                	}
//                	if(/\/$/.test(requestUri))
//                	{
//                		requestUri = requestUri.substr(0, requestUri.length -1);
//                	}
                	
                	requestUri = requestUri.replace(/\//g, "");
                	//if(requestUri === "") requestUri = "home";
                	
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
                  '/courses',
                  '/contacts',
                  '/faq',
                  '/privacy',
                  '/disclaimer',
                  '/courses/java',
                  '/courses/mobileApp',
                  '/courses/HCJS',
                  '/courses/MVCDevelopment',
                  '/courses/gameDesign',
                  '/courses/gameMaker',
                  '/courses/gamesForDummies',
                  '/courses/3DStudioMax',
                ]
              }
            }
        },
        
    	wiredep: {
        	 
        	  task: {
        	    src: [
        	      'dist/application/views/basics/head.php',
        	    ],
        	    options: {
        	    	ignorePath: '../../../../',
	        	    dependencies: true,
	        	    devDependencies: true,
        	    },
        	    exclude: [ 'bower_components/angular/', 'bower_components/jquery/' ],
        	  }
    	},
    	
    	filerev: {
		    options: {
		      algorithm: 'md5',
		      length: 8
		    },
		    images: {
		      src: ['dist/stylesheets/reseed.min.css', 'dist/js/reseed.min.js']
		    }
    	},
		  
		injector: {
			    options: {
			    	addRootSlash: false,
			    	ignorePath: "dist/"
			    },
			    local_dependencies: {
			    	files:
			    		{
			    			'dist/application/views/basics/head.php': ['dist/js/reseed.min.*.js', 'dist/stylesheets/reseed.min.*.css']
		    		}
		    },
		},
		
		'ftp-deploy': {
			  build: {
			    auth: {
			      host: 'reseed.it',
			      port: 21,
			      authKey: 'reseedKey'
			    },
			    src: 'dist/',
			    dest: 'public_html/reseed/',
//			    exclusions: ['path/to/source/folder/**/.DS_Store', 'path/to/source/folder/**/Thumbs.db', 'path/to/dist/tmp']
			  }
			}
		
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
    grunt.loadNpmTasks('grunt-html-snapshot');
    grunt.loadNpmTasks('grunt-bower-concat');
    grunt.loadNpmTasks('grunt-wiredep');
    grunt.loadNpmTasks('grunt-injector');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-filerev');
    grunt.loadNpmTasks('grunt-ftp-deploy');
    grunt.loadNpmTasks('grunt-webfont');

    grunt.registerTask('default', ['clean:all', 'webfont', 'ngtemplates', 'bower_concat', 'concat:javascript', 'uglify', 'compass', 'concat:css', 'autoprefixer', 'cssmin', 'copy', 'clean:build', 'filerev', 'injector']);
};