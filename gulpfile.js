var gulp = require('gulp'),
    path = require('path'),
    postcss = require('gulp-postcss'),
    sass = require('gulp-sass'),
    csswring = require('csswring'),
    autoprefixer = require('autoprefixer'),
    refresh = require('gulp-refresh'),
    jshint = require('gulp-jshint'),
    compass = require('gulp-compass');

var srcStyles = [
    'assets/css/**/*.scss'
];
var srcJs = [
    '!assets/js/vendor/**/*.js',
    'assets/js/**/*.js'
];
var srcPaths = srcStyles.concat(srcJs);
srcPaths.push('**/*.html');

gulp.task('styles', function () {
    var processors = [
        csswring,
        autoprefixer
    ];

    return gulp.src(srcStyles)
        .pipe(compass({
            config_file: './config.rb',
            css: 'assets/css',
            sass: 'assets/css'
        }))
        .pipe(postcss(processors))
        .pipe(gulp.dest('assets/css/'))
        .pipe(refresh());
});

gulp.task('jshint', function () {
    return gulp.src(srcJs)
        .pipe(jshint())
        .pipe(jshint.reporter('default'))
        .pipe(refresh());
});

gulp.task('reload', function () {
    return gulp.src(srcPaths)
        .pipe(refresh())
});

gulp.task('watch:styles', function () {
    gulp.watch('**/*.scss', ['styles']);
});

gulp.task('watch', function () {
    refresh.listen();
    refresh.options.quiet = true;

    gulp.watch(srcPaths, ['styles', 'reload']);
});