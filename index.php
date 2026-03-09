<?php 
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Today Bulletin India - Latest News and Updates</title>
    <meta name="description" content="Stay updated with the latest news and articles on Today Bulletin India. Find breaking news, top stories, and more.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="description" content="Stay updated with the latest news and articles on Today Bulletin India. Find breaking news, top stories, and more.">
    <meta name="keywords" content="news, updates, headlines, breaking news, latest news,modi ji news,modiji, today bulletin, today bulletin india, bulletin, bulletin india, bulletin today,ndtv,government,india,indian,indian news">
    <meta name="author" content="Gulzar Rehman">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="Today Bulletin India - Latest News and Updates">
    <meta property="og:description" content="Stay updated with the latest news and articles on Today Bulletin India. Find breaking news, top stories, and more.">
    <meta property="og:image" content="https://yourwebsite.com/path/to/image.jpg">
    <meta property="og:url" content="https://yourwebsite.com/news-article">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Today Bulletin India - Latest News and Updates">
    <meta name="twitter:description" content="Stay updated with the latest news and articles on Today Bulletin India. Find breaking news, top stories, and more.">
    <meta name="twitter:image" content="https://yourwebsite.com/image.jpg">
    
    <style>
        .ad-banner {
            margin-bottom: 20px;
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease-in-out;
        }

        .ad-banner:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }   

    </style>
    
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-XXXXXXXXXX');
    </script>
    
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', 'YOUR_PIXEL_ID');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=YOUR_PIXEL_ID&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->

</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
    <h1>Welcome to News Bulletin India</h1>

    <!-- Ad Banner -->
    <div class="ad-banner">
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-xxxxxxxxxxxxxxx"
             data-ad-slot="1234567890"
             data-ad-format="auto"></ins>
        <script>
             (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>

    <!-- Recent News Section -->
    <h2>News updates</h2>
    <div id="news-container"></div>
    <div id="loading" style="display: none;">Loading...</div>
    <div class="loadbtn" style="width: 100%; text-align: center; display: none; justify-content: center; align-items: center;margin-top: 100px" ><button style=" font-size: 30px width: 50%; text-align: center; margin-top: 10px; margin-bottom: 10px; padding: 20px; background-color: black; color: gold; border: none; border-radius: 20px; " onclick="loadNews() ">Load More</button></div>
    <div id="no-more-news" style="display: none;">No more news right now</div>
    </div>
    <div id="privacy-popup" class="privacy-popup">
    <p>
        We use cookies to improve your experience on our website and to analyze our traffic using Google Analytics. By continuing to use our site, you agree to our Privacy Policy.
    </p>
    <button id="accept-btn">Accept</button>
</div>

    <?php include 'footer.php'; ?>

    <script>
        loadbtn = document.querySelector('.loadbtn');
    $(document).ready(function() {
        let offset = 0;
        const limit = 5;
        let loading = false;
        let hasMore = true;

        function loadNews() {
            if (loading || !hasMore) return;
            loading = true;
            $('#loading').show();
            $('#no-more-news').hide();

            $.ajax({
                url: 'load_more_news.php',
                type: 'POST',
                data: { offset: offset },
                dataType: 'json',
                success: function(response) {
                    if (response.news.length > 0) {
                        response.news.forEach(news => {
                            let newsHtml = `<div class='news-article'>
                                <h3><a href='news.php?id=${news.id}'>${news.title}<div class='news-article-img'><img src='${news.image}' alt='News Image' ></div></a></h3>`;
                            // if (news.image) {
                            //     newsHtml += `<img src='${news.image}' alt='News Image' >`;
                            // }
                            newsHtml += `<p><strong>Posted on:</strong> ${news.created_at} ${news.time} by ${news.id}</p>
                                <p>${news.content.substr(0, 200)}...</p>
                            </div>`;
                            $('#news-container').append(newsHtml);
                        });
                        offset += limit;
                        hasMore = response.hasMore;
                    } else {
                        $('#no-more-news').show();
                    }
                    $('#loading').hide();
                    loading = false;
                }
            });
        }

        // Initial load
        loadNews();

        // Infinite scroll
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() == $(document).height()) {
                    loadbtn.style.display = 'block';
                    loadbtn.addEventListener('click', () => {
                    loadNews();
                });
                
            }
        });
    });


    window.addEventListener('load', function () {
    var popup = document.getElementById('privacy-popup');
    var acceptBtn = document.getElementById('accept-btn');

    // Check if the user has already accepted
    if (!localStorage.getItem('privacyAccepted')) {
        popup.classList.add('show');
    }

    acceptBtn.addEventListener('click', function () {
        localStorage.setItem('privacyAccepted', 'true');
        popup.classList.remove('show');
    });
});

    </script>
</body>
</html>
