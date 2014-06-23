# Alpha Stage User Account system

This is an account handler build upon ZfcUser module.
The account system should make it a bit easier to extend than ZfcUser.

Upcomming extension will be the activation Module KryuuAccountActivation.


# Installation

This module is using doctrine 2 to initialize the database run the the schema-tool
    
    ./vendor/doctrine-module orm:schema-tool:update

You can add a --force to the end to force the changes.

#Future

This Account system will almost replace ZfcUser and try to rebuild everything.
The plan is to make it more secure and give it faster processing with more extentability. As for now it will work as an abstraction layer.
