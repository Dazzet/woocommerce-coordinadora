
var gulp = require('gulp'),
  rsync  = require('gulp-rsync'),
  shell  = require('gulp-shell'),
  nconf  = require('nconf'),
  path   = require('path');

nconf.set('host', 'wp01.dazzet.co')
nconf.set('path', '/var/www/wp/wp-content/plugins/woocoomerce-coordinadora/');
nconf.set('user', '');
nconf.argv().env().file( { file: 'conf.json'});

gulp.task('rsync', function() {
  const dirname = path.basename(__dirname);

  return gulp.src([
    'languages/*', 'wsdl/*', '*.php', 'readme.txt', 'lib/**'
  ])
    .pipe( rsync({
      root: './',
      hostname:    nconf.any('server', 'host'),
      destination: nconf.any('path', 'path'),
      username:    nconf.any('username', 'user'),
      archive:  true,
      update:   true,
      delete:   true,
      compress: true,
      exclude: ['*.js', '*.md']
    }));
});

gulp.task('default', function() {
  console.log('Create a conf.json file with the "host", "path" and "username" parammeters');
  console.log('Then execute `gulp rsync` to sync the files with the remote server');
});
