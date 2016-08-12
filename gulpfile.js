'use strict';

var gulp = require('gulp'),
    cache = require('gulp-cached'),
    beep = require('beepbeep'),
    plumber = require('gulp-plumber'),
    phpcs = require('gulp-phpcs');

var files = [
  'init.php',
  'src/**/*.php'
];

/**
 * Error handling
 */
var gulp_src = gulp.src;

gulp.src = function() {
  return gulp_src.apply(gulp, arguments)

  .pipe(plumber(function(error) {
    beep();
  }));
};

/**
 * Tasks
 */
gulp.task('phpcs', function() {
  return gulp.src(files)
  .pipe(cache('phpcs'))

  .pipe(phpcs({
    bin: './vendor/bin/phpcs',
    standard: 'PSR2',
    warningSeverity: 0
  }))

  .pipe(phpcs.reporter('log'))
  .pipe(phpcs.reporter('fail'));
});

gulp.task('default', function() {
  gulp.watch(files, ['phpcs']);
});
