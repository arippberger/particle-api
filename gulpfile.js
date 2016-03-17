var gulp  = require('gulp');
var babel = require('gulp-babel');
var webpack = require('webpack');

gulp.task('default', function() {
    // place code for your default task here
    return gulp.src("assets/js/src/particle-api.js")
        .pipe(babel())
        .pipe(webpack( require('./assets/js/webpack.config.js') ))
        .pipe(gulp.dest('dist/'));
});