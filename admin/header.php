<!---------- style starts here    ------->
<style>
   html, body {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

*, *::before, *::after {
    box-sizing: inherit;
}

html {
    box-sizing: border-box;
}

nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    background-color: black;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    width: 100%;
    margin: 0;
}

nav a {
    height: 100%;
    color: white;
    text-decoration: none;
}

nav a:hover {
    color: gold;
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

ul img {
    margin-right: 10px;
    width: 100px;
}

li {
    margin-right: 20px;
}

form {
    display: flex;
    align-items: center;
    margin-right: 15px;
}

input[type="text"] {
    padding: 10px;
    border: none;
    border-radius: 5px 0 0 5px;
}

button[type="submit"] {
    padding: 10px 20px;
    background-color: #333;
    color: white;
    border: none;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: gold;
}

@media screen and (max-width: 768px) {
    nav {
        flex-direction: column;
        align-items: flex-start;
    }

    ul {
        margin-bottom: 20px;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    li {
        margin-right: 0;
        margin-bottom: 10px;
    }

    form {
        display: flex;
        align-items: center;
        width: 100%;
        justify-self: start;
    }

    input[type="text"] {
        width: 100%;
    }
}

</style>


<?php
session_start();
?>
<!-- navigation bar  -->
<nav>
    <ul> 
        <img src="../images/logo/today bulletin india.jpeg" alt="logo">
        <li><a href="../index.php">Home</a></li>
        <li><a href="../news.php">News</a></li>
        <li><a href="../about.php">About</a></li>
    </ul>
    <form action="search.php" method="GET">
    <input type="text" name="query" placeholder="Search news..." required>
    <button type="submit">Search</button>
</form>
</nav>
<!-- Header Content -->


<!-- <nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php // if (isset($_SESSION['user_id'])): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php // else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php // endif; ?>
    </ul>
</nav> -->
