<?php

namespace backend\components;

use Dotenv\Dotenv;
use Yii;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class Vite
{
    private const DEV_SERVER_HOST_DEFAULT = '127.0.0.1';
    private const DEV_SERVER_PORT_DEFAULT = 5173;

    private static $devServer;

    /**
     * Получает адрес DEV_SERVER.
     *
     * @return string
     */
    private static function getDevServer(): string
    {
        if (self::$devServer === null) {
            self::$devServer = $_ENV['VITE_DEV_SERVER'] ?: self::DEV_SERVER_HOST_DEFAULT . ':' . self::DEV_SERVER_PORT_DEFAULT;
        }

        return self::$devServer;
    }

    /**
     * Проверяет доступен ли DEV_SERVER.
     *
     * @return bool
     */
    public static function isDev(): bool
    {
        $url = parse_url(self::getDevServer());
        $host = $url['host'] ?? self::DEV_SERVER_HOST_DEFAULT;
        $port = $url['port'] ?? self::DEV_SERVER_PORT_DEFAULT;
        $fp = @fsockopen($host, $port, $errno, $errstr, 0.05);

        if ($fp) {
            fclose($fp);
            return true;
        }

        return false;
    }

    /**
     * Рендерит скрипты.
     *
     * @param  string  $entry
     * @return string
     */
    public static function render(string $entry = 'src/main.js'): string
    {
        $devServer = self::getDevServer();

        if (self::isDev()) {
            return implode(PHP_EOL, [
                '<script type="module" src="' . $devServer . '/@vite/client"></script>',
                '<script type="module" src="' . $devServer . '/' . ltrim($entry, '/') . '"></script>',
            ]);
        }

        $manifestPath = Yii::getAlias('@backend') . '/web/src/.vite/manifest.json';
        if (!file_exists($manifestPath)) {
            return '';
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);
        if (!isset($manifest[$entry])) {
            return '';
        }

        $item = $manifest[$entry];
        $tags = [];

        if (!empty($item['css'])) {
            foreach ($item['css'] as $css) {
                $tags[] = '<link rel="stylesheet" href="' . Yii::getAlias('@web') . '/src/' . ltrim($css, '/') . '">';
            }
        }

        $tags[] = '<script type="module" src="' . Yii::getAlias('@web') . '/src/' . ltrim($item['file'], '/') . '"></script>';

        return implode(PHP_EOL, $tags);
    }
}
