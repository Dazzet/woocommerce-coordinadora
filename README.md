# Woocommerce Coordinadora Mercantil Tracking

Enable package tracking with Coordinadora Mercantil (coordinadora.com)

![](screenshots/screenshot-1.png | width=250)
![](screenshots/screenshot-2.png | width=250)
![](screenshots/screenshot-3.png | width=250)
![](screenshots/screenshot-4.png | width=250)

## Development setup

```bash
cd /path/to/wp/wp-content/plugins/
git clone git@github.com:Dazzet/woocommerce-coordinadora.git
cd woocommerce-coordinadora
composer install
```

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

## Integration testing
For testing, the integration values are extracted from the .env file wich you have to create using the follogin command
```bash
cp .env.example .env
```
After that you have to provide the `CLAVE`, `NIT` and `APIKEY` values which are provided by _Coordinadora Mercantil_

## Translation

You can use loco-translate for the string extraction and translation. Be sure to save the `.pot` file in the `languages` directory
