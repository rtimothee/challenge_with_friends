var gulp = require('gulp');
var sass = require('gulp-sass');
var minifyCSS = require('gulp-csso');
var watch = require('gulp-watch');
var autoprefixer = require('gulp-autoprefixer');


gulp.task('css', function(){
    return gulp.src('web/css/*.scss')
        .pipe(sass.sync().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(minifyCSS())
        .pipe(gulp.dest('web/css'))
});

gulp.task('build', ['css']);

gulp.task('watch', function () {
    gulp.watch('web/css/*.scss', ['build']);
});

gulp.task('default', [ 'build' ]);
          