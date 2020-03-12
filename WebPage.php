<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Test</title>

    <link rel="stylesheet" href="bootstrap.min.css?v=1.0">

</head>

<body>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Список персон максимального возраста (<?=$max_age?>)</h5>
    </div>
</div>

<div class="col-md-10">
    <div class="row">
        <div class="col-lg-12">

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Фамилия</th>
                    <th scope="col">Имя</th>
                    <th scope="col">Возраст</th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($persons_list as $person) {
                    echo "
                    <tr>
                    <th>{$person->lastname}</th>
                    <td>{$person->firstname}</td>
                    <td>{$person->age}</td>
                    </tr>
                    ";
                }
                ?>

                </tbody>
            </table>

        </div>
    </div>
</div>
</body>
</html>