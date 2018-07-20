
var gulp = require('gulp'),
  rsync  = require('gulp-rsync'),
  shell  = require('gulp-shell'),
  nconf  = require('nconf'),
  path   = require('path');

nconf.argv().env().file( { file: 'conf.json'});

gulp.task('rsync', function() {
  const dirname = path.basename(__dirname);

  return gulp.src([
    'languages/*', 'wsdl/*', '*.php', 'readme.txt', 'lib/**'
  ])
    .pipe( rsync({
      root: './',
      hostname:    nconf.any('server', 'remoteServer'),
      destination: nconf.any('path', 'remotePath'),
      username:    nconf.any('username', 'remoteUsername'),
      archive:  true,
      update:   true,
      delete:   true,
      compress: true,
      exclude: ['*.js', '*.md']
    }));
})

