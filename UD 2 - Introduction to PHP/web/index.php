<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mi Presentación</title>
</head>

<body>
    <?php include_once "../header.inc.php"; ?>

    <section>
        <article>
            <p>
                Hello! My name is Gabi and I'm 21 years old. I'm a Web Applications Developer student and this is my "mini" portfolio.
            </p>
            <img src="./img/cabra.webp" alt="An image of a Goat" />
        </article>
    </section>

    <form action="#" method="post">
        <label for="name">Name</label>
        <input type="text" required name="name" id="name" />
        <br />
        <label for="last-name">Last Name</label>
        <input type="text" required name="last-name" id="last-name" />
        <br />
        <label for="email">Email</label>
        <input type="email" required name="email" id="email" />
    </form>
    </main>
    <?php include_once "../footer.inc.php"; ?>
</body>

</html>