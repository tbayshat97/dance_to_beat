# (Dance2Beat) project

### Create your .env File
> you can copy and paste .env.example file ;)
or use command:
```bash
$ cp .env.example .env
```

### Install packages
```bash
$ composer install
```
or
```bash
$ composer install --ignore-platform-reqs
```

### Generate Application Key
```bash
$ php artisan key:generate
```

### Link storage
```bash
$ php artisan storage:link
```

### Give storage folder permission (For linux users)
```bash
$ chmod -R 777 storage/
```

### Migrate Database
```bash
$ php artisan migrate
```

### Seeding Database (if APP_ENV=development will generate only development mode data)
```bash
php artisan db:seed
```
------------
