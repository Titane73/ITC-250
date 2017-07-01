<?php
    //temp_converter.php
    

    define('THIS_PAGE',basename($_SERVER['PHP_SELF']));

    if(isset($_POST["Submit"]))
    {//show data
        $temp = $_POST ['Temp'];
        $choice = $_POST ['Conversion'];

        if(!empty($temp) || is_numeric($temp) || $temp = 0)
        {
            // Convert F to C
        function convertfc ($temp){
            $value = 5/9 * ($temp - 32);
            $value_f = number_format($value, 2);       
            return $value_f;
        }

            // Convert C to F
        function convertcf ($temp){
            $value = (9/5 * $temp) + 32;
            $value_f = number_format($value, 2);       
            return $value_f;
        }

            // Convert F to K
        function convertfk ($temp){
            $value = 5/9 * ($temp - 32) + 273.15;
            $value_f = number_format($value, 2);       
            return $value_f;
        }

        // Convert K to F
        function convertkf ($temp){
            $value = ($temp - 273.15) * 9/5 + 32;
            $value_f = number_format($value, 2);       
            return $value_f;
        }

        // Convert C to K
        function convertck ($temp){
            $value = $temp + 273.15;
            $value_f = number_format($value, 2);       
            return $value_f;
        }

        // Convert K to C
        function convertkc ($temp){
            $value = $temp - 273.15;
            $value_f = number_format($value, 2);       
            return $value_f;
        }
        }else{
            $message = 'You must enter a numeric value!';
        }                    

        switch ($choice)
        {
            case "FtoC":
                $message = number_format($temp, 2) . '&deg Fahrenheit = ' . convertfc($temp) . '&deg Celsius.';
                break;

            case "CtoF":
                $message = number_format($temp, 2) . '&deg Celsius = ' . convertcf($temp) . '&deg Fahrenheit.';
                break;

            case "FtoK":
                $message = number_format($temp, 2) . '&deg Fahrenheit = ' . convertfk($temp) . '&deg Kelvin.';
                break;

            case "KtoF":
                $message = number_format($temp, 2) . '&deg Kelvin = ' . convertkf($temp) . '&deg Fahrenheit.';
                break;

            case "CtoK":
                $message = number_format($temp, 2) . '&deg Celsius = ' . convertck($temp) . '&deg Kelvin.';
                break;

            case "KtoC":
                $message = number_format($temp, 2) . '&deg Kelvin = ' . convertkc($temp) . '&deg Celsius.';
                break;

            default:
                $message = 'You must select a conversion type!';
                break;
        }        
    }
include 'temp_converter1.php';
?>