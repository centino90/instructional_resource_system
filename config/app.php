<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Asia/Chongqing',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,
        Yajra\DataTables\DataTablesServiceProvider::class,
        Elibyy\TCPDF\ServiceProvider::class,
        Barryvdh\Elfinder\ElfinderServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Barryvdh\DomPDF\ServiceProvider::class,
        Barryvdh\Debugbar\ServiceProvider::class,
        Venturecraft\Revisionable\RevisionableServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        // 'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        // 'PDF' => Barryvdh\DomPDF\Facade::class,
        'PDF' => Elibyy\TCPDF\Facades\TCPDF::class,
        'Debugbar' => Barryvdh\Debugbar\Facade::class,
        'DataTables' => Yajra\DataTables\Facades\DataTables::class,
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
        'Carbon' => Carbon\Carbon::class,
        'Builder' => Illuminate\Database\Eloquent\Builder::class,
    ],

    'pdf_convertible_mimetypes' => [
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.ms-powerpoint',
        'application/pdf',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-excel',
    ],

    'pdf_convertible_filetypes' => [
        'pptx',
        'ppt',
        'docx',
        'doc',
        'odt',
        // 'pdf',
        // 'xlsx',
        // 'xls'
    ],

    'spreadsheet_convertible_filetypes' => ['xls', 'xlsx', 'csv', 'tsv', 'ods'],

    'php_imgtype_constants' => [
        IMAGETYPE_GIF,
        IMAGETYPE_JPEG2000,
        IMAGETYPE_SWF,
        IMAGETYPE_PSD,
        IMAGETYPE_BMP,
        IMAGETYPE_WBMP,
        IMAGETYPE_XBM,
        IMAGETYPE_TIFF_II,
        IMAGETYPE_TIFF_MM,
        IMAGETYPE_IFF,
        IMAGETYPE_JB2,
        IMAGETYPE_JPC,
        IMAGETYPE_JP2,
        IMAGETYPE_JPX,
        IMAGETYPE_SWC,
        IMAGETYPE_ICO,
        IMAGETYPE_WEBP,
    ],

    'img_filetypes' => [
        'gif',
        'png',
        'jpg',
        'jpeg',
        'webp',
        // 'tiff',
        'svg'
    ],

    'executable_filetypes' => [
        'BAT',
        'BIN',
        'CMD',
        'COM',
        'CPL',
        'EXE',
        'GADGET',
        'INF1',
        'INS',
        'INX',
        'ISU',
        'JOB',
        'JSE',
        'LNK',
        'MSC',
        'MSI',
        'MSP',
        'MST',
        'PAF',
        'PIF',
        'PS1',
        'REG',
        'RGS',
        'SCR',
        'SCT',
        'SHB',
        'SHS',
        'U3P',
        'VB',
        'VBE',
        'VBS',
        'VBSCRIPT',
        'WS',
        'WSF',
        'WSH',
    ],

    'zip_filetypes' => [
        'zip',
        // 'rar',
        // 'tar',
        // 'jar',
    ],

    'video_filetypes' => [
        'mp4',
        // 'mov',
        // 'wmv',
        // 'avi',
        // 'avchd',
        // 'flv',
        // 'f4v',
        // 'swf',
        // 'mkv',
        // 'webm ',
    ],

    'audio_filetypes' => [
        'mp3',
        // 'ogg',
        // 'wav'
    ],

    'text_filetypes' => array(
        'txt',
        'groovy',
        'ini',
        'properties',
        'css',
        'scss',
        'html',
        'htm',
        'shtm',
        'shtml',
        'xhtml',
        'cfm',
        'cfml',
        'cfc',
        'dhtml',
        'xht',
        'tpl',
        'twig',
        'hbs',
        'handlebars',
        'kit',
        'jsp',
        'aspx',
        'ascx',
        'asp',
        'master',
        'cshtml',
        'vbhtml',
        'ejs',
        'dust',
        'erb',
        'js',
        'jsx',
        'jsm',
        '_js',
        'vbs',
        'vb',
        'json',
        'xml',
        'svg',
        'wxs',
        'wxl',
        'wsdl',
        'rss',
        'atom',
        'rdf',
        'xslt',
        'xsl',
        'xul',
        'xbl',
        'mathml',
        'config',
        'plist',
        'xaml',
        'php',
        'php3',
        'php4',
        'php5',
        'phtm',
        'phtml',
        'ctp',
        'c',
        'h',
        'i',
        'cc',
        'cp',
        'cpp',
        'c++',
        'cxx',
        'hh',
        'hpp',
        'hxx',
        'h++',
        'ii',
        'ino',
        'cs',
        'asax',
        'ashx',
        'java',
        'scala',
        'sbt',
        'coffee',
        'cf',
        'cson',
        '_coffee',
        'clj',
        'cljs',
        'cljx',
        'pl',
        'pm',
        'rb',
        'ru',
        'gemspec',
        'rake',
        'py',
        'pyw',
        'wsgi',
        'sass',
        'lua',
        'sql',
        'diff',
        'patch',
        'md',
        'markdown',
        'mdown',
        'mkdn',
        'yaml',
        'yml',
        'hx',
        'sh',
        'command',
        'bash'
    )
];
