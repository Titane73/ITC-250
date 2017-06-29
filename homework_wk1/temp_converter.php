

<!doctype html>
<html>
    <head>
        <link rel="stylesheet" href="css/temp_style.css"/>
    </head>
    <body>
        <?php
            //temp_converter.php

            define('THIS_PAGE',basename($_SERVER['PHP_SELF']));

            if(isset($_POST["Submit"]))
            {//show data
                $temp = $_POST ['Temp'];
                $choice = $_POST ['Conversion'];

                if(empty($temp) || !is_numeric($temp))
                {
                    echo 'You must enter a numeric value!';
                }else{

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

                switch ($choice)
                {
                    case "FtoC":
                        echo $temp . '&deg Fahrenheit = ' . convertfc($temp) . '&deg Celsius.';
                        break;

                    case "CtoF":
                        echo $temp . '&degCelsius = ' . convertcf($temp) . '&deg Fahrenheit.';
                        break;

                    case "FtoK":
                        echo $temp . '&deg Fahrenheit = ' . convertfk($temp) . '&deg Kelvin.';
                        break;

                    case "KtoF":
                        echo $temp . '&deg Kelvin = ' . convertkf($temp) . '&deg Fahrenheit.';
                        break;

                    case "CtoK":
                        echo $temp . '&deg Celsius = ' . convertck($temp) . '&deg Kelvin.';
                        break;

                    case "KtoC":
                        echo $temp . '&deg Kelvin = ' . convertkc($temp) . '&deg Celsius.';
                        break;

                    default:
                        echo 'You must select a conversion type!';
                        break;
                }
                }
                echo '<br /><br /><button type="button"><a href="' . THIS_PAGE . '">Go Back For More</a></button>';
            }else{//show form
                echo '
                <form action="' . THIS_PAGE . '" method="post">
                    Number Of Degrees To Convert: <input type="text" name="Temp" /><br /><br />
                    <label>
                    Conversion Choices:<br />
                    <label><input type="radio" name="Conversion" value="FtoC" />Fahrenheit to Celsius</label><br />
                    <label><input type="radio" name="Conversion" value="CtoF" />Celsius to Fahrenheit</label><br /><br />
                    <label><input type="radio" name="Conversion" value="FtoK"/>Fahrenheit to Kelvin</label><br />
                    <label><input type="radio" name="Conversion" value="KtoF" />Kelvin to Fahrenheit</label><br /><br />
                    <label><input type="radio" name="Conversion" value="CtoK" />Celsius to Kelvin</label><br />
                    <label><input type="radio" name="Conversion" value="KtoC" />Kelvin to Celsius</label><br /><br />
                    </label>

                    <input type="submit" name="Submit" value="Convert">
                    <br /><br /><button type="button"><a href="https://docs.google.com/document/d/1QH4H96UAvx4-p0w3csVmFJXbdRYrMBXjUvs-e50RMa8/edit?usp=sharing">Click to View Web Log</a></button>
                </form>
                ';
            }
            ?>
    </body>
</html>