<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Το διακριτικό πρόσβασης του Twitch δεν είναι έγκυρο ή έχει λήξει.',
    'missing_scope'         => 'Λείπει μια άδεια (scope) από το διακριτικό πρόσβασης του Twitch: :scope.',
    'app_token_required'    => 'Αυτό το σημείο πρόσβασης του Twitch δέχεται μόνο διακριτικό εφαρμογής.',
    'user_mismatch'         => 'Ο χρήστης δεν είναι ο κάτοχος του διακριτικού πρόσβασης.',
    'client_mismatch'       => 'Το αναγνωριστικό πελάτη του Twitch δεν είναι αυτό που δημιούργησε τον πόρο ή το διακριτικό.',
    'no_organization'       => 'Η εφαρμογή Twitch δεν συνδέεται με κάποιον οργανισμό.',
    'multiple_filters'      => 'Το Twitch δέχεται μόνο ένα φίλτρο τη φορά.',
    'malformed_parameter'   => 'Η παράμετρος «:parameter» δεν έχει σωστή μορφή.',
    'bad_identifiers'       => 'Ένα ή περισσότερα αναγνωριστικά του Twitch (ID, ονόματα σύνδεσης) δεν είναι έγκυρα.',
    'invalid_code'          => 'Ο κωδικός εξουσιοδότησης του Twitch δεν είναι έγκυρος ή έχει λήξει.',
    'invalid_refresh_token' => 'Το διακριτικό ανανέωσης του Twitch δεν είναι έγκυρο: ο χρήστης πρέπει να συνδεθεί ξανά.',
    'bad_request'           => 'Το Twitch απέρριψε το αίτημα.',
    'unauthorized'          => 'Το Twitch απέρριψε τα διαπιστευτήρια.',
    'forbidden'             => 'Αυτή η ενέργεια δεν επιτρέπεται για αυτόν τον λογαριασμό ή αυτήν την εφαρμογή.',
    'not_found'             => 'Το Twitch δεν βρήκε τίποτα για αυτό το αίτημα.',
    'conflict'              => 'Το αίτημα έρχεται σε σύγκρουση με την τρέχουσα κατάσταση στο Twitch.',
    'gone'                  => 'Αυτή η λειτουργία του Twitch δεν είναι πλέον διαθέσιμη.',
    'unprocessable'         => 'Το Twitch δεν μπόρεσε να επεξεργαστεί το αίτημα.',
    'rate_limited'          => 'Το Twitch έλαβε πάρα πολλά αιτήματα. Δοκιμάστε ξανά αργότερα.',
    'server_error'          => 'Το Twitch αντιμετωπίζει πρόβλημα. Δοκιμάστε ξανά αργότερα.',
    'network'               => 'Δεν ήταν δυνατή η επικοινωνία με το Twitch.',
    'error'                 => 'Το Twitch απάντησε με σφάλμα.',
];
