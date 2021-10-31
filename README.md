# Witrac Technical Exercise

## Application
 
This application is built with [Laravel](https://laravel.com/docs/8.x) 8, requiring:

- PHP >= 7.3
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Installation

For local development purposes, the simplest setup is to use [Laravel Homestead](https://laravel.com/docs/homestead). The recommended vagrant box version is `>= 11.5.0`, and Homestead version `>= 12.7.1`.

Add this block to your `sites` section on your `Homestead.yaml` file:

```
- map: www.witrac.test
  to: <your_project_folder>/public
  php: "8.0"
```

Add this block to your `databases` section on your `Homestead.yaml` file:

```
- witrac_test
```

Run `vagrant provision` once you've completed all these steps.

Next, update the `/etc/hosts` (on macOS/Linux systems, `C:\Windows\System32\Drivers\etc\hosts` on Windows systems) on your host machine to point `www.witrac.test` to your Homestead box IP (`192.168.10.10` by default).

Once all these steps have been completed, you can install every required package running from the root project folder:

- `cp .env.example .env`. Update all required data in the new `.env` file with your local data.
- `npm install` (version `6.14.0` at the moment this documentation was written).
- `composer install`.

To compile assets, you must run:

- `npm run dev` Compiles assets without minimizing and versioning them.
- `npm run watch` Same as above, but it keeps listening for changes and will compile them automatically.
- `npm run prod` Compiles assets minimizing and versioning them. These will be the version uploaded to production.

For push notifications to run correctly, you should have an active queue listener. If you're using Homestead, the simplest option is using `Redis` by switching the `QUEUE_CONNECTION` variable in the `.env` file to `redis` and running `php artisan queue:listen` in the application root folder.

## Maintainers

- Daniel Mora Pastor - dmora.1989@gmail.com
