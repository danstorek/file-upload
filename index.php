<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Upload souboru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
<h2>Na server lze vkládat pouze soubory s příponami .jpg, .jpeg, .png, .mp4, .mp3</h2>
<h2>Soubory musí být menší než 8MB</h2>
<?php
//var_dump($_POST);
//var_dump($_FILES);


if ($_FILES) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES['uploadedName']['name']);
    $fileType = strtolower( pathinfo( $targetFile, PATHINFO_EXTENSION ) );

    $uploadSuccess = true;

    if ($_FILES['uploadedName']['error'] != 0) {
        echo "Chyba serveru při uploadu";
        $uploadSuccess = false;

    }

    elseif (file_exists($targetFile)) {
        echo "Soubor již existuje";
        $uploadSuccess = false;
    }

    elseif ($_FILES['uploadedName']['size'] > 8000000) {
        echo "Soubor je příliš velký";
        $uploadSuccess = false;
    }

    elseif ($fileType !== "jpg" && $fileType !== "png" && $fileType !== "jpeg" && $fileType !== "mp4" && $fileType !== "mp3") {
        echo "Soubor má špatný typ";
        $uploadSuccess = false;
    }


    if ( !$uploadSuccess) {
        echo "Došlo k chybě uploadu";
    } else {
        //OK
        if (move_uploaded_file($_FILES['uploadedName']['tmp_name'], $targetFile)) {
            //echo "Soubor '". basename($_FILES['uploadedName']['name']) . "' byl uložen.";

            //Obrazek
            if($fileType === "jpg" || $fileType === "png" || $fileType === "jpeg")
            {
                echo '<img src="'.$targetFile.'" alt="Nahrany soubor">';
            }

            //Video
            elseif($fileType === "mp4")
            {
                echo '<video controls><source src="'.$targetFile.'" type="video/mp4">Your browser does not support the video tag.</video>';
            }

            //Zvuk
            elseif($fileType === "mp3")
            {
                echo '<audio controls><source src="'.$targetFile.'" type="audio/mpeg">Your browser does not support the audio element.</audio>';
            }
        } else {
            echo "Došlo k chybě uploadu";
        }
    }

}

?>
<form method='post' action='' enctype='multipart/form-data'><div class="mb-3">
        <label for="formFile" class="form-label">Vyber soubor:</label>
        <input class="form-control" name="uploadedName" type="file" id="formFile" accept=".jpg,.png,.jpeg,.mp4,.mp3"></br>
        <input type="submit" value="Nahrát" name="submit" />
    </div></form>
</body>
</html>