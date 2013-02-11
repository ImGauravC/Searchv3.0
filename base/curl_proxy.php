<?php

    function setCurl($url){
        $ch = curl_init ();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '\fb_ca_chain_bundle.crt');
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 0);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_PROXYPORT, 80);
        curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
        curl_setopt($ch, CURLOPT_PROXY, 'netmon.iitb.ac.in');
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, "<user>:<pass>");		
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $temp = curl_exec ($ch);
        return $temp;
    }