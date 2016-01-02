'use strict';
/**
 * for laravel-elixir Tasks
 */
var elixir = require('laravel-elixir'),
    gulp = require('gulp'),
    shell = require('gulp-shell');

var Task = elixir.Task;

elixir.extend('clearCompiled', function (src) {
  src = src || elixir.config.appPath + '/Providers/**/*.php';
  new Task('clearCompiled', function () {
    return gulp.src('')
        .pipe(shell('php artisan clear-compiled'))
        .pipe(new elixir.Notification('clear-compiled'));
  })
      .watch(src);
});

elixir(function (mix) {
  mix.clearCompiled()
      .browserSync()
      .copy('node_modules/bootstrap/dist/js/bootstrap.min.js', elixir.config.publicPath + '/js/bootstrap/')
      .copy('node_modules/bootstrap/fonts/**/*.*', elixir.config.publicPath + '/fonts/bootstrap/')
      .copy('node_modules/jquery/dist/jquery.min.js', elixir.config.publicPath + '/js/jquery/')
      .sass('app.scss')
      .sass('admin.scss')
      .sass('login.scss')
      .sass(
          'bootstrap.scss',
          elixir.config.publicPath + '/css/bootstrap.min.css'
      );
});
