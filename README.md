JCDODataWrapper
===============

A standalone PHP wrapper to access all JCDecaux bike sharing sytem RealTime Data

## Installation ##
Just download the JCDODataWrapper class from GitHub, load it into your app, as you usually do (regular include, or any autoload system your project use)

## Example usage ##

    <?php
    
    //load the class
    include "JCDODataWrapper.class.php";
    
    //instanciate with your ApiKey provided when you registred by developer.jcdecaux.com
    $VLSWrapper = new JCDODataWrapper( '<youApiKey>' );
    
    //dumping all contracts (all cities that JCDECAUX rules on)
    var_dump( $VLSWrapper->getContracts() );
    
    //dumping the stations details (both static and dynamic) of a particular contract (city)
    var_dump( $VLSWrapper->getStationsByContract( 'Rouen' ) );
    
    //dumping a station data of a particular contract (city)
    var_dump( $VLSWrapper->getStation('Rouen', 15 ) );