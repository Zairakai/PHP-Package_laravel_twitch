<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'ថូខឹនចូលប្រើ Twitch មិនត្រឹមត្រូវ ឬបានផុតកំណត់។',
    'missing_scope'         => 'ថូខឹនចូលប្រើ Twitch ខ្វះការអនុញ្ញាត (scope): :scope។',
    'app_token_required'    => 'ចំណុចបញ្ចប់ Twitch នេះទទួលយកតែថូខឹនចូលប្រើកម្មវិធីប៉ុណ្ណោះ។',
    'user_mismatch'         => 'អ្នកប្រើមិនមែនជាម្ចាស់ថូខឹនចូលប្រើទេ។',
    'client_mismatch'       => 'លេខសម្គាល់អតិថិជន Twitch មិនមែនជាលេខដែលបានបង្កើតធនធាន ឬថូខឹនទេ។',
    'no_organization'       => 'កម្មវិធី Twitch មិនបានភ្ជាប់ជាមួយអង្គការទេ។',
    'multiple_filters'      => 'Twitch ទទួលយកតែតម្រងមួយក្នុងពេលតែមួយប៉ុណ្ណោះ។',
    'malformed_parameter'   => 'ប៉ារ៉ាម៉ែត្រ ":parameter" មិនត្រូវបានបង្កើតត្រឹមត្រូវទេ។',
    'bad_identifiers'       => 'អត្តសញ្ញាណ Twitch មួយ ឬច្រើន (លេខសម្គាល់ ឈ្មោះចូល) មិនត្រឹមត្រូវ។',
    'invalid_code'          => 'កូដអនុញ្ញាត Twitch មិនត្រឹមត្រូវ ឬបានផុតកំណត់។',
    'invalid_refresh_token' => 'ថូខឹនធ្វើឱ្យស្រស់ Twitch មិនត្រឹមត្រូវ៖ អ្នកប្រើត្រូវចូលម្តងទៀត។',
    'bad_request'           => 'Twitch បានបដិសេធសំណើ។',
    'unauthorized'          => 'Twitch បានបដិសេធព័ត៌មានផ្ទៀងផ្ទាត់។',
    'forbidden'             => 'សកម្មភាពនេះមិនត្រូវបានអនុញ្ញាតសម្រាប់គណនី ឬកម្មវិធីនេះទេ។',
    'not_found'             => 'Twitch រកមិនឃើញអ្វីសម្រាប់សំណើនេះទេ។',
    'conflict'              => 'សំណើនេះប៉ះទង្គិចនឹងស្ថានភាពបច្ចុប្បន្ននៅលើ Twitch។',
    'gone'                  => 'មុខងារ Twitch នេះលែងមានទៀតហើយ។',
    'unprocessable'         => 'Twitch មិនអាចដំណើរការសំណើបានទេ។',
    'rate_limited'          => 'Twitch ទទួលបានសំណើច្រើនពេក។ សូមព្យាយាមម្តងទៀតនៅពេលក្រោយ។',
    'server_error'          => 'Twitch មានបញ្ហា។ សូមព្យាយាមម្តងទៀតនៅពេលក្រោយ។',
    'network'               => 'មិនអាចទាក់ទង Twitch បានទេ។',
    'error'                 => 'Twitch បានឆ្លើយតបដោយមានកំហុស។',
];
