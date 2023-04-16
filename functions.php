<?php

function encode_email_link($email, $subject = '', $body = '') {
    $to = rawurlencode($email);
    $subject = rawurlencode($subject);
    $body = rawurlencode($body);
    $mailto_link = "mailto:$to";
    if ($subject) {
        $mailto_link .= "?subject=$subject";
    }
    if ($body) {
        $mailto_link .= "&body=$body";
    }
    return $mailto_link;
}