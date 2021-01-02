# programform
WordPress plugin to create a form to add pages for programs on the radio station's website.  
A majority of the data gets pulled from Spinitron using their APIs.  
See https://github.com/kgudger/WsPin for how the API key is stored in the database.  
Other information pulled from the WP database for RSS feeds and Blog Content Views.  
The original page was created in Divi and that code used in this generator.  
When the page loads, a script (spinscrape.js) calls a php file (spinserv.php) to update Spinitron data on the page. This way the pages can stay up to date with Spinitron. I'm putting symlinks to those files in the "includes" folder so they show up in this repository.  
The contact email link uses c_form to create a contact form with the email address in a cookie. While one can still find the host's email by looking at the cookie, it's not obvious and the email address never appears directly in either web page.  
