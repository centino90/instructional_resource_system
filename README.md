# Instructional Resource System
a system for managing and distributing instructional resources 

## Setup

### Step 1

```bash
composer install
```

### Step 2

```bash
composer update
```

### Step 3

download [LibreOffice 7.3.2](https://www.libreoffice.org/download/download/)

add the LibreOffice folder in this project's root directory

find the office converter class in path <i>vendor\ncjoes\office-converter\src\OfficeConverter\OfficeConverter.php</i> and find the <i>exec</i> method and change the <i>cmd</i> paramater value to <i>set HOME=/tmp && '.$cmd</i>

<!-- ### Step 4

download [Poppler 0.68.0](https://blog.alivate.com.au/poppler-windows/)

add the poppler-0.68.0 folder in this project's root directory -->

### step 4 
```bash
php artisan storage:link
```

### step 5 
```bash
php artisan optimize:clear
```

### Step 6

```bash
php artisan fresh:all
```

### Step 7

```bash
php artisan serve
```

### Step 8

go to the url http://127.0.0.1:8000/

