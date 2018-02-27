<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace MIAFirebase;

return array(
    'service_manager' => [
        'factories' => [
            Messaging::class => Factory\MessagingFactory::class,
        ],
    ],
);
