<!-- copyright -->

    <footer >
        <!-- license -->
         <hr/>
         <div class='flexc'>Copyright © 2025 . All rights reserved. Powered by Faveo</div>
    </footer>
    <script>
    if (window.location.search.includes('error') || window.location.search.includes('success')) {
        setTimeout(() => {
            const url = new URL(window.location);
            url.search = ''; // Remove all query parameters
            window.history.replaceState({}, document.title, url);
        }, 5000); // Removes after 5 seconds
    }
    </script>

</body>
</html>