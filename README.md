![A 3-panel Dilbert comic. In the first panel, the manager character is standing on the left-side behind Dilbert, while Dilbert -- the developer character -- sits at his computer desk on the right-hand-side. The manager says to Dilbert, "I think we should build an SQL database." Dilbert thinks, "uh-oh". In the second panel, the camera looks Dilbert in the face. Dilbert wonders, "Does he understand what he said [sic] or is it something he saw in a trade magazine ad?" In the third panel, Dilbert turns in his chair -- now facing the reader. Dilbert says, "What color do you want that database?" The manager narrows his eyes and says, "I think mauve has the most RAM."](https://web.archive.org/web/20240201080531/http://pbs.twimg.com/media/BoUn8iUIgAAq-CU.png)

# Web-based University Database Management

### By: [Benjamin Voor](https://github.com/Benjamin-Voor), [Matthew Powrie](https://github.com/jabstrings), [Matthew Russo](https://github.com/mrusso5290), and [Connor Beard](https://github.com/cb05208)

### Instructor: Associate professor Dr. Luis Gabriel Jaimes
  * Entry in Florida Polytechnic directory: https://floridapoly.edu/faculty/bios/luis-jaimes/
  * LinkedIn profile: https://www.linkedin.com/in/luis-gabriel-jaimes-11143832/

### Course Name: Database 1

### Course ID: COP 3710

# Abstract
This is 


# Requirements:
* MySQL
* Ubuntu
* Apache2

---

# How to run the project locally:
Clone the repository to your `/var/www/html` folder.
```bash
sudo apt install git # Ubuntu uses apt.
git clone https://github.com/Benjamin-Voor/Web-based-University-Database-Management.git \
/var/www/html # You need the files to be located in /var/www/html/
```
(Note: If using WSL, transfer them to 
`\\wsl.localhost\Ubuntu\var\www\html`)

Navigate to 
`/var/www/html/database/`
And then execute the following commands
```bash
mysql < schema.sql -u root -p
mysql < data.sql -u root -p
```

In Ubuntu, type:
```bash
sudo systemctl start apache2
sudo systemctl start MySQL
```

In web browser, type:
`localhost/customer.php`

# Miscellaneous tips
* To access MYSQL databases:
  
  `MySQL -u root -p`
* to open a file from the `php/` folder in your browser, enter it after the slash in your address bar. The below example access the file named `index.php`:

  `localhost/index.php # replace with your file name`

* Use nano, vim, or vi to edit files in ubuntu. The below example edits the `index.php` file:

  `sudoedit index.php # Use elevated permissions outside user folder`

# copyright?

We recommend checking out the references we cite for more in-depth training on socket programming in Python. Other than that, we deem ourselves too amateur to require a license.

# Disclaimer

You run this code at your own risk. We are not responsible if your server and client data are leaked. Beyond that, we recommend sending impersonal information on a trustworthy internet connection.

# References
Link to the Dilbert comic, posted on Reddit, then archived with the Wayback Machine: https://web.archive.org/web/20210322012431/https://www.reddit.com/r/ProgrammerHumor/comments/lzplto/green_has_more_ram/

  Link to the original Reddit post: https://www.reddit.com/r/ProgrammerHumor/comments/lzplto/green_has_more_ram/