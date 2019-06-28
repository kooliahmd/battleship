# TODO

##
use build in json_login to authenticate users.

## IAM
* consumer to create user. (done)


## LOBBY
* end point to create room
*    //        delete  // (done)
*    //        join    // (done)
*    //        get all (done)

* make lobby end points secure : valid token is required. (done)


## Game 
* end point to start a game
* end point to create units distribution for one player.
* end point to create a game instruction

## Basic UI using angular 
* signup form
* login form
* create a room
* display rooms
* join room
* start game


## improvements
* remove duplicated dtos (ex: User in iam and player)
* remove duplicated services: response-exception handler-param converter, response serializer (api bundle)
* use auth0 saas instead of in house iam service.