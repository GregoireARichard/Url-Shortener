# Url-Shortener


# Disclaimer : Everything is going to be in English
- We've been taught to do so, so that's how it'll be.

# We have used barely two tutorials for this :
- the first one from "primFx" in french for the sign in/up/out interface, it's been widely modified since then, see here : http://www.primfx.com/tuto-php-creer-espace-membre-1-3-inscription-156/
- the second and last one is from Pujann, in English see here : http://pujann.com.np/create-url-shortener-tutorial.php?i=1
Only few parts of the tutorials have been used as it only gave us an idea of what to do, and we didn't use it at all in the same way.

# How does this work ?
 - So first the user enters a link, we store it into the database and we create a temporay file that deletes itself after being clicked. Okay but it means we can't reuse it when we're connected, right? Well : Nope, it doesn't mean that. Because we stored the shortened and the original link into the database. So we just use the 404 page to reroute the link (see assembler.php and .htaccess to understand). 
 In assembler.php there is a condition that shows a 404 page if the link doesn't, or redirects to the original link if it has found it into the database.
 important point, when a link is stored to the database but the user doesn't have an account, the User ID entered into the database is equal to 0. 

 # About the Database : 
- there are two : 
- the first one, (urlmembers) stores for each user an Username, a mail, a password and an ID.
 - the second one, (urllinks) stores for everylink an ID (the same as in the members table), an original link, a shortened link, a LinkID, a boolean called Active which states if the link must be active or not (See assembler.php), the number of views, and the date it has been registered. 


 So yeah, that's roughly how it works.
 

We would like to thank numerous people and elements which helped us through this project:
- M. Berthier for his courses and help
- Stack Oveflow for obvious reasons and the other websites we used.
- HETIC
- The Sun that had the courtesy of showing itself during this week
- The movie risky business and more particularily the music "Love on a real train"

Floriane Ryan, Grégoire Richard
March 31st, 2021
