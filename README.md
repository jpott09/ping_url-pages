ping_url.html contains all the javascript, css, and html to display the page and handle logic.

ping_url.php is the php script that needs to be run SERVER SIDE to ping websites.
The php can not be run by the browser, because you will get CORS errors.

CORS (Cross-Origin Resource Sharing) is a security feature implemented in web browsers 
that restricts web pages from making requests to a different domain than the one that served the web page.

If the php is run server side, the php script should be able to run the curl commands
without error.

IMPORTANT: You must search for and change the path to the php file location on your server,
to match whatever file structure you drop it into, and whatever other naming conventions
your server setup may have.  

WARNING: the php script should not be placed in cgi-bin.  the cgi interpreter will probably
interfere with functionality of the php script.
