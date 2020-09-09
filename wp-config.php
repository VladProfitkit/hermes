<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'u0518747_default');

/** Имя пользователя MySQL */
define('DB_USER', 'u0518747_default');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'A6Aba4dty7tWA0');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'C[Z`zyJ&Qh(^)i[vm/%59|X5%V*MRBFT4Khm{)[QS)0h>-RE4cx15cL6Wg~{a xJ');
define('SECURE_AUTH_KEY',  '|UV!=oy=6WKR)a>=_8l&l(&i; XJr.^%q?07xefQ}KCnQ.ln-@Ee[?AEKuN-Y}`/');
define('LOGGED_IN_KEY',    ';5<!cTaU?}oG]0i#-#W8`QBmX1(tus`CuiC=,c`5%1X#B?vbS$-e+48bGyLFIdat');
define('NONCE_KEY',        '}18[i3FD]L+ea;cba;?|`Nf$5ubMZ.y#ngbv|t#M/m!*nVSM|fD/^Vx+lut+W&Nu');
define('AUTH_SALT',        '9lp6xR qToe%f%{yXdf_6!M[L6aQE}J+fg/[r17*.B*@E{ysZ1Wx6*;+c;<kTQ/p');
define('SECURE_AUTH_SALT', 'Tp[c,# m)k^4P0Fxo le4}S<!T.ZvyRnyLRCMw5j}a>e5MfQOizWQB-*.HkezAOW');
define('LOGGED_IN_SALT',   'Y,gjcIn>y6<E{H}:L/`7,3ud=CF{euTe+1%7<.p=b+Tl#p0mEed2edAvi8A5`E&z');
define('NONCE_SALT',       '(S2k%Fb)0lI==_Z-_I|?qn7I+q0qmRm*vR7&oe,1g4Mw:NcQ_eU +2]}L*k9uIBJ');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
