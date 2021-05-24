<?php


namespace JsBuilder\DevExtreme;


class DevExtreme
{
    private static string $theme = DxThemes::Light;
    private static string $version = "20.2.7";
    public static string $lang = "en";
    private static array $DevExtremeGridLibs = array(
        "https://cdn3.devexpress.com/jslib/{{version}}/css/dx.common.css",
        "https://cdn3.devexpress.com/jslib/{{version}}/js/dx.all.js",
    );

    private static function GenerateJavaScriptLibrary(array $libraries): string
    {
        array_unshift($libraries, "https://code.jquery.com/jquery-3.5.1.min.js");
        $headString = "";
        foreach ($libraries as $value) {
            $template = "";
            if (strpos($value, ".js")) {
                $template = ' <script type="text/javascript" src="{{link}}"></script>' . PHP_EOL;
            } else {
                $template = ' <link rel="stylesheet" href="{{link}}">' . PHP_EOL;
            }

            $headString = $headString . str_replace("{{link}}", $value, $template);
        }

        return $headString;
    }

    public static function GetJavaScriptLibrary(): string
    {
        array_push(self::$DevExtremeGridLibs, self::$theme);
        array_push(self::$DevExtremeGridLibs, "https://cdn3.devexpress.com/jslib/{{version}}/js/localization/dx.messages." . self::$lang . ".js");

        foreach (self::$DevExtremeGridLibs as $key => $item) {
            self::$DevExtremeGridLibs[$key] = str_replace("{{version}}", self::$version, $item);
        }
        return self::GenerateJavaScriptLibrary(self::$DevExtremeGridLibs);
    }

    public static function SetLang(string $lang)
    {
        self::$lang = $lang;
        return new self();
    }

    public static function SetVersion(string $version = "20.2.7")
    {
        if (is_string($version))
            self::$version = $version;
        return new self();
    }

    public static function SetTheme(string $theme = '')
    {
        if (!is_null($theme) && !empty(trim($theme)))
            self::$theme = $theme;
        return new self();
    }
}