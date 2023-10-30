<!DOCTYPE html>
<html>
<head>
    <title>Comres images</title>
</head>
<body>
    <?php
    if (isset($_POST['submit'])) {
        $directory_name = 'C:\xampp\htdocs\Image optimizer\Image upload\\';

        foreach ($_FILES['images']['name'] as $key => $image_name) {
            $tmp_name = $_FILES['images']['tmp_name'][$key];

            if (empty($image_name)) {
                continue; // Dacă utilizatorul nu a ales o imagine, trecem la următoarea
            }

            $file_name = $directory_name . $image_name;
            move_uploaded_file($tmp_name, $file_name);

            $compress_file = "compress_" . $image_name;
            $compressed_img = $directory_name . $compress_file;
            $compress_image = compressImage($file_name, $compressed_img);
            unlink($file_name);

            // Afișăm imaginile comprimate
            echo '<img src="' . $compress_image . '" style="max-width: 300px;"><br>';
        }
    }

    function compressImage($source_image, $compress_image)
    {
        $image_info = getimagesize($source_image);
        if ($image_info['mime'] == 'image/jpeg') {
            $source_image = imagecreatefromjpeg($source_image);
            imagejpeg($source_image, $compress_image, 35);
        } elseif ($image_info['mime'] == 'image/png') {
            $source_image = imagecreatefrompng($source_image);
            imagepng($source_image, $compress_image, 6);
        }
        return $compress_image;
    }
    ?>

    <form method="post" action="comres.php" enctype="multipart/form-data">
        <input type="file" name="images[]" accept="image/*" multiple>
        <input type="submit" value="Upload" name="submit">
    </form>
</body>
</html>
