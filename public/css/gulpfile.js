var gulp=require('gulp');
var sass=require('gulp-sass');
var gcmq = require('gulp-group-css-media-queries');
csso = require('gulp-csso'); // Минификация CSS
gulp.task('sass', function(){
	gulp.src('*.scss')
	.pipe(sass().on('error',sass.logError))
	.pipe(gcmq())
	.pipe(csso()) // минифицируем css, полученный на предыдущем шаге
	.pipe(gulp.dest('./'));
});
gulp.task('sass:watch',function(){
	gulp.watch('*.scss',['sass']);
})