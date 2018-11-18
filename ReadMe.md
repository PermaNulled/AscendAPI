## Ascend API Emulator
Through black-box reverse-engineering (The original API is down) of the binary it was possible to determine what data the game was expecting and populate accordingly,
typically the game was wanting JSON responses but the parser actually has the ability to read both JSON and XML so I went the XML route.

## V1.0
Extremely dirty proof of concept to figure out how the game was handling data, this will get the game to believe it's logged-in to an account but the game will eventually get stuck at "Searching for Champions", I've never played but I believe this means it thinks a character has already been created.

It attempts to do some additional work here but I don't think I'm returning the appropriate data for it to continue into the game.

## V2.0 
A complete re-write of the original PoC which gets stuck at the same point as V1.0, V1.0 will most likely be removed from the repo now that v2.0 no longer crashes the game.

### Additional issues / problems

#### Steam Authentication Tickets
Currently the game relies on a Steam "Authentication Ticket" in order to get the user's account information from the server, the issue with this being that the ticket used can only be used by an application with the appropriate backend access to steam's API.

Being that we didn't publish the game this is not possible for us to obtain, it may be possible to make use of a steam emulator and determine how the tickets are being generated there if they are unique at all.

#### Security Issues
As it stands the way their API is designed it would be fairly easy to account hijack if someone with the right knowledge were attempting to mess with the game, it seems this was always the case even when the servers were live.
