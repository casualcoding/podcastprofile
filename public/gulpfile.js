var gulp        = require('gulp'),
    less        = require('gulp-less'),
    rename      = require('gulp-rename'),
    concat      = require('gulp-concat'),
    minify      = require('gulp-minify-css'),
    uglify      = require('gulp-uglify');

gulp.task('dist', function() {

    // Fonts
    gulp.src(['bower_components/uikit/fonts/*'])
        .pipe(rename({dirname: 'fonts'}))
        .pipe(gulp.dest('./assets/dist'));

    // CSS
    gulp.src('less/site.less')
        .pipe(less({ compress: true }))
        .pipe(concat('app.css'))
        .pipe(minify({keepBreaks: false, keepSpecialComments: 0}))
        .pipe(rename({dirname: ''}))
        .pipe(gulp.dest('./assets/dist/'));

   // JS
   gulp.src(['bower_components/jquery/dist/jquery.min.js',
        'bower_components/uikit/js/uikit.min.js',
        'bower_components/uikit/js/components/sticky.min.js'])
       .pipe(rename({dirname: ''}))
       .pipe(concat('app.js'))
       .pipe(uglify())
       .pipe(gulp.dest('./assets/dist/'));

       gulp.src(['bower_components/vue/**/*.min.js',
       'bower_components/vue-resource/**/*.min.js',
       'js/settings.js'])
       .pipe(rename({dirname: ''}))
       .pipe(concat('settings.js'))
       .pipe(uglify())
       .pipe(gulp.dest('./assets/dist/'));

});

gulp.task('default', ['dist']);

gulp.task('watch', function() {

    // when any less file is changed: recompile
    gulp.watch(['less/*.less', 'js/*.js'], ['dist']);

});
