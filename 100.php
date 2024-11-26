<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        $a=file_get_contents('https://translate.google.com/?hl=vi&sl=vi&tl=en&text=xinchao&op=translate');
        print_r($a);
    
    ?>
</body>
</html>