<!-- styles for footer  -->

<style>
      footer {
        background-color: black;
        color: white;
        padding: 20px;
        text-align: center;
        margin-top: 50px;
        font-size: 14px;
        line-height: 1.5;
        box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
    margin-top: 35vh;
        
    }
    footer a {
        color: gold;
        text-decoration: none;
        margin: 0 10px;
        font-weight: bold;
        transition: color 0.3s ease;

    }

    footer img {
        width: 200px;
        margin-bottom: 20px;
        margin-top: 10px;
    }
</style>
<!-- Footer Content -->
<footer>
    <!-- logo  -->
    <img src="../images/logo/today bulletin india.jpeg" alt="logo">
    <!-- Search Form -->
    <form action="search.php" method="GET">
        <input type="text" name="query" placeholder="Search news..." required>
        <button type="submit">Search</button>
    </form>
    <p>&copy; <?php echo date("Y"); ?> News Bulletin India. All rights reserved.</p>
    <p>Follow us on:
        <a href="https://www.facebook.com/ameer.alamaron" target="_blank">Facebook</a> |
        <a href="https://github.com/ameeralam82/" target="_blank">GitHub</a> |
        <a href="edin.com/in/ameer-alam-aron-9a66317b/" target="_blank">LinkedIn</a>
    </p>

</footer>

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=YOUR_TRACKING_ID"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'YOUR_TRACKING_ID');
</script>
