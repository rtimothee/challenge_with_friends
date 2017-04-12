var gulp = require('gulp');
var less = require('gulp-less');
var minifyCSS = require('gulp-csso');
var watch = require('gulp-watch');
var autoprefixer = require('gulp-autoprefixer');


gulp.task('css', function(){
    return gulp.src('web/css/*.less')
        .pipe(less())
        .pipe(autoprefixer())
        .pipe(minifyCSS())
        .pipe(gulp.dest('web/css'))
});

gulp.task('build', ['css']);

gulp.task('watch', function () {
    gulp.watch('web/css/*.less', ['build']);
});

gulp.task('default', [ 'build' ]);
          