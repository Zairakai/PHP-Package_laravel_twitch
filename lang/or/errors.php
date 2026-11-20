<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch ଆକ୍ସେସ ଟୋକେନ ଅବୈଧ କିମ୍ବା ମିଆଦ ଶେଷ ହୋଇଯାଇଛି।',
    'missing_scope'         => 'Twitch ଆକ୍ସେସ ଟୋକେନରେ ଅନୁମତି (scope) ନାହିଁ: :scope।',
    'app_token_required'    => 'ଏହି Twitch ଏଣ୍ଡପଏଣ୍ଟ କେବଳ ଆପ ଆକ୍ସେସ ଟୋକେନ ଗ୍ରହଣ କରେ।',
    'user_mismatch'         => 'ଉପଯୋଗକର୍ତ୍ତା ଆକ୍ସେସ ଟୋକେନର ମାଲିକ ନୁହନ୍ତି।',
    'client_mismatch'       => 'Twitch କ୍ଲାଏଣ୍ଟ ID ସେହି ନୁହେଁ ଯିଏ ସମ୍ବଳ କିମ୍ବା ଟୋକେନ ତିଆରି କରିଥିଲା।',
    'no_organization'       => 'Twitch ଆପ୍ଲିକେସନ କୌଣସି ସଂସ୍ଥା ସହ ଯୋଡ଼ା ହୋଇନାହିଁ।',
    'multiple_filters'      => 'Twitch ଏକ ସମୟରେ କେବଳ ଗୋଟିଏ ଫିଲ୍ଟର ଗ୍ରହଣ କରେ।',
    'malformed_parameter'   => 'ପାରାମିଟର ":parameter" ଠିକ୍ ଭାବରେ ଗଠିତ ନୁହେଁ।',
    'bad_identifiers'       => 'ଏକ କିମ୍ବା ଅଧିକ Twitch ପରିଚୟକାରୀ (ID, ଲଗଇନ) ଅବୈଧ।',
    'invalid_code'          => 'Twitch ଅନୁମୋଦନ କୋଡ ଅବୈଧ କିମ୍ବା ମିଆଦ ଶେଷ ହୋଇଯାଇଛି।',
    'invalid_refresh_token' => 'Twitch ରିଫ୍ରେସ ଟୋକେନ ଅବୈଧ: ଉପଯୋଗକର୍ତ୍ତା ପୁଣି ଲଗଇନ କରିବେ।',
    'bad_request'           => 'Twitch ଅନୁରୋଧ ପ୍ରତ୍ୟାଖ୍ୟାନ କଲା।',
    'unauthorized'          => 'Twitch ପରିଚୟପତ୍ର ପ୍ରତ୍ୟାଖ୍ୟାନ କଲା।',
    'forbidden'             => 'ଏହି ଖାତା କିମ୍ବା ଆପ୍ଲିକେସନ ପାଇଁ ଏହି କାର୍ଯ୍ୟ ଅନୁମତିପ୍ରାପ୍ତ ନୁହେଁ।',
    'not_found'             => 'Twitch ଏହି ଅନୁରୋଧ ପାଇଁ କିଛି ପାଇଲା ନାହିଁ।',
    'conflict'              => 'ଅନୁରୋଧ Twitch ର ବର୍ତ୍ତମାନ ସ୍ଥିତି ସହ ସଂଘର୍ଷ କରୁଛି।',
    'gone'                  => 'ଏହି Twitch ବୈଶିଷ୍ଟ୍ୟ ଆଉ ଉପଲବ୍ଧ ନାହିଁ।',
    'unprocessable'         => 'Twitch ଅନୁରୋଧ ପ୍ରକ୍ରିୟାକରଣ କରିପାରିଲା ନାହିଁ।',
    'rate_limited'          => 'Twitch ବହୁତ ଅଧିକ ଅନୁରୋଧ ପାଇଲା। ପରେ ପୁଣି ଚେଷ୍ଟା କରନ୍ତୁ।',
    'server_error'          => 'Twitch ରେ ସମସ୍ୟା ଅଛି। ପରେ ପୁଣି ଚେଷ୍ଟା କରନ୍ତୁ।',
    'network'               => 'Twitch ସହ ଯୋଗାଯୋଗ କରିହେଲା ନାହିଁ।',
    'error'                 => 'Twitch ତ୍ରୁଟି ସହ ଉତ୍ତର ଦେଲା।',
];
