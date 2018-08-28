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

## Deployment on a test server

You can save this script in a file called `deploy.sh` changing the `path` and the `username` of the remote server
```bash
REMOTE_USER=myusername
REMOTE_SERVER=example.com
REMOTE_PATH=/path/to/wp/wp-content/plugins/`basename ${PWD}` # No trailing '/'

composer dump-autoload --no-dev -o

rsync -avz -e ssh --delete --exclude=.git* --exclude=*.zip --exclude=.DS_Store ./* ${REMOTE_USER}@${REMOTE_SERVER}:${REMOTE_PATH}/
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
