/*!
 * gulp
 * $ npm install gulp-ruby-sass gulp-autoprefixer gulp-minify-css gulp-jshint gulp-concat gulp-uglify gulp-imagemin gulp-notify gulp-rename gulp-livereload gulp-cache del --save-dev
 */

// Load plugins
var gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    inline = require('gulp-inline'),
    imagemin = require('gulp-imagemin'),
    svg2png = require('gulp-svg2png'),
    // svgmin = require('gulp-svgmin'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    livereload = require('gulp-livereload'),
    phplint = require('phplint').lint,
    del = require('del');

// Fonts
gulp.task('fonts', function() {
  return gulp.src('src/fonts/**/*')
    .pipe(gulp.dest('dist/fonts'));
    // .pipe(notify({ message: 'Fonts task complete' }));
});

// Styles
gulp.task('styles', ['critical'], function() {
  return gulp.src('src/scss/style.scss')
    .pipe(sass({ style: 'expanded', }))
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(minifycss())
    .pipe(gulp.dest(''))
    .pipe(notify({ message: 'Styles task complete' }));
});

// Scripts
gulp.task('scripts', function() {
  return gulp.src('src/js/**/*.js')
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('default'))
    .pipe(concat('main.js'))
    .pipe(gulp.dest('dist/js'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(uglify())
    .pipe(gulp.dest('dist/js'))
    .pipe(notify({ message: 'Scripts task complete' }));
});

// SVGs to PNGs
gulp.task('svg2png', function () {
  return gulp.src('src/img/**/*.svg')
    .pipe(svg2png())
    .pipe(gulp.dest('dist/img'));
});

// Minify SVGs
// gulp.task('svgmin', function () {
//   return gulp.src('dist/img/**/*.svg')
//     .pipe(svgmin())
//     .pipe(gulp.dest('dist/img'));
// });

gulp.task('phplint', function(cb) {
  phplint(['**/*.php'], {limit: 10}, function (err, stdout, stderr) {
    if (err) {
      cb(err);
      process.exit(1);
    }
    console.log('passed err');
    cb();
  });
});

// doesn't work
// gulp.task('test', ['phplint']);

// Images
gulp.task('images', function() {
  return gulp.src('src/img/**/*')
    .pipe(cache(imagemin({ optimizationLevel: 7, progressive: true, interlaced: true, svgoPlugins: [{removeViewBox: false}] })))
    .pipe(gulp.dest('dist/img')); // Bug in path: https://github.com/imagemin/imagemin/issues/60
    // .pipe(notify({ message: 'Images task complete' }));
});

// Clean
gulp.task('clean', function(cb) {
    // del(['', 'dist/assets/js', 'dist/assets/img'], cb)
});

// Default task
gulp.task('default', function() {
    gulp.start('styles', 'scripts', 'images', 'svg2png');
});

// Watch
gulp.task('watch', ['default'], function() {

  // Watch .scss files
  gulp.watch('src/scss/**/*.scss', ['styles']);

  // Watch .js files
  gulp.watch('src/js/**/*.js', ['scripts']);

  // Watch image files
  gulp.watch('src/img/**/*', ['images']);

  // Watch php
  gulp.watch('**/*.php', ['phplint']);

  // Create LiveReload server
  livereload.listen();

  // Watch any files in dist/, reload on change
  gulp.watch(['style.css', '**/*.php']).on('change', livereload.changed);

});
gulp.task('critical', function() {
  var request = require('request');
  var path = require( 'path' );
  var criticalcss = require("criticalcss");
  var fs = require('fs');
  var tmpDir = require('os').tmpdir();

  var cssUrl = 'http://hoverboardstudios.vvv/wp-content/themes/hoverboard/style.css';
  var cssPath = path.join( tmpDir, 'style.css' );
  var includePath = path.join( __dirname, 'inc/critical.css.php' );
  request(cssUrl).pipe(fs.createWriteStream(cssPath)).on('close', function() {
    criticalcss.getRules(cssPath, function(err, output) {
      if (err) {
        throw new Error(err);
      } else {
        criticalcss.findCritical("http://hoverboardstudios.vvv/", { rules: JSON.parse(output) }, function(err, output) {
          if (err) {
            throw new Error(err);
          } else {

            fs.writeFile(includePath, output, function(err) {
              if(err) {
                return console.log(err);
              }
              console.log("Critical written to include!");
            });

          }
        });
      }
    });
  });

});
