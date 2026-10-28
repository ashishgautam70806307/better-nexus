<?php
namespace App\Support;

use Illuminate\Support\Str;
use HTMLPurifier;
use HTMLPurifier_Config;

class BlogText
{
    public const MARKER = "<!--bn-rich-v1-->";

    public static function clean(string $html): string
    {
        static $purifier;
        if (!$purifier) {
            $config = HTMLPurifier_Config::createDefault();
            $config->set(
                "HTML.Allowed",
                "p[style|class],br,strong,b,em,i,u,s,strike,h2[style|class],h3[style|class],h4[style|class],blockquote,ul,ol,li,span[style|class],a[href|title],sub,sup,pre,code",
            );
            $config->set("CSS.AllowedProperties", [
                "color",
                "background-color",
                "text-align",
            ]);
            $config->set("Attr.AllowedClasses", [
                "ql-align-center",
                "ql-align-right",
                "ql-align-justify",
                "ql-size-small",
                "ql-size-large",
                "ql-size-huge",
            ]);
            $config->set("URI.AllowedSchemes", [
                "http" => true,
                "https" => true,
                "mailto" => true,
            ]);
            $config->set(
                "Cache.SerializerPath",
                storage_path("framework/cache"),
            );
            $purifier = new HTMLPurifier($config);
        }
        return $purifier->purify($html);
    }

    public static function html(?string $text): string
    {
        $text = $text ?? "";
        if (str_starts_with($text, self::MARKER)) {
            return self::clean(substr($text, strlen(self::MARKER)));
        }
        // Earlier articles remain Markdown until saved in the rich editor.
        return Str::markdown($text, [
            "html_input" => "strip",
            "allow_unsafe_links" => false,
        ]);
    }

    public static function plain(?string $text): string
    {
        return trim(
            html_entity_decode(
                str_replace(
                    ["&nbsp;", "&#160;"],
                    " ",
                    strip_tags(self::html($text)),
                ),
                ENT_QUOTES | ENT_HTML5,
                "UTF-8",
            ),
        );
    }

    public static function store(?string $html): string
    {
        return self::MARKER . self::clean($html ?? "");
    }
}
