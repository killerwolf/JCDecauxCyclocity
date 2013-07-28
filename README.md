JCDODataWrapper [![Build Status](https://travis-ci.org/killerwolf/JCDODataWrapper.png?branch=develop)](https://travis-ci.org/killerwolf/JCDODataWrapper)
===============

A standalone PHP wrapper to access all JCDecaux bike sharing sytem RealTime Data

## Installation ##

#### Using composer ####
As you usualy do
    
    {
        "require": {
            "killerwolf/jcdodatawrapper": "0.*"
        }
    }

#### Regular download ####
Just download the 'Wrapper' class from GitHub, load it into your app, as you usually do (regular include, or any autoload system your project use)


## Example usage ##

    <?php
    
    require "vendor/autoload.php"; //composer autoloading
    
    //instanciate with your ApiKey provided when you registred by developer.jcdecaux.com
    $VLSWrapper = new JCDodatawrapper\Vls\Wrapper( '<youApiKey>' );
    
    //using curl to handle the requesting thing
    //you can set your own request method by implementing the HTTPClientInterface
    $HTTPClient = new JCDodatawrapper\Vls\HTTPClientCurl();
    $VLSWrapper->setHTTPClient( $HTTPClient );

    //dumping all contracts (all cities that JCDECAUX rules on)
    var_dump( $VLSWrapper->getContracts() );
    
    //dumping the stations details (both static and dynamic) of a particular contract (city)
    var_dump( $VLSWrapper->getStationsByContract( 'Rouen' ) );
    
    //dumping a station data of a particular contract (city)
    var_dump( $VLSWrapper->getStation('Rouen', 15 ) );