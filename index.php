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
  <?php include 'Modal/Modal.php'?>
  <?php
    include 'Database/database.php';
    $data = $dbo->query("SELECT * FROM `news`");
  ?>

  <div class="container">
      <div class="row">
          <div class="offset-2 col-md-8">
              <table class="table table-bordered table-striped mt-3">
                  <thead class="table-dark">
                  <tr>
                      <th>Id</th>
                      <th>Назва</th>
                      <th>Опис</th>
                      <th>Фотографія</th>
                      <th>Інструменти</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                        foreach ($data as $item)
                        {
                            echo "<tr>
                                <td>{$item["Id"]}</td>
                                <td>{$item["Name"]}</td>
                                <td>{$item["Description"]}</td>
                                <td>
                                    <img src='images/{$item["Image"]}' width='90' alt='no photo'/>
                                </td>
                                <td>
                                <div class='d-flex'>
                                    <a href='/Edit.php?Id={$item["Id"]}' class='btn btn-info' >Редагувати</a>
                                    <button class='btn btn-danger ms-1 deleteItem' data-id={$item["Id"]}>Видалити</button>
                                </div>
                                </td>
                            </tr>";
                        }
                    ?>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
  <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/axios.min.js"></script>
<script>
    window.addEventListener("load", function() {
        var items = document.getElementsByClassName('deleteItem');
        var deletedItem = 0;
        for(var i = 0; i < items.length; i++)
        {
            items[i].addEventListener("click", function(e) {
                deletedItem = e.target.getAttribute('data-id');
                var modal = new bootstrap.Modal(document.getElementById("myModal"));
                modal.show();
            });
        }

        var modalSub = document.getElementsByClassName('btnModalDelete')[0];
        modalSub.addEventListener("click", function ()
        {
            var data = new FormData();
            data.append("Id", deletedItem);
            axios.post('/Delete.php', data)
            .then(res => {
                location.reload();
            });
        })
    });
</script>
</body>
</html>