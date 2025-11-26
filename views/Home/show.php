<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gio Task</title>

    <link rel="stylesheet" href=<?= $_REQUEST['url'] . "css/main.css" ?>>

</head>

<body>


    <table>
        <caption> Gio Task </caption>

        <thead>

            <?php foreach ($_SESSION['keys'] as $key): ?>
            <th> <?= $key; ?> </th>
            <?php endforeach; ?>

        </thead>

        <tbody>

            <?php foreach ($_SESSION['data'] as $record): ?>

            <tr class=<?= ($record[3][0] !== "-" ? "green" : "red"); ?>>

                <?php foreach ($record as $val): ?>
                <td>
                    <?= $val ?>
                </td>

                <?php endforeach; ?>

            </tr>

            <?php endforeach; ?>

        </tbody>

        <tfoot>

            <tr class=<?= ($_SESSION['income'][0] !== '-' ? "green" : "red") ?>>
                <td colspan=2></td>
                <td>Income:</td>
                <td><?= $_SESSION['income'] ?></td>
            </tr>

            <tr class=<?= ($_SESSION['expanse'][0] !== '-' ? "green" : "red") ?>>
                <td colspan=2></td>
                <td>Expanse:</td>
                <td><?= $_SESSION['expanse'] ?></td>
            </tr>

            <tr class=<?= ($_SESSION['netTotal'][0] !== '-' ? "green" : "red") ?>>
                <td colspan=2></td>
                <td>Net Total:</td>
                <td>
                    <?= $_SESSION['netTotal'] ?>
                </td>
            </tr>

        </tfoot>

    </table>

</body>

</html>