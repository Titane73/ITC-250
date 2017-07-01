<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/temp_style.css"/>
    </head>
    <body>
        <form action="." method="post">
            <h1>Temperature Converter</h1>
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
            
            <h3><?php echo $message; ?></h3>
            
            <input type="submit" name="Submit" value="Convert">
            
            <br /><br /><button type="button"><a href="https://docs.google.com/document/d/1QH4H96UAvx4-p0w3csVmFJXbdRYrMBXjUvs-e50RMa8/edit?usp=sharing">Click to View Web Log</a></button>
        </form>   
    </body>
</html>