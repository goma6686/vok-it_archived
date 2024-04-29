## VOK-IT
VOK-IT is a web application for pupils who want to better or learn German language skills using interactive lessons.
All lessons are in H5P interactive content format.

## H5P
H5P content was chosen due to the fact that it has many interactive content types (such as dragging words, fill in the blanks, quizzes, true/false and etc) and Vilnius University German study professors had experience with this framework.
H5P by itself is a interactive content creating, sharing and reusing framework, so it was the primary requirement for our system to accommodate H5P content. The main function of this system is to present H5P content in a orderly and logical manner.
Since H5P content is created at https://h5p.org, our system only needed to display it, so we looked into official H5P plugins, which only included those for popular CMS. After asking our project supervisor and accepting that we cannot use a CMS, we found a standalone H5P interpreter created and updated by the community, running one Node.js, we settled on it as our solution for displaying H5P content.

## Features
- Simple design
- Drag-and-drop H5P format lessons to upload
- Authentication
- News page

## Technologies
- Ubuntu 18.04
- PHP 8.0.5
- NodeJS 14.16.1
- Apache 2.4.46
- Laravel 8.38.0
- H5P-standalone (Node.js module)
- H5P
- MySQL
- Bootstrap
