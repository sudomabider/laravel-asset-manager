<?php
/**
 * Created by PhpStorm.
 * User: veoc
 * Date: 31/08/16
 * Time: 4:53 PM.
 */

namespace Sudomabider\AssetManager;

class AssetManager
{
    private $assets;

    /**
     * AssetManager constructor.
     *
     * @param $assets
     */
    public function __construct($assets)
    {
        $this->assets = $assets;
    }

    public function css(...$libs)
    {
        $html = '';
        foreach ($libs as $lib) {
            $html .= $this->makeCssLib($lib);
        }

        return $html;
    }

    public function js(...$libs)
    {
        $html = '';
        foreach ($libs as $lib) {
            $html .= $this->makeJsLib($lib);
        }

        return $html;
    }

    /**
     * @param $lib
     *
     * @return string
     */
    protected function makeCssLib($lib)
    {
        $html = '';

        if (ends_with($lib, '.css')) {
            return $this->generateCssLink($lib);
        }

        if (!isset($this->assets[$lib]['css'])) {
            return $html;
        }

        $css = $this->assets[$lib]['css'];
        if (is_array($css)) {
            foreach ($css as $path) {
                $html .= $this->generateCssLink($path);
            }
        } else {
            $html = $this->generateCssLink($css);
        }

        return $html;
    }

    /**
     * @param $lib
     *
     * @return string
     */
    protected function makeJsLib($lib)
    {
        if (ends_with($lib, '.js')) {
            return $this->generateJsLink($lib);
        }

        if (!isset($this->assets[$lib]['js'])) {
            return '';
        }

        $js = $this->assets[$lib]['js'];

        if (is_array($js)) {
            $html = '';

            foreach ($js as $asset) {
                $html .= $this->parseJsAsset($asset);
            }
        } else {
            $html = $this->generateJsLink($js);
        }

        return $html;
    }

    protected function parseJsAsset($asset)
    {
        if (!is_array($asset)) {
            return $this->generateJsLink($asset);
        }

        if (isset($asset[1]) and is_array($asset[1])) {
            return $this->generateJsLink($asset[0], $asset[1]);
        }
    }

    protected function generateCssLink($url, array $options = [])
    {
        $url = $this->generateAbsoluteUrl($url);

        return "<link rel='stylesheet' type='text/css' href='$url'/>\n";
    }

    protected function generateJsLink($url, array $options = [])
    {
        $url = $this->generateAbsoluteUrl($url);

        if (!$options) {
            return "<script type='text/javascript' src='$url'></script>\n";
        }

        $options_html = '';
        foreach ($options as $key => $value) {
            $options_html .= ' '.$key."='".$value."'";
        }

        if (!array_key_exists('type', $options)) {
            $options_html .= " type='text/javascript'";
        }

        return '<script'.$options_html." src='$url'></script>\n";
    }

    protected function generateAbsoluteUrl($url)
    {
        if (starts_with($url, ['http://', 'https://', '//'])) {
            return $url;
        }

        return url($url);
    }
}
