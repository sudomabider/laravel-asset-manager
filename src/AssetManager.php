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
            $html .= $this->makeLibCss($lib);
        }

        return $html;
    }

    public function js(...$libs)
    {
        $html = '';
        foreach ($libs as $lib) {
            $html .= $this->makeLibJs($lib);
        }

        return $html;
    }

    /**
     * @param $lib
     * @return string
     */
    private function makeLibCss($lib):string
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
    private function makeLibJs($lib):string
    {
        $html = '';

        if (ends_with($lib, '.js')) {
            return "<script type='text/javascript' src='$lib'></script>\n";
        }

        if (!isset($this->assets[$lib]['js'])) {
            return $html;
        }

        $js = $this->assets[$lib]['js'];
        if (is_array($js)) {
            foreach ($js as $path) {
                $html .= "<script type='text/javascript' src='$path'></script>\n";
            }
        } else {
            $html = "<script type='text/javascript' src='$js'></script>\n";;
        }

        return $html;
    }
}