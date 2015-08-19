var elixir = require('laravel-elixir');
var livereload = require('gulp-livereload');
var rimraf = require('rimraf');
var gulp = require('gulp');

var paths = {
    'build': './public/build',
    'build_js': './public/build/js',
    'build_css': './public/build/css',
    'build_html': './public/build/views',
    'build_vendor': './public/build/vendor',
    'assets': './resources/assets',
    'bower': './bower_components',
};

paths.vendor_css = [
    paths.bower + '/bootstrap/dist/css/bootstrap.min.css',
    paths.assets + '/css/animate.css',
    paths.assets + '/css/styles.css'
];

paths.vendor_js = [
    paths.bower + '/jquery/dist/jquery.js',
    paths.bower + '/angular/angular.js',
    paths.bower + '/angular-route/angular-route.js',
    paths.bower + '/angular-resource/angular-resource.js',
    paths.bower + '/angular-animate/angular-animate.js',
    paths.bower + '/angular-messages/angular-messages.js',
    paths.bower + '/angular-bootstrap/ui-bootstrap.js',
    paths.bower + '/angular-strap/dist/modules/navbar.js',
    paths.bower + '/angular-cookies/angular-cookies.js',
    paths.bower + '/query-string/query-string.js',
    paths.bower + '/angular-oauth2/dist/angular-oauth2.js',
];

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
 * Default Dev
 */
gulp.task('default-dev', ['clean-build'], function(){
    gulp.start(['copy-css', 'copy-js', 'copy-html']);
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
    gulp.start(['copy-html']);

    elixir(function(mix) {
        mix.styles(paths.vendor_css.concat([paths.assets + '/css/**/*.css']),
            'public/css/all.css', './');

        mix.styles(paths.vendor_js.concat([paths.assets + '/js/**/*.js']),
            'public/js/all.js', './');
        
        mix.version(['public/css/all.css', 'public/js/all.js']);
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
});