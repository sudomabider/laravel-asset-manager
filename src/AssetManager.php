<?php
/**
 * Created by PhpStorm.
 * User: veoc
 * Date: 31/08/16
 * Time: 4:53 PM
 */

namespace Thesudoteam\AssetManager;


class AssetManager
{
    private $assets;

    /**
     * AssetManager constructor.
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
     * @return string
     */
    private function makeCssLib($lib):string
    {
        $html = '';

        if (ends_with($lib, '.css')) {
            return "<link rel='stylesheet' type='text/css' href='$lib'/>\n";
        }

        if (!isset($this->assets[$lib]['css'])) {
            return $html;
        }

        $css = $this->assets[$lib]['css'];
        if (is_array($css)) {
            foreach ($css as $path) {
                $html .= "<link rel='stylesheet' type='text/css' href='$path'/>\n";
            }
        } else {
            $html = "<link rel='stylesheet' type='text/css' href='$css'/>\n";
        }

        return $html;
    }

    /**
     * @param $lib
     * @return string
     */
    private function makeJsLib($lib):string
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

    private function parseJsAsset($asset)
    {
        if (! is_array($asset)) {
            return $this->generateJsLink($asset);
        }

        if (isset($asset[1]) AND is_array($asset[1])) {
            return $this->generateJsLink($asset[0], $asset[1]);
        }
    }

    private function generateJsLink($url, array $options = [])
    {
        if (! $options) {
            return "<script type='text/javascript' src='$url'></script>\n";
        }

        $options_html = '';
        foreach ($options as $key => $value) {
            $options_html .= " " . $key . "='" . $value . "'";
        }

        if (! key_exists('type', $options)) {
            $options_html .= " type='text/javascript'";
        }

        return "<script" . $options_html . " src='$url'></script>\n";
    }
}