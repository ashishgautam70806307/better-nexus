<?php
namespace App\Rules;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
class SafeWebsiteLink implements ValidationRule
{
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail,
    ): void {
        if (!is_string($value) || preg_match('/[\x00-\x20\\\\]/', $value)) {
            $fail("Use a local path or a valid HTTPS URL without spaces.");
            return;
        }
        $local = str_starts_with($value, "/") && !str_starts_with($value, "//");
        $external =
            filter_var($value, FILTER_VALIDATE_URL) &&
            strtolower(parse_url($value, PHP_URL_SCHEME) ?? "") === "https" &&
            !parse_url($value, PHP_URL_USER) &&
            !parse_url($value, PHP_URL_PASS);
        if (!$local && !$external) {
            $fail("Use a local path such as /services, or an HTTPS URL.");
        }
    }
}
