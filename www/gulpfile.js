/*!
 * gulp
 * $ npm install gulp-ruby-sass gulp-autoprefixer gulp-minify-css gulp-jshint gulp-concat gulp-uglify gulp-imagemin gulp-notify gulp-rename gulp-livereload gulp-cache del --save-dev
 */

// Load plugins
var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    svg2png = require('gulp-svg2png'),
    svgmin = require('gulp-svgmin'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    livereload = require('gulp-livereload'),
    del = require('del');

// Fonts
gulp.task('fonts', function() {
  return gulp.src('src/fonts/**/*')
    .pipe(gulp.dest('dist/fonts'))
    .pipe(notify({ message: 'Fonts task complete' }));
});

// Styles
gulp.task('styles', function() {
  return gulp.src('src/scss/style.scss')
    .pipe(sass({ style: 'expanded', }))
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(gulp.dest('dist/css'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(minifycss())
    .pipe(gulp.dest('dist/css'))
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
gulp.task('svgmin', function () {
  return gulp.src('dist/img/**/*.svg')
    .pipe(svgmin())
    .pipe(gulp.dest('dist/img'));
});

// Images
gulp.task('images', function() {
  return gulp.src('src/img/**/*')
    .pipe(cache(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true })))
    .pipe(gulp.dest('dist/img')) // Bug in path: https://github.com/imagemin/imagemin/issues/60
    .pipe(notify({ message: 'Images task complete' }));
});

// Clean
gulp.task('clean', function(cb) {
    del(['dist/assets/css', 'dist/assets/js', 'dist/assets/img'], cb)
});

// Default task
gulp.task('default', ['clean'], function() {
    gulp.start('fonts', 'styles', 'scripts', 'images', 'svg2png', 'svgmin');
});

// Watch
gulp.task('watch', function() {

  // Run all tasks first, then watch
  gulp.start('fonts', 'styles', 'scripts', 'images', 'svg2png', 'svgmin');

  // Watch .scss files
  gulp.watch('src/scss/**/*.scss', ['styles']);

  // Watch .js files
  gulp.watch('src/js/**/*.js', ['scripts']);

  // Watch image files
  gulp.watch('src/img/**/*', ['images']);

  // Create LiveReload server
  livereload.listen();

  // // Watch any files in dist/, reload on change
  gulp.watch(['dist/**']).on('change', livereload.changed);

});