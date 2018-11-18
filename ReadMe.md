## Ascend API Emulator
Through black-box reverse-engineering (The original API is down) of the binary it was possible to determine what data the game was expecting and populate accordingly,
typically the game was wanting JSON responses but the parser actually has the ability to read both JSON and XML so I went the XML route.

### Status
This will currently allow you to create a character, or if you set a CharacterID it will let you in-game, but at some point you will most likely get 'disconnected' due to unimplemented or improperly implemented APIs which are in-place.

I'd say it's about 25% of the way to being playable.

### Additional issues / problems

#### Steam Authentication Tickets
Currently the game relies on a Steam "Authentication Ticket" in order to get the user's account information from the server, the issue with this being that the ticket used can only be used by an application with the appropriate backend access to steam's API.

Being that we didn't publish the game this is not possible for us to obtain, it may be possible to make use of a steam emulator and determine how the tickets are being generated there if they are unique at all.

