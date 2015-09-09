var elixir = require('laravel-elixir');
var livereload = require('gulp-livereload');
var rimraf = require('rimraf');
var gulp = require('gulp');
var ngConstant = require('gulp-ng-constant');
var fs = require('fs');

var paths = {
    'public': 'public',
    'public_js': 'public/js',
    'public_css': 'public/css',
    'build': './public/build',
    'build_js': './public/build/js',
    'build_css': './public/build/css',
    'build_map': './public/build/map',
    'build_html': './public/build/views',
    'build_vendor': './public/build/vendor',
    'assets': './resources/assets',
    'bower': './bower_components',
};

paths.vendor_css = [
    paths.bower + '/bootstrap/dist/css/bootstrap.min.css',
    paths.bower + '/jasny-bootstrap/dist/css/jasny-bootstrap.min.css',
    paths.bower + '/sweetalert/dist/sweetalert.css',
    paths.bower + '/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css',
    paths.bower + '/nouislider/distribute/nouislider.min.css',
    paths.assets + '/css/animate.css',
    paths.assets + '/css/styles.css'
];

paths.vendor_js = [
    paths.bower + '/jquery/dist/jquery.js',
    paths.bower + '/bootstrap/dist/js/bootstrap.min.js',
    paths.bower + '/jasny-bootstrap/dist/js/jasny-bootstrap.js',
    paths.bower + '/angular/angular.js',
    paths.bower + '/angular-route/angular-route.js',
    paths.bower + '/angular-sanitize/angular-sanitize.js',
    paths.bower + '/angular-resource/angular-resource.js',
    paths.bower + '/angular-animate/angular-animate.js',
    paths.bower + '/angular-messages/angular-messages.js',
    paths.bower + '/angular-bootstrap/ui-bootstrap.js',
    paths.bower + '/angular-strap/dist/modules/navbar.js',
    paths.bower + '/angular-cookies/angular-cookies.js',
    paths.bower + '/query-string/query-string.js',
    paths.bower + '/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
    paths.bower + '/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js',
    paths.bower + '/nouislider/distribute/nouislider.js',
    paths.bower + '/angular-file-upload/dist/angular-file-upload.min.js',
    //paths.bower + '/angular-oauth2/dist/angular-oauth2.js',
    paths.bower + '/sweetalert/dist/sweetalert.min.js',
    paths.bower + '/jquery-file-download/src/Scripts/jquery.fileDownload.js',
];

paths.vendor_js_map = [
    paths.bower + '/angular-file-upload/dist/angular-file-upload.min.js.map',
];

paths.vendor_css_map = [];

gulp.task('config', function() {
  var fileEnvConfig = './env-config.json';
  var constants = {
    API_URL: 'http://localhost:8000',
    CLIENT_ID: 'ANGULAR_APP',
    CLIENT_SECRET: ''
  };

  if( ! fs.existsSync(fileEnvConfig)) {
    
    var fd = fs.openSync(fileEnvConfig, 'w');
    fs.writeSync(fd, JSON.stringify(constants));
    fs.closeSync(fd);
    
  } else {
    gulp.src(fileEnvConfig)
        .pipe(ngConstant({
          name: 'app.env.config'
        }))
        .pipe(gulp.dest(paths.build_js));
      }
});

/**
 * Copia os Style para o Build
 */
gulp.task('copy-css', function(){
    gulp.src([
        paths.assets + '/css/**/*.css'
    ])
    .pipe(gulp.dest(paths.build_css))
    .pipe(livereload());

    gulp.src(paths.vendor_css)
    .pipe(gulp.dest(paths.build_vendor+'/css'))
    .pipe(livereload());
});

/**
 * Copia Scripts para o Build
 */
gulp.task('copy-js', function(){
    gulp.src([
        paths.assets + '/js/**/*.js'
    ])
    .pipe(gulp.dest(paths.build_js))
    .pipe(livereload());

    gulp.src(paths.vendor_js)
    .pipe(gulp.dest(paths.build_vendor+'/js'))
    .pipe(livereload());
});

/**
 * Copia as Views
 */
gulp.task('copy-html', function(){
    gulp.src([
        paths.assets + '/js/app/views/**/*.html'
    ])
    .pipe(gulp.dest(paths.build_html))
    .pipe(livereload());
});

/**
 * Copia Maps Vendor
 */
gulp.task('copy-map', function(){
    gulp.src(paths.vendor_js_map)
    .pipe(gulp.dest(paths.build_vendor+'/js'))
    .pipe(livereload());

    gulp.src(paths.vendor_css_map)
    .pipe(gulp.dest(paths.build_vendor+'/css'))
    .pipe(livereload());
});

/**
 * Default Dev
 */
gulp.task('default-dev', ['clean-build'], function(){
    gulp.start(['config', 'copy-css', 'copy-js', 'copy-html', 'copy-map']);
});

/**
 * Watch - Dev
 */
gulp.task('watch-dev', ['clean-build'], function(){
    livereload.listen();
    gulp.start(['default-dev']);
    gulp.watch(paths.assets + '/**', ['default-dev']);
});

/**
 * Compile Assets
 */
gulp.task('default', ['clean-build'], function(){
    gulp.start(['config', 'copy-html', 'copy-map']);

    elixir(function(mix) {
        mix.styles(paths.vendor_css.concat([paths.assets + '/css/**/*.css']),
            paths.public_css + '/all.css', './');

        mix.scripts(paths.vendor_js.concat([paths.assets + '/js/**/*.js']),
            paths.public_js + '/all.js', './');

        mix.version([paths.public_css + '/all.css', paths.public_js + '/all.js']);
    });
});

/**
 * Watch
 */
gulp.task('watch', ['clean-build'], function(){
    livereload.listen();
    gulp.start(['default']);
    gulp.watch(paths.assets + '/**', ['default']);
});

/**
 * Clean
 */
gulp.task('clean-build', function(){
    rimraf.sync(paths.build);
    rimraf.sync(paths.public_css + '/all.css*');
    rimraf.sync(paths.public_js + '/all.js*');
});