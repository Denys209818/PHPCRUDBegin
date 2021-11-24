<?php
include 'Database/database.php';
$fileOld = "";
$idProduct = 0;
if($_SERVER["REQUEST_METHOD"] == "POST")
{

    $name = $_POST["name"];
    $desc = $_POST["description"];
    $id = $_POST["id"];
    $old= $_POST["old"];

    $path = $_POST["oldImage"];
    if(!empty($_FILES["image"])) {
        $imageExt = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $path= uniqid() . ".{$imageExt}";
        move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/images/' . $path);

        if(!empty($old) && $old != '/')
        {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/images/' . $old);
        }
    }

    $sql = "UPDATE `news` SET `Name` = '$name', `Description` = '$desc', `Image` = '$path' WHERE `Id` = ". $id;
    //echo $sql;
    $dbo->query($sql);
}
else if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $idProduct = $_GET["Id"];

    $getRequest = "SELECT `Name`, `Description`, `Image` FROM `news` WHERE `Id` = ".$idProduct;
    $data = $dbo->query($getRequest);

    $element = $data->fetchAll()[0];
    $fileOld = $element["Image"];
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Новини</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<?php include 'Navbar/navbar.php'?>
<div class="container">
    <div class="row">
        <div class="offset-2 col-md-8 mt-3">
            <h1 class="text-center">Редагувати новину</h1>
            <form enctype="multipart/form-data" method="post">
                <input class="d-none" type="text" id="id" name="id" value=<?= $idProduct ?> />
                <input class="d-none" type="text" id="old" name="old" value=<?= $fileOld ?> />
                <input class="d-none" type="text" id="oldImage" name="oldImage" value=<?= $element["Image"] ?> />
                <div class="form-group mb-3">
                    <label class="form-label" for="name">Заголовок</label>
                    <input type="text" id="name" value=<?= $element["Name"]?> name="name" class="form-control"/>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label" for="description">Опис</label>
                    <input type="text" id="description" value=<?= $element["Description"]?> name="description" class="form-control"/>
                </div>
                <div class="form-group mb-3 d-flex justify-content-center">
                    <label class="form-label" for="image">
                        <img width="120" id="imageLab" src="<?= empty($element["Image"]) ?
                            "https://www.pngfind.com/pngs/m/66-661092_
                            png-file-upload-image-icon-png-transparent-png.png" : "Images/". $element["Image"]?>" />
                    </label>
                    <input type="file" id="image" name="image" class="form-control d-none"/>
                </div>
                <button class="btn btn-success" id="btnSubmit" type="submit">Змінити</button>
            </form>
        </div>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/axios.min.js"></script>
<script type="text/javascript">
    window.addEventListener("load", function () {
        var name = document.getElementById("name");
        var desc = document.getElementById("description");
        var image = document.getElementById("image");
        var id = document.getElementById("id");
        var old = document.getElementById("old");
        var oldImage = document.getElementById("oldImage");

        name.addEventListener("focus", function (e) {
            name.classList.remove('is-invalid');
        });
        desc.addEventListener("focus", function (e) {
            desc.classList.remove('is-invalid');
        });

        image.addEventListener("change", function(e) {
            var file = e.target.files[0];

            if(file) {
                var blob = URL.createObjectURL(file);
                document.getElementById("imageLab").src = blob;
            }
        });

        var btnSubmit = document.getElementById("btnSubmit");
        btnSubmit.addEventListener("click", function(e) {
            e.preventDefault();
            if(!name.value)
            {
                name.classList.add('is-invalid');
                return;
            }
            if(!desc.value)
            {
                desc.classList.add('is-invalid');
                return;
            }

            const data = new FormData();
            data.append('name', name.value);
            data.append('description', desc.value);
            data.append('image', image.files[0]);
            data.append('id', id.value);
            data.append('old', old.value);
            data.append('oldImage', oldImage.value);

            axios.post('/Edit.php',data, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            }).then(resp => {
                location.replace('/');
            });
        });
    });
</script>
</body>
</html>