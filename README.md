# Learning Laravel

## What you're building

> **abacus** -- *noun*
>
> also called a counting frame, is a device for making arithmetic calculations, consisting of a frame set with rods on which balls or beads are moved.

To learn how to use Laravel, we're going to jump in head first and build an app called **Abacus**. Abacus is a household inventory management system, which will also have a fluent API so other apps or services can interact with Abacus. For example, we might later build out a native iOS or Android application and consume the API to get the information out of Abacus.

Abacus will help enable the user to keep track of certain goods in a particular inventory, say the fridge, and automatically add them to your shopping list when you're low, like when you run out of eggs!

Abacus is also great for cataloging regular old household items. Have a big CD collection? Big movie fan? Put them all into Abacus, and search for those items any time. And don't worry, getting them all cataloged is a cinch. If an item has a UPC code, you scan it and Abacus will inteligently pull the product information from a third-party database automatically!

## Topics Covered
There's going to be a lot of features for this app that will require a fairly complex backend system, and an equally complex frontend with many dynamic JavaScript components. This is a brief overview of just some of the many things we should learn while building out this app.

### Backend Topics
- Controllers
    - Resourceful controllers to make following a CRUDy design approach much easier.
    - Single-action (often called involkable) controllers for one-off routes that don't need a full resourceful controller.
- Response Types that you can return as an HTTP response
    - Views for the front end
    - JSON response for API calls
- User authentication and middleware to protect certain parts of your application.
- Firing, broadcasting, and listening to server side events
- Eloquent ORM data models, Eloquent relationships, 
- Collections, which make dealing with arrays much easier.
- Feature testing guide feature design, and and unit testing to drive out Eloquent-level business logic and functionality.
- Database migrations for the DB schema, factories to define fake data for models when testing, and seeding data with factories.

### Frontend Topics

- Laravel Echo for responding in realtime to server-side events
- Vue.js for
- Laravel Jetstream to bootstrap the frontend UI
- Laravel Nova as an admin panel for all Eloquent Models
 