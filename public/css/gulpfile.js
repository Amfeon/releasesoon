var gulp=require('gulp');
var sass=require('gulp-sass');
var gcmq = require('gulp-group-css-media-queries');
gulp.task('sass', function(){
	gulp.src('*.scss')
	.pipe(sass().on('error',sass.logError))
	.pipe(gcmq())
	.pipe(gulp.dest('./'));
});
gulp.task('sass:watch',function(){
	gulp.watch('*.scss',['sass']);
})