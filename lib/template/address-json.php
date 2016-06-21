<?php
    
    function get_filtered_place($aPlace, $bAsPoints){
        $aFilteredPlaces = array();
        if (isset($aPlace['place_id'])) $aFilteredPlaces['place_id'] = $aPlace['place_id'];
        $aFilteredPlaces['licence'] = "Data © OpenStreetMap contributors, ODbL 1.0. http://www.openstreetmap.org/copyright";
        $sOSMType = ($aPlace['osm_type'] == 'N'?'node':($aPlace['osm_type'] == 'W'?'way':($aPlace['osm_type'] == 'R'?'relation':'')));
        if ($sOSMType)
        {
            $aFilteredPlaces['osm_type'] = $sOSMType;
            $aFilteredPlaces['osm_id'] = $aPlace['osm_id'];
        }
        if (isset($aPlace['lat'])) $aFilteredPlaces['lat'] = $aPlace['lat'];
        if (isset($aPlace['lon'])) $aFilteredPlaces['lon'] = $aPlace['lon'];
        $aFilteredPlaces['display_name'] = $aPlace['langaddress'];
        if (isset($aPlace['aAddress'])) $aFilteredPlaces['address'] = $aPlace['aAddress'];
        if (isset($aPlace['sExtraTags'])) $aFilteredPlaces['extratags'] = $aPlace['sExtraTags'];
        if (isset($aPlace['sNameDetails'])) $aFilteredPlaces['namedetails'] = $aPlace['sNameDetails'];

        return $aFilteredPlaces;
    }

    // Is $aPlace set?  This is set if a single lat/lon request was executed sucessfully
    $aFilteredPlaces = array();
    if(isset($aPlace) && sizeof($aPlace))
    {
        $aFilteredPlaces = get_filtered_place($aPlace, $bAsPoints);
    }
    // Is $aPlaces set?  This is set if a batch lat/lon request was executed sucessfully
    else if(isset($aPlaces) && sizeof($aPlaces)){
        for($i = 0; $i < count($aPlaces); $i++){
            $aFilteredPlaces[$i] = get_filtered_place($aPlaces[$i], $bAsPoints);
        }
    }
    // Otherwise, its a failure
    else{
        if (isset($sError))
            $aFilteredPlaces['error'] = $sError;
        else
            $aFilteredPlaces['error'] = 'Unable to geocode';
    }

    javascript_renderData($aFilteredPlaces);

