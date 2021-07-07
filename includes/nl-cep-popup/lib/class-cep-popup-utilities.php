<?php
namespace CEP_Popup\Utilites;

class CEP_Popup_Utilities
{
    public static function includeWithData(
        string $filePath,
        array $data = array(),
        bool $print = true
    ) {
        $output = NULL;
        if (file_exists($filePath)) {
            // Extract the variables to a local namespace
            extract($data);

            // Start output buffering
            ob_start();

            // Include the template file
            include $filePath;

            // End buffering and return its contents
            $output = ob_get_clean();
        }
        if ($print) {
            print $output;
        }
        return $output;
    }
}
