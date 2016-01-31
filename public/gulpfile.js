var gulp        = require('gulp'),
    less        = require('gulp-less'),
    rename      = require('gulp-rename'),
    concat      = require('gulp-concat'),
    minify      = require('gulp-minify-css'),
    uglify      = require('gulp-uglify');


gulp.task('fonts', function() {

    return gulp.src(['bower_components/uikit/fonts/*'])
        .pipe(rename({dirname: 'fonts'}))
        .pipe(gulp.dest('./assets/dist'));

});

gulp.task('less', function() {

    return gulp.src('less/site.less')
        .pipe(less({ compress: true }))
        .pipe(concat('app.css'))
        .pipe(minify({keepBreaks: false, keepSpecialComments: 0}))
        .pipe(rename({dirname: ''}))
        .pipe(gulp.dest('./assets/dist/'));

});

gulp.task('js', function() {

    // Common JS assets for every view
    return gulp.src(['bower_components/jquery/dist/jquery.min.js',
         'bower_components/uikit/js/uikit.min.js',
         'bower_components/uikit/js/components/sticky.min.js',
         'bower_components/uikit/js/components/notify.min.js',
         'bower_components/uikit/js/components/sortable.min.js',
         'bower_components/jquery.cookie/jquery.cookie.js',
         'js/cookie.js'])
        .pipe(rename({dirname: ''}))
        .pipe(concat('app.js'))
        .pipe(uglify({ mangle: false }))
        .pipe(gulp.dest('./assets/dist/'));

});

gulp.task('js-admin', function() {

    // Admin JS assets, needed only in backend
   return gulp.src(['bower_components/vue/**/*.min.js',
       'bower_components/vue-resource/**/*.min.js',
       'js/settings.js'])
       .pipe(rename({dirname: ''}))
       .pipe(concat('settings.js'))
       .pipe(uglify({ mangle: false }))
       .pipe(gulp.dest('./assets/dist/'));

});

gulp.task('default', ['fonts', 'less', 'js', 'js-admin']);

gulp.task('watch', function() {

    // when any less file is changed: recompile
    gulp.watch(['less/*.less', 'js/*.js'], ['default']);

});
