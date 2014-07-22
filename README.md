## My PHP blog project

I made a simple blog page to get an idea of the fundamentals and how PHP works. I created my own classes and utilities for fetching data from the database as well as a few general output and formatting functions.

This is a pretty standard blog, it's (mostly) text-based with social networking features such as the ability to comment on posts, follow people, etc. 

Still need to add a lot of functionality, but I wanted to get a prototype out there to see how it works on production.

## Current Features:

- Ability to create, edit, delete text posts using a WYSISWG editor
- Ability to comment on posts, supports threaded comments. (__*work in progress, see TO DO*__)
- Passwords stored as hashes for better security
- Uses PDO prepared statements to prevent SQL injection

## TO DO:

- Currently blogs cannot communicate with each other or comment on other blogs. Need to fix this ASAP. May have to implement some kind of routing functionality.
- Friends lists, filters, etc. for more control over who sees what
- Add Ability to post pictures
- Update register form, add field for username, this can be changed later on as long as it is unique. Currently using e-mail as log-in.
- Add e-mail verification.
- Add user picture (currently uses a generic user picture for comments)
- Create profile page, add ability to customize blog somewhat.
- Create classes for Posts and Users, create a pseudo-ORM. Already have a class for Comments.