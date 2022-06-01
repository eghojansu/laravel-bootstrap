<?php

use App\Services\Preference;

/** Check if current environment is development */
function is_dev(): bool {
    return in_array(env('APP_ENV', 'production'), array('local', 'dev', 'development'));
}

/** Return $class if $route match current request route */
function clsa(string $route, string $class = null): string|null {
    return request()->routeIs($route) ? ($class ?? 'active') : null;
}

/** Return $class if $path match current request path  */
function clsu(string $path, string $class = null): string|null {
    return request()->is($path) ? ($class ?? 'active') : null;
}

/** Render element $attrs */
function clsr(array $attrs): string|null {
    $str = '';
    $arr = static function(string $prop, array $value) {
        $line = '';

        if ('class' !== $prop) {
            array_walk($value, static function ($value, $key) use ($prop, &$line) {
                $line .= ' data-' . $prop . '-' . $key . '=' . $value;
            });

            return $line;
        }

        array_walk($value, static function ($value, $key) use (&$line) {
            if (is_numeric($key)) {
                $line .= ' ' . $value;
            } elseif ($value) {
                $line .= ' ' . $key;
            }
        });

        return $line ? ' class="' . trim($line) . '"' : null;
    };

    foreach ($attrs as $prop => $value) {
        $val = is_callable($value) ? $value() : $value;

        if (null === $val || false === $val) {
            continue;
        }

        if (is_numeric($prop)) {
            $str .= ' ' . $val;
        } elseif (true === $val) {
            $str .= ' ' . $prop;
        } elseif (is_array($val)) {
            $str .= $arr($prop, $val);
        } else {
            $str .= ' ' . $prop . '="' . $val . '"';
        }
    }

    return $str;
}

/** Collect renamed and ignored $source data */
function cdata(array $source, array $renames = null, array $ignores = null): array {
    $data = array_diff_key($source, array_flip($ignores ?? array()));

    array_walk($renames, static function (string $key, string $rename) use (&$data) {
        $data[$rename] = $data[$key];

        unset($data[$key]);
    });

    return $data;
}

/** Get $class name without namespace prefixed */
function cname(string $class): string {
    return ltrim(strrchr('\\' . $class, '\\'), '\\');
}

/** Get $class constansts filtered by optional $prefix */
function cconst(string|object $class, string $prefix = null): array {
    $const = (new ReflectionClass($class))->getConstants();

    return $prefix ? array_filter(
        $const,
        static fn (string $name) => str_starts_with($name, $prefix),
        ARRAY_FILTER_USE_KEY,
    ) : $const;
}

/** Get classes from $directory */
function cloads(string $dir, string $namespace = null): array {
    return array_map(
        static fn (string $file) => $namespace . '\\' . basename($file, '.php'),
        glob($dir . '/*.php'),
    );
}

/** Format $input date */
function cdt(DateTime $input, string $format = null): string {
    $fmt = $format ?? app(Preference::class)->dtFmt;

    return $input->format($fmt);
}

/** Format $input datetime */
function cdtime(DateTime $input, string $format = null): string {
    $fmt = $format ?? app(Preference::class)->dtimeFmt;

    return $input->format($fmt);
}

/** Format $input timestamp */
function cts(DateTime $input, string $format = null): string {
    $fmt = $format ?? app(Preference::class)->tsFmt;

    return $input->format($fmt);
}
