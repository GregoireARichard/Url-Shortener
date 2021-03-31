# Url-Shortener


# Disclaimer : Everything is going to be in English
- We've been taught to do so, so that's how it'll be.

# We have used barely two tutorials for this :
- the first one from "primFx" in french for the sign in/up/out interface, it's been largely modified since then, see here : http://www.primfx.com/tuto-php-creer-espace-membre-1-3-inscription-156/
- the second and last one is from Pujann see here : http://pujann.com.np/create-url-shortener-tutorial.php?i=1
Only few parts of the tutorials have been used as it only gave us an idea of what to do, and we didn't use at all the same way.

# How does this work ?
 - So first the user puts a link, we store it into the database and we create a temporay file that deletes itself after being clicked. Ok but it means we can't reuse it when we're connected, right? Well : Nope, it doesn't mean that. Because we stored the shorten and the original link into the database, so what we do is that we use the 404 page to reroute the link (see assembler.php and .htaccess to understand) in assembler.php there is a condition that show a 404 page if the link doesnt exist or redirects to the original link if it founds it into the database.
 So yeah, that's roughly how it works.
 

We would like to thanks numerous persons and things that helped us through this project:
- M. Berthier for his courses and help
- Stack Oveflow
- The movie risky business and more particularily the music "Love on a real train"
