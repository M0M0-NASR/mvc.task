<body>

    <?= isset($_SESSION['msg']) ? $_SESSION['msg'] : '' ?>
    <form method="post" action="home/upload" enctype="multipart/form-data">
        <input type="file" name="csvFile">
        <input type="submit" value="Upload">
    </form>
</body>