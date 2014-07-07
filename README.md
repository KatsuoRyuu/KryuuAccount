User Account system
=====
[![Latest Stable Version](https://poser.pugx.org/katsuo-ryuu/kryuu-language-selector/v/stable.svg)](https://packagist.org/packages/katsuo-ryuu/kryuu-language-selector) 
[![Latest Unstable Version](https://poser.pugx.org/katsuo-ryuu/kryuu-language-selector/v/unstable.svg)](https://packagist.org/packages/katsuo-ryuu/kryuu-language-selector) 
[![License](https://poser.pugx.org/katsuo-ryuu/kryuu-language-selector/license.svg)](https://packagist.org/packages/katsuo-ryuu/kryuu-language-selector)

About
-----
This is an account handler build upon ZfcUser module.
The account system should make it a bit easier to extend than ZfcUser.

Upcomming extension will be the activation Module KryuuAccountActivation.


Installation
-----

This module is using doctrine 2 to initialize the database run the the schema-tool
    
    ./vendor/doctrine-module orm:schema-tool:update

You can add a --force to the end to force the changes.

Future
-----

Missing a trigger for when a user is deleted, so that all the extensions will react to it.
Register will be moved to a seperate module, same will delete, edit functions of other modules, to combine this in a simple module.
This Account system will almost replace ZfcUser and try to rebuild everything.
The plan is to make it more secure and give it faster processing with more extentability. As for now it will work as an abstraction layer.
