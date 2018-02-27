//-------------------------------------------------
//
//-------------------------------------------------
'use strict';

//
//
//
var
    gulp    = require('gulp'),
    uglify  = require('gulp-uglify'),
    concat  = require('gulp-concat'),
    pump    = require('pump'),
    sass    = require('gulp-sass'),
    replace = require('gulp-replace')
;

//
//  public resources are always accessible
//  private resources are only accessible when logged in
//
var skynotes = (function(){
    var self = {
        css: {
            public: [
                'src/css/main.css',
                'src/sass/bootstrap-theme.scss',
                'node_modules/font-awesome/css/font-awesome.css'
            ],
            private: [
                'src/css/document.css',
                'src/css/document-html.css',
                'src/css/pdf.css'
            ],
            all: function(){
                return this.public.concat(this.private);
            }
        },
        js: {
            public: [
                'node_modules/angular/angular.js',
                'node_modules/angular-sanitize/angular-sanitize.js',
                'src/js/sky-notes.public.angular.js',
                'src/js/sky-notes-login-controller.js'
            ],
            private: [
                'node_modules/ace-builds/src-min-noconflict/ace.js',
                'node_modules/ace-builds/src-min-noconflict/mode-markdown.js',
                'node_modules/ace-builds/src-min-noconflict/ext-language_tools.js',
                'node_modules/angular-ui-ace/src/ui-ace.js',
                'node_modules/showdown/dist/showdown.js',
                'node_modules/showdown-table/dist/showdown-table.js',
                'node_modules/jquery/dist/jquery.js',
                'node_modules/popper.js/dist/umd/popper.js',
                'node_modules/bootstrap/dist/js/bootstrap.js',
                'src/js/sky-notes.angular.js',
                'src/js/showdown.angular.js',
                'src/js/sky-notes-main.angular.js',
                'src/js/sky-notes-notebook.angular.js',
                'src/js/sky-notes-service.angular.js'
            ],
            all: function(){
                return this.public.concat(this.private);
            }
        }
    };
    var themes = [
        'ambiance',
        'chaos',
        'chrome',
        'clouds',
        'clouds_midnight',
        'cobalt',
        'crimson_editor',
        'dawn',
        'dracula',
        'dreamweaver',
        'eclipse',
        'github',
        'gob',
        'gruvbox',
        'idle_fingers',
        'iplastic',
        'katzenmilch',
        'kr_theme',
        'kuroir',
        'merbivore',
        'merbivore_soft',
        'mono_industrial',
        'monokai',
        'pastel_on_dark',
        'solarized_dark',
        'solarized_light',
        'sqlserver',
        'terminal',
        'textmate',
        'tomorrow',
        'tomorrow_night_blue',
        'tomorrow_night_bright',
        'tomorrow_night_eighties',
        'tomorrow_night',
        'twilight',
        'vibrant_ink',
        'xcode'
    ];
    for(var i = 0; i < themes.length; ++i){
        self.js.private.push('node_modules/ace-builds/src-min-noconflict/theme-'+themes[i]+'.js');
    }
    return self;
})();

//
//
//
gulp.task('fontawesomefonts', function(){
    return gulp.src('node_modules/font-awesome/fonts/*')
    .pipe(gulp.dest('app/fonts/fontawesome'));
});

//
//
//
gulp.task('css.public', function(){
    return gulp.src(skynotes.css.public)
    .pipe(concat('skynotes.public.css'))
    .pipe(replace('../fonts/fontawesome','fontawesome/fontawesome'))
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(gulp.dest('app/css'));
});

//
//
//
gulp.task('css.private', function(){
    return gulp.src(skynotes.css.all())
    .pipe(concat('skynotes.private.css'))
    .pipe(replace('../fonts/fontawesome','fontawesome/fontawesome'))
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(gulp.dest('app/css'));
});

//
//
//
gulp.task('js.public', function(cb){
    pump([
        gulp.src(skynotes.js.public),
        uglify(),
        concat('skynotes.public.js'),
        gulp.dest('app/js')
    ],cb);
});

//
//
//
gulp.task('js.private', function(cb){
    pump([
        gulp.src(skynotes.js.all()),
        uglify(),
        concat('skynotes.private.js'),
        gulp.dest('app/js')
    ],cb);
});

//
//
//
gulp.task('default', [
    'fontawesomefonts',
    'css.private',
    'css.public',
    'js.private',
    'js.public'
]);
