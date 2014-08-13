module.exports = function(grunt) {

  // 1. All configuration goes here
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // concat: {
    //   dist: {
    //     src: [
    //       'js/libs/*.js', // All JS in the libs folder
    //       'js/src/*.js'  // This specific file
    //     ],
    //     dest: 'js/main.js',
    //   }
    // },
    // jshint: {
    //   beforeconcat: ['js/src/*.js'],
    //   afterconcat: ['js/main.js'],
    //   options: {
    //     globals: {
    //       jQuery: true,
    //       console: true
    //     }
    //   }
    // },
    // uglify: {
    //   build: {
    //     src: 'js/main.js',
    //     dest: 'js/main.min.js'
    //   }
    // },
    // favicons: {
    //   options: {
    //     trueColor: true,
    //     precomposed: true,
    //     appleTouchBackgroundColor: "#ffebbc",
    //     coast: true,
    //     windowsTile: true,
    //     tileBlackWhite: false,
    //     tileColor: "#ffebbc",
    //     //This plugin is spotty with creating the html (inc/favicons.php), so, back up the old version first before you run it.
    //     // html: 'inc/favicons.php',
    //     // HTMLPrefix: '/wp-content/themes/supcamp_40/img/favicons/'
    //   },
    //   icons: {
    //     src: 'img/favicon-src.png',
    //     dest: 'img/favicons'
    //   }
    // },
    imagemin: {
      dynamic: {
        files: [{
          expand: true,
          cwd: 'img/',
          src: ['*.{png,jpg,gif}'],
          dest: 'img/'
        }]
      }
    },
    svgmin: {
      options: {
        plugins: [{
          removeViewBox: false
        }]
      },
      dist: {
        files: [{                // Dictionary of files
          expand: true,        // Enable dynamic expansion.
          cwd: 'img',        // Src matches are relative to this path.
          src: ['**/*.svg'],    // Actual pattern(s) to match.
          dest: 'img/',        // Destination path prefix.
          ext: '.svg'        // Dest filepaths will have this extension.
          // ie: optimise img/src/branding/logo.svg and store it in img/branding/logo.min.svg
        }]
      }
    },
    svg2png: {
      all: {
        // specify files in array format with multiple src-dest mapping
        files: [
          // rasterize all SVG files in "img" and its subdirectories to "img/png"
          { src: ['img/**/*.svg'], dest: '' },
        ]
      }
    },
    watch: {
      options: {
        livereload: true
      },
      // scripts: {
      //   files: ['js/*.js', 'js/src/*.js'],
      //   tasks: ['concat', 'uglify'],
      //   options: {
      //     spawn: false,
      //   },
      // },
      css: {
        files: ['scss/**/*.scss'],
        tasks: ['compass:dev'],
        options: {
          spawn: false,
        }
      }
    },
    compass: {
      dev: {
        options: {
          sassDir: 'scss',
          cssDir: 'css',
          outputStyle: 'nested',
          require: [
            'breakpoint',
            'singularitygs'
          ]
        }
      },
      prod: {
        options: {
          sassDir: 'scss',
          cssDir: '',
          outputStyle: 'compressed',
          require: [
            'breakpoint',
            'singularitygs'
          ]
        }
      }
    }

  });

  // 3. Where we tell Grunt we plan to use this plug-in.
  // grunt.loadNpmTasks('grunt-contrib-concat');
  // grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-imagemin');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  // grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-svgmin');
  grunt.loadNpmTasks('grunt-autoprefixer');
  // grunt.loadNpmTasks('grunt-favicons');
  grunt.loadNpmTasks('grunt-svg2png');

  // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
  grunt.registerTask('prod', ['compass:prod', 'concat', 'uglify', 'imagemin', 'svgmin']);
  // grunt.registerTask('favicon', ['favicons']);
  grunt.registerTask('default', ['imagemin', 'svgmin', 'svg2png', 'watch']);


};
