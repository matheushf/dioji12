var gulp = require('gulp'),
    path = require('path'),
    runSequence = require('run-sequence'),
    postcss = require('gulp-postcss'),
    sass = require('gulp-sass'),
    csswring = require('csswring'),
    autoprefixer = require('autoprefixer'),
    refresh = require('gulp-refresh'),
    jshint = require('gulp-jshint'),
    compass = require('gulp-compass'),
    wiredep = require('wiredep').stream;

var srcStyles = [
    'assets/sass/**/*.scss'
];
var srcJs = [
    '!assets/js/vendor/**/*.js',
    'assets/js/**/*.js'
];

var srcPaths = srcStyles.concat(srcJs);
srcPaths.push('**/*.html');

var srcWiredep = [
    'head.php',
    'foot.php'
];

gulp.task('styles', function () {
    var processors = [
        csswring,
        autoprefixer
    ];

    return gulp.src(srcStyles)
        .pipe(compass({
            config_file: './config.rb',
            css: 'assets/css',
            sass: 'assets/sass'
        }))
        .pipe(postcss(processors))
        .pipe(gulp.dest('assets/css/'));
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

gulp.task('fonts', function() {
    return gulp.src([
            'bower_components/font-awesome/fonts/fontawesome-webfont.*'])
        .pipe(gulp.dest('assets/fonts/'));
});

gulp.task('bower', function () {
    return gulp.src(srcWiredep)
        .pipe(wiredep({
            bowerJson: require('./bower.json')
        }))
        .pipe(gulp.dest('./'));
});

gulp.task('watch:styles', function () {
    gulp.watch('**/*.scss', ['styles']);
});

gulp.task('watch', function () {
    refresh.listen();
    refresh.options.quiet = true;

    gulp.watch(srcPaths, function () {
        runSequence('styles', ['reload']);
    });
});

gulp.task('build', function () {
    runSequence('bower', 'fonts');
});
