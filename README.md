# Woocommerce Coordinadora Tracking

Enable package tracking with Coordinadora Mercantil (coordinadora.com)

## Development setup
Make sure you have composer installed and you have the `composer` command available globaly 

In the terminal execute the following commands

```bash
composer update
alias p="./vendor/bin/phpunit" 
```
That last line make the command `p` the commando for unit testing

## Integration testing
For testing, the integration values are extracted from the .env file wich you have to create using the follogin command
```bash
cp .env.example .env
```
After that you have to provide the `CLAVE`, `NIT` and `APIKEY` values
