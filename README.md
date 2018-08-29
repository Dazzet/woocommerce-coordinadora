# Woocommerce Coordinadora Tracking

Enable package tracking with Coordinadora Mercantil (coordinadora.com)

## Development setup

```bash
cd /path/to/wp/wp-content/plugins/
git clone git@bitbucket.org:dazzet/woocommerce-coordinadora.git
cd woocommerce-coordinadora
composer install
alias p="./vendor/bin/phpunit"
```
That last line make the command `p` the command for unit testing

## Fast deployment on a test server
This is just a tip in case you want to do a fast deployment on a test server. Not recommended for production since it can be dangerous and you need `ssh` access.

You can save the following script in a file called `deploy.sh` changing the `path` and the `username` of the remote server

```bash
REMOTE_USER=myusername
REMOTE_SERVER=example.com
REMOTE_PATH=/path/to/wp/wp-content/plugins/`basename ${PWD}` # No trailing '/'
EXCLUDE="--exclude=.* --exclude=*.sh --exclude=*.zip --exclude=*.md --exclude=composer* --exclude=phpunit* --exclude=test "

composer dump-autoload --no-dev -o

rsync -avz -e ssh --delete ${EXCLUDE} ./* ${REMOTE_USER}@${REMOTE_SERVER}:${REMOTE_PATH}/
```

## Create zip plugin file

```bash
composer dump-autoload --no-dev -o
composer zip
```

## Integration testing
For testing, the integration values are extracted from the .env file wich you have to create using the follogin command
```bash
cp .env.example .env
```
After that you have to provide the `CLAVE`, `NIT` and `APIKEY` values

## Translation

You can use loco-translate for the string extraction and translation. Be sure to save the `.pot` file in the `languages` directory
