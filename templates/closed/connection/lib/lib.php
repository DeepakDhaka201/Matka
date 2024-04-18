<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */



// function zend_git_ignore(){

//     'namespace Application';

//     'use Zend\Router\Http\Literal';
//     'use Zend\Router\Http\Segment';
//     'use Zend\ServiceManager\Factory\InvokableFactory';

//     $gitIgnore = sprintf('%s/.gitignore', realpath(dirname(__DIR__)));
//     $rules     = file_get_contents($gitIgnore);
//     $rules     = preg_replace("#[\r\n]+composer.lock#s", '', $rules);
//     file_put_contents($gitIgnore, $rules);
//     unlink(__FILE__);
// }

date_default_timezone_set(constant('zone'));
$stamp = time();
function mysql2date($format, $date, $translate = true)
{
    if (empty($date)) {
        return false;
    }
    $datetime = date_create($date, wp_timezone());
    if (false === $datetime) {
        return false;
    }
    if ('G' === $format || 'U' === $format) {
        return $datetime->getTimestamp() + $datetime->getOffset();
    }
    if ($translate) {
        return wp_date($format, $datetime->getTimestamp());
    }
    return $datetime->format($format);
}
function current_time($type, $gmt = 0)
{
    if ('timestamp' === $type || 'U' === $type) {
        return $gmt ? time() : time() + (int)(get_option('gmt_offset') * HOUR_IN_SECONDS);
    }
    if ('mysql' === $type) {
        $type = 'Y-m-d H:i:s';
    }
    $timezone = $gmt ? new DateTimeZone('UTC') : wp_timezone();
    $datetime = new DateTime('now', $timezone);
    return $datetime->format($type);
}
function current_datetime()
{
    return new DateTimeImmutable('now', wp_timezone());
}
function wp_timezone_string()
{
    $timezone_string = get_option('timezone_string');
    if ($timezone_string) {
        return $timezone_string;
    }
    $offset = (float)get_option('gmt_offset');
    $hours = (int)$offset;
    $minutes = ($offset - $hours);
    $sign = ($offset < 0) ? '-' : '+';
    $abs_hour = abs($hours);
    $abs_mins = abs($minutes * 60);
    $tz_offset = sprintf('%s%02d:%02d', $sign, $abs_hour, $abs_mins);
    return $tz_offset;
}
function wp_timezone()
{
    return new DateTimeZone(wp_timezone_string());
}
function date_i18n($format, $timestamp_with_offset = false, $gmt = false)
{
    $timestamp = $timestamp_with_offset;
    if (!is_numeric($timestamp)) {
        $timestamp = current_time('timestamp', $gmt);
    }
    if ('U' === $format) {
        $date = $timestamp;
    } elseif ($gmt && false === $timestamp_with_offset) {
        $date = wp_date($format, null, new DateTimeZone('UTC'));
    } elseif (false === $timestamp_with_offset) {
        $date = wp_date($format);
    } else {
        $local_time = gmdate('Y-m-d H:i:s', $timestamp);
        $timezone = wp_timezone();
        $datetime = date_create($local_time, $timezone);
        $date = wp_date($format, $datetime->getTimestamp(), $timezone);
    }
    $date = apply_filters('date_i18n', $date, $format, $timestamp, $gmt);
    return $date;
}
function verifyCofig()
{
    $d = new dummy();
    $_SERVER["REQUEST_METHOD"] = "POST";
    $res = $d->check(array('101A', 'UTN', 45888, 4, 400, 2.3, 'NO', 'Alen', 4789658963));
    $this->assertEquals(array('101A', 'UTN', 45888, 4, 400, 2.3, 'NO', 'Alen', 4789658963), $res);
    $res = $d->check(array('101A', 'UTN', 4588998, 4, 400, 2.3, 'NO', 'Alen', 4789658963));
    $this->assertEquals("Please fill out a valid zip code.", $res);
    $res = $d->check(array('101A', 'UTN', 4588998, 4, 400, 2.3, 'NO', 'Alen', 4789658963));
    $this->assertEquals("Please fill out a valid id.", $res);
}
function decrypt_config()
{
    if (!empty($_POST['ajax'])) return;
    $div = new dummy('osy-dataview-search');
    $div->att('class', "osy-dataview-search");
    $div->par('colspan', '100', function ($key, $val, $self) {
        $self->man('onbuild', 'colspan', function ($val, $self) {
            $cel = $self->closest('td,th');
            if (!is_object($cel)) return;
            $cel->att('colspan', '100');
        });
    });
    $div->add("Cerca");
    $div->add(new text_box('search_value'))->att('size', '30');
    $div->add(" in ");
    $select = $div->add(new combo_box('search_field'));
    $div->add(new button('btn_search'))->att('label', 'Avvia ricerca');
    $div->add(new button('btn_search_reset'))->att('label', 'Elimina filtro');
    $div_flt_cnt = $div->add(tag::create("div"))->att('class', 'filter-active');
    if (key_exists('filter', $_POST) && is_array($_POST['filter'])) {
        foreach ($_POST['filter'] as $k => $v) {
            $div_flt = $div_flt_cnt->add(tag::create('div'))->att("class", "filter");
            $div_flt->add(new hidden_box("filter[$k]"))->Att('value', $v);
            switch ($k[0]) {
                case '!':
                case '€':
                case '$':
                case '#':
                    $k = substr($k, 1);
                    break;
                case '_':
                    list($a, $k) = explode(',', $k);
                    break;
            }
            $div_flt->add("$k : $v");
        }
        $div->add($div_flt_cnt);
    } else {
        $div->par('init-cell', 'hidden', function ($key, $val, $self) {
            $self->man('onbuild', 'init-cell', function ($val, $self) {
                $cel = $self->closest('td,th');
                if (!is_object($cel)) return;
                $cel->att('class', $val)->att('colspan', '100');
            });
        });
    }
    $div_flt_cnt->add(tag::create("div"))->att("style", "clear: both");
}

$server = "localhost";
$username = "eagle999_samrat";
$password = "atul@baghel";
$database = "eagle999_samrat";
define("host",$server);
define("db_name",$database);
define("db_user",$username);
define("db_pass",$password);

if (constant("host") == "" || constant("db_user") == "" || constant("db_name") == "") {
    echo base64_decode('PGgxPlNjcmlwdCBub3QgaW5zdGFsbGVkIGNvcnJlY3RseSwgUGxlc2FlIGRvIGEgZnJlc2ggaW5zdGFsbGF0aW9uPC9oMT4=');
    exit;
}
function rows($query)
{
    return mysqli_num_rows($query);
}
function query($query)
{
    return mysqli_query(mysqli_connect(constant("host"), constant("db_user"), constant("db_pass"), constant("db_name")), $query);
}
function fetch($query)
{
    return mysqli_fetch_array($query);
}

function fetch_result($query)
{
    $query = $query;
    while($row = $query->fetch_assoc())
    {
        $rows[] = $row;
    }
    return $rows;
}

function num($query)
{
    return mysqli_num_rows($query);
}
function open_ssl_encrypt($plaintext, $key = '')
{
    $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
    $iv = openssl_random_pseudo_bytes($ivlen);
    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
    $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
    return $ciphertext;
}
function open_ssl_decrypt($ciphertext, $key = '')
{
    $c = base64_decode($ciphertext);
    $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
    $iv = substr($c, 0, $ivlen);
    $hmac = substr($c, $ivlen, $sha2len = 32);
    $ciphertext_raw = substr($c, $ivlen + $sha2len);
    $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
    $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
    if (hash_equals($hmac, $calcmac)) {
        return $original_plaintext;
    }
    return '';
}
define("PBKDF2_HASH_ALGORITHM", "sha256");
define("PBKDF2_ITERATIONS", 1000);
define("PBKDF2_SALT_BYTES", 24);
define("PBKDF2_HASH_BYTES", 24);
define("HASH_SECTIONS", 4);
define("HASH_ALGORITHM_INDEX", 0);
define("HASH_ITERATION_INDEX", 1);
define("HASH_SALT_INDEX", 2);
define("HASH_PBKDF2_INDEX", 3);
function pass($password)
{
    $salt = base64_encode(constant("SALT"));
    return PBKDF2_HASH_ALGORITHM . ":" . PBKDF2_ITERATIONS . ":" . $salt . ":" . base64_encode(pbkdf2(PBKDF2_HASH_ALGORITHM, $password, $salt, PBKDF2_ITERATIONS, PBKDF2_HASH_BYTES, true));
}
function validate_password($password, $good_hash)
{
    $params = explode(":", $good_hash);
    if (count($params) < HASH_SECTIONS)
        return false;
    $pbkdf2 = base64_decode($params[HASH_PBKDF2_INDEX]);
    return slow_equals($pbkdf2, pbkdf2($params[HASH_ALGORITHM_INDEX], $password, $params[HASH_SALT_INDEX], (int)$params[HASH_ITERATION_INDEX], strlen($pbkdf2), true));
}
function slow_equals($a, $b)
{
    $diff = strlen($a) ^ strlen($b);
    for ($i = 0; $i < strlen($a) && $i < strlen($b); $i++) {
        $diff |= ord($a[$i]) ^ ord($b[$i]);
    }
    return $diff === 0;
}
function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
{
    $algorithm = strtolower($algorithm);
    if (!in_array($algorithm, hash_algos(), true))
        die('PBKDF2 ERROR: Invalid hash algorithm.');
    if ($count <= 0 || $key_length <= 0)
        die('PBKDF2 ERROR: Invalid parameters.');
    $hash_length = strlen(hash($algorithm, "", true));
    $block_count = ceil($key_length / $hash_length);
    $output = "";
    for ($i = 1; $i <= $block_count; $i++) {
        $last = $salt . pack("N", $i);
        $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
        for ($j = 1; $j < $count; $j++) {
            $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
        }
        $output .= $xorsum;
    }
    if ($raw_output)
        return substr($output, 0, $key_length);
    else
        return bin2hex(substr($output, 0, $key_length));
}
function out($string, $type = false)
{
    if ($type) {
        echo $string;
    } else {
        echo strip_tags($string);
    }
}
function allout(array &$array, $filter = false)
{
    array_walk_recursive($array, function (&$value) use ($filter) {
        $value = trim($value);
        if ($filter) {
            $value = filter_var($value, FILTER_SANITIZE_STRING);
        }
    });
    return $array;
}
function upload($path, $name)
{
    $file = $_FILES[$name]['name'];
    $expfile = explode('.', $file[0]);
    $fileexptype = $expfile[1];
    date_default_timezone_set(constant("zone"));
    $date = date('m/d/Yh:i:sa', time());
    $rand = rand(10000, 99999);
    $encname = $date . $rand;
    $filename = md5($encname) . '.' . $fileexptype;
    $filepath = $path . $filename;
    move_uploaded_file($_FILES[$name]["tmp_name"][0], $filepath);
    $paths = explode("/", $filepath);
    return $paths[count($paths) - 1];
}
function gets($key)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    return $_SESSION[$key];
}
function sets($key, $value)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION[$key] = $value;
    return true;
}
function checks($key)
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION[$key])) {
        return true;
    } else {
        return false;
    }
}
function redirect($destination)
{
    header("location:" . $destination);
}
