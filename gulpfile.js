/**
 * Gulp file
 * @see: https://css-tricks.com/gulp-for-beginners/
 */

const fsys = require( 'fs' );
const path = require( 'path' );
const merg = require( 'merge-stream' );
const gulp = require( 'gulp' );
const sass = require( 'gulp-sass' );
sass.compiler = require( 'node-sass' );
const maps = require( 'gulp-sourcemaps' );
const prfx = require( 'gulp-autoprefixer' );
const mini = require( 'gulp-clean-css' );
const imgs = require( 'gulp-imagemin' );
const renm = require( 'gulp-rename' );
const repl = require( 'gulp-replace' );
const bump = require( 'gulp-bump' );
const __if = require( 'gulp-if' );
const clog = require( 'fancy-log' );

var paths = {
	sassSrc: './scss/**/*.scss',
	cssOut: './website/css',

	themeSrc: './themesrc/**/*.scss',
	themeOut: './website/themes',
	distOut: './dist',

	sassFoundationIncludes: [
		'./node_modules/foundation-sites/scss',
		'./node_modules/foundation-sites/scss/util',
		'./node_modules/foundation-sites/scss/prototype'
		],
	imgSrc: [
		'./imgsrc/**/*.+(png|jpg|gif|svg)',
		'!./imgsrc/**/_*.*'
		],
	imgOut: './website/',

	copySrc: [
		'./node_modules/jquery/dist/jquery.min.js',
		'./node_modules/what-input/dist/what-input.min.js',
		'./node_modules/foundation-sites/dist/js/foundation.min.js'
		],

	jsOut: './website/js/',

	e403Src: './assets/index-403.php',
	e403Out: [
		'./website/img/',
		'./website/inc/',
		'./website/css/',
		'./website/js/',
		'./website/fonts/'
		],

	prvwSrc: './assets/index-preview.php',
	prvwFldr: './themesrc',
	prvwOutM: './website/themes/%1%/',
}

// thanks to @kennebec https://stackoverflow.com/questions/3954438
Array.prototype.remove = function() {
	var what, a = arguments, L = a.length, ax;
	while (L && this.length) {
		what = a[--L];
		while ((ax = this.indexOf(what)) !== -1) {
			this.splice(ax, 1);
		}
	}
	return this;
};

function getVersion() {
	var json = JSON.parse(fsys.readFileSync('./package.json'));
	var v = json.version;
	json = null;
	return v;
}

function getFolders(dir) {
	return fsys.readdirSync(dir)
		.filter(function(file) {
			return fsys.statSync(path.join(dir, file)).isDirectory();
		});
}

function sassTask(name, srcPath, destPath, min = false, map = true ) {
	gulp.task( name, function(done) {
		return gulp.src( srcPath )
			.on( 'error', console.error.bind( console ))
			.pipe( __if( map, maps.init() ) )
			.pipe( sass( {
				outputStyle: 'expanded',  // don't compress, issues with autoprefixer
				errorLogToConsole: true,
				includePaths: paths.sassFoundationIncludes
				} ) )
			.pipe( prfx( {
				overrideBrowserslist: ['last 2 versions', 'ie >= 9', 'android >= 4.4', 'ios >= 7']
				} ) )
			.pipe( __if( min, mini( {compatibility: 'ie9'} ) ) )
			.pipe( __if( min, renm( {
				suffix: '.min'
				}) ) )
	 		.pipe( __if( map, maps.write( '.' ) ) )
			.pipe( __if( !min, repl(/Foundswatch\sv(\d+\.)(\d+\.)(\d)/g, 'Foundswatch v'+version ) ) )
			.pipe( gulp.dest( destPath ) );
	});
}

/* Work starts here ======================================================== */

var theme_list = getFolders( './themesrc' );
theme_list.remove( '_template' );

var version = getVersion();

// clog(theme_list);

/* Tasks =================================================================== */

gulp.task( 'bump:patch', function(done) {
	return gulp.src('./package.json')
		.pipe(bump())
		.pipe(gulp.dest('./'));
});

gulp.task( 'bump:minor', function(done) {
	return gulp.src('./package.json')
		.pipe(bump({type:'minor'}))
		.pipe(gulp.dest('./'));
});

gulp.task( 'bump:major', function(done) {
	return gulp.src('./package.json')
		.pipe(bump({type:'major'}))
		.pipe(gulp.dest('./'));
});

gulp.task( 'bump', gulp.series( 'bump:patch' ) );

/* Task : sass:css --------------------------------------------------------- */

sassTask( 'sass:css', paths.sassSrc, paths.cssOut, true );

/* Task : sass:themes ------------------------------------------------------ */

var theme_sass_list = [];

theme_list.forEach( function(name) {
	var tname = 'sass:theme:'+name;
	var tpath = paths.themeSrc.replace('**', name+'/**');
	theme_sass_list.push( tname );

	sassTask( tname, tpath, paths.themeOut+'/'+name, false, true );
});

gulp.task( 'sass:themes', gulp.series( theme_sass_list ) );

/* Task : sass:themes:min -------------------------------------------------- */

var theme_sass_min_list = [];

theme_list.forEach( function(name) {
	var tname = 'sass:theme:'+name+':min';
	var tpath = paths.themeSrc.replace('**', name+'/**');
	theme_sass_min_list.push( tname );

	sassTask( tname, tpath, paths.themeOut+'/'+name, true, false );
});

gulp.task( 'sass:themes:min', gulp.series( theme_sass_min_list ) );

/* Task : sass ------------------------------------------------------------- */

gulp.task( 'sass' , gulp.series( 'sass:css', 'sass:themes', 'sass:themes:min' ) );

/* Test : dist ------------------------------------------------------------- */

var theme_dist_list = [];
var theme_list_copy = Array.from(theme_list);
theme_list_copy.remove('default');

theme_list_copy.forEach( function(name) {
	var tname = 'dist:'+name;
	var tpath = paths.themeSrc.replace('**', name+'/**');
	theme_dist_list.push( tname );

	sassTask( tname, tpath, paths.distOut+'/'+name, false, true );

	tname = 'dist:'+name+':min';
	theme_dist_list.push( tname );

	sassTask( tname, tpath, paths.distOut+'/'+name, true, true );  // jsDelivr requires map files on min css'
});

theme_list_copy = null;
gulp.task( 'dist', gulp.parallel( theme_dist_list ) );

/* Task : images ----------------------------------------------------------- */

gulp.task('images', function(done) {
	return gulp.src( paths.imgSrc )
		.on( 'error', console.error.bind( console ))
		.pipe( imgs( [
			imgs.gifsicle({interlaced: true}),
			// imgs.jpegtran({progressive: true}),
			imgs.mozjpeg({quality: 75, progressive: true}),
			imgs.optipng({optimizationLevel: 5}),
			imgs.svgo({
				plugins: [
					{removeDoctype: true},
					{removeXMLProcInst: true},
					{removeComments: true},
					{removeMetadata: true},
					{removeTitle: true},
					{removeDesc: true},
					{removeEditorsNSData: true},
					{removeEmptyAttrs: true},
					{removeHiddenElems: true},
					{removeEmptyText: true},
					{removeEmptyContainers: true},
					{removeViewBox: true},
					{removeUselessStrokeAndFill: true},
					// maintain <style> blocks
					{removeStyleElement: false},
					{inlineStyles: false},
					{minifyStyles: true},
					{convertStyleToAttrs: false},
					// keep scripts
					{removeScriptElement: false},
					// keep id's
					{cleanupIDs: false}
					]
				})
			]) )
		.pipe( gulp.dest( paths.imgOut ) );
});

/* Task : ------------------------------------------------------------------ */

gulp.task( 'copy:js', function(done) {
	return gulp.src( paths.copySrc )
		.on( 'error', console.error.bind( console ))
		.pipe( gulp.dest( paths.jsOut ) );
});

/* Task : copy:scss -------------------------------------------------------- */

var theme_copy_scss_list = [];

theme_list.forEach( function(name) {
	var tname = 'copy:scss:' + name;
	var tpath = paths.themeSrc.replace('**', name+'/**');
	theme_copy_scss_list.push( tname );

	gulp.task( tname, function(done) {
		return gulp.src( tpath )
			.on( 'error', console.error.bind( console ))
			.pipe( repl(/Foundswatch\sv(\d+\.)(\d+\.)(\d)/g, 'Foundswatch v'+version ) )
			.pipe( gulp.dest( paths.themeOut+'/'+name ) );
	});
});

gulp.task( 'copy:scss', gulp.series( theme_copy_scss_list ) );

/* Task : ------------------------------------------------------------------ */

gulp.task( 'copy:403s', function(done) {
	var folders = paths.e403Out;

	var tasks = folders.map(function(folder) {
		// clog( '... to \'\x1b[32m' + folder + '\'\x1b[0m...' );
		return gulp.src( paths.e403Src )
			.on( 'error', console.error.bind( console ))
			.pipe( renm('index.php') )
			.pipe( gulp.dest( folder ) );
		});

	return merg( tasks );
});

/* Task : ------------------------------------------------------------------ */

gulp.task( 'copy:preview', function(done) {
	var folders = getFolders( paths.prvwFldr );
	folders.remove( '_template' );
	if (folders.length === 0) return done();  // nothing to do!

	var tasks = folders.map(function(folder) {
		// clog( '... for \'\x1b[32m' + folder + '\'\x1b[0m...' );
		return gulp.src( paths.prvwSrc )
			.on( 'error', console.error.bind( console ))
			.pipe( renm( 'index.php' ) )
			.pipe( gulp.dest( paths.prvwOutM.replace('%1%', folder) ) );
	});

    return merg( tasks );
});

gulp.task( 'copy' , gulp.series( 'copy:js', 'copy:scss', 'copy:preview', 'copy:403s' ) );

/* General & Default Tasks ================================================= */

gulp.task( 'watch', function(done) {
	clog( 'Watching ... \x1b[94m(Press Control-C to end.)\x1b[0m' );
	gulp.watch( paths.sassSrc, gulp.parallel( 'sass:css' ) );
	gulp.watch( paths.imgSrc, gulp.parallel( 'images' ) );

	theme_list.forEach( function(name) {
		var tpath = paths.themeSrc.replace('**', name+'/**');
		gulp.watch( tpath, gulp.series( 'sass:theme:'+name, 'sass:theme:'+name+':min' , 'copy:scss:'+name) );
	} );
});

gulp.task( 'note', function(done) {
	clog( '============================================' );
	clog( 'Foundswatch v'+version );
	clog( 'Use "\x1b[32mgulp all\x1b[0m", "\x1b[31mgulp watch\x1b[0m" or "\x1b[34mgulp dist\x1b[0m".' );
	clog( 'Use "\x1b[33mgulp --tasks\x1b[0m" to view all.')
	clog( '============================================' );
	return done();
});

gulp.task( 'all' , gulp.series( 'sass', 'images', 'copy' ) );

gulp.task( 'default' , gulp.series( 'note' ) );

// eof
