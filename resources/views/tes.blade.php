<p>My cat is <strong>very grumpy.</p></strong>
<br>

<h1>Welcome to example.com!</h1>
<div id="placeholder">
  <p>Learn more about <a href="#/products">our products</a> and <a href="#/services">our services</p>
</div>
<script>
    function goToPage(event) {
      event.preventDefault(); // stop the browser from navigating to the destination URL.
      const hrefUrl = event.target.getAttribute('href');
      const pageToLoad = hrefUrl.slice(1); // remove the leading slash
      document.getElementById('placeholder').innerHTML = load(pageToLoad);
      window.history.pushState({}, window.title, hrefUrl) // Update URL as well as browser history.
    }
    
    // Enable client-side routing for all links on the page
    document.querySelectorAll('a').forEach(link => link.addEventListener('click', goToPage));
    
    </script>

    <kbd    ></kbd>