
<?php

/*
|--------------------------------------------------------------------------
| Portfolio content
|--------------------------------------------------------------------------
| Everything shown on the site lives in this one file.
*/

return [

    'profile' => [
        'name'       => 'Imran Hasan Badhon',
        'name_first' => 'Imran Hasan',
        'name_last'  => 'Badhon',
        'short'      => 'Imran',
        'headline'   => 'Laravel developer, data and computer-vision engineer',
        'roles'      => [
            'Laravel / PHP',
            'Machine Learning',
            'Computer Vision',
            'E-commerce',
        ],
        'lead'       => 'I build dependable web applications and applied machine-learning systems. From a Bangladesh-ready Laravel store to a CNN-LSTM image captioning model, I take an idea from data and design to a working product.',
        'about'      => [
            'I come from a Computer Science and Engineering background, with a foundation in programming, database management and computer vision.',
            'My Master of Science studies at Jagannath University focused on Machine Learning, Data Science and Computer Vision. My research project is an Image Caption Generator that pairs Xception CNN features with an LSTM language model.',
            'On the web side I build and maintain IBL CART 24, a Laravel e-commerce platform for the Bangladesh market, covering local payment flows, an admin panel, order handling and launch hardening.',
        ],
        'location'   => 'Bangladesh',
        'languages'  => 'Bangla, English',
        'email'      => 'imranhasan10022@gmail.com',
        'available'  => true,
        'status'     => 'Open to full-time roles and freelance projects',
        'cv'         => '/Imran_Hasan_Badhon_CV.pdf',
        'photo'      => 'images/profile.jpg',
        'og_image'   => 'images/og.jpg',

        'links' => [
            [
                'label' => 'GitHub',
                'url'   => 'https://github.com/imranbrand',
            ],
            [
                'label' => 'LinkedIn',
                'url'   => 'https://www.linkedin.com/in/imran-hasan-b4a4921a7/',
            ],
            [
                'label' => 'Facebook',
                'url'   => 'https://www.facebook.com/imran.hasan.199690',
            ],
        ],
    ],

    'facts' => [
        [
            'label' => 'Background',
            'value' => 'Computer Science & Engineering',
        ],
        [
            'label' => 'Degree',
            'value' => 'M.Sc., Jagannath University',
        ],
        [
            'label' => 'Based in',
            'value' => 'Bangladesh',
        ],
    ],

    'stack_strip' => [
        'Laravel',
        'PHP',
        'MySQL',
        'Python',
        'TensorFlow',
        'Keras',
        'REST APIs',
        'Blade',
        'JavaScript',
    ],

    'services' => [
        [
            'code'  => 'WEB',
            'title' => 'Laravel web applications',
            'text'  => 'Custom Laravel apps with clean Blade interfaces, role-based admin panels, validation, queues and tests.',
        ],
        [
            'code'  => 'SHOP',
            'title' => 'E-commerce for Bangladesh',
            'text'  => 'Stores with bKash and Nagad payment flows, Dhaka and outside-Dhaka delivery charges, courier and SMS hooks.',
        ],
        [
            'code'  => 'ML',
            'title' => 'ML and vision prototypes',
            'text'  => 'Image models, feature extraction and CNN or LSTM pipelines, turned into something you can demo.',
        ],
        [
            'code'  => 'OPS',
            'title' => 'Launch and hardening',
            'text'  => 'Environment setup, rate limits, mail, backups, SEO basics and deployment to shared hosting or a VPS.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Projects
    |--------------------------------------------------------------------------
    */

    'projects' => [

        // PROJECT 01: IBL CART 24
        [
            'slug'     => 'ibl-cart-24',
            'kind'     => 'Laravel e-commerce',
            'title'    => 'IBL CART 24',
            'tagline'  => 'A Laravel store built for how people in Bangladesh actually pay and receive orders.',
            'summary'  => 'A full e-commerce platform with a customer storefront and an admin panel. It supports guest carts, coupons, reviews, Dhaka and outside-Dhaka delivery pricing, manual bKash and Nagad verification, courier and SMS hooks, and abuse protection.',
            'status'   => 'In active development. Online card payment through SSLCommerz is planned last.',
            'role'     => 'Sole developer: product design, backend, Blade UI, testing and launch preparation.',

            'stack' => [
                'Laravel',
                'PHP',
                'MySQL',
                'Blade',
                'Queues',
                'PHPUnit',
            ],

            'features' => [
                [
                    'Storefront',
                    'Categories, products with multiple images, related products, search-friendly pages, low-stock and New badges.',
                ],
                [
                    'Cart and checkout',
                    'Guest cart support, coupon and discount system, Dhaka versus outside-Dhaka delivery charge, order confirmation email and invoice PDF.',
                ],
                [
                    'Local payments',
                    'bKash and Nagad payment flows with an admin verify action. SSLCommerz is held back until the rest is finished.',
                ],
                [
                    'Admin panel',
                    'Role-based access through an is_admin column, shop settings, order management, review moderation.',
                ],
                [
                    'Trust and safety',
                    'Fake-order protection, abandoned-cart reminders, rate limits and input validation.',
                ],
                [
                    'Growth',
                    'WhatsApp contact button, Facebook Pixel and Google Analytics hooks, SEO metadata and JSON-LD, image optimization.',
                ],
                [
                    'Operations',
                    'Steadfast courier and SMS integration, queue workers, SMTP mail, database backup plan, launch-check and smoke-test commands.',
                ],
                [
                    'Quality',
                    'Automated feature tests that cover the shop flow and security fixes.',
                ],
            ],

            'flow' => [
                ['Browse', 'catalogue'],
                ['Cart', 'guest or user'],
                ['Checkout', 'delivery + coupon'],
                ['Pay', 'bKash / Nagad / COD'],
                ['Fulfil', 'courier + SMS'],
            ],

            'link'   => null,
            'github' => 'https://github.com/imranbrand',
        ],

        // PROJECT 02: CNN-LSTM IMAGE CAPTION GENERATOR
        [
            'slug'     => 'image-caption-generator',
            'kind'     => 'Deep learning research',
            'title'    => 'Image Caption Generator',
            'tagline'  => 'A CNN-LSTM model that looks at a picture and writes a sentence about it.',
            'summary'  => 'My M.Sc. research project at Jagannath University. Xception extracts visual features from each image, and an LSTM network learns to turn those features into a caption. The model is trained on the Flickr8k dataset.',
            'status'   => 'Completed research project, supervised by Dr. Selina Sharmin.',
            'role'     => 'Researcher and developer: data preparation, model design, training and evaluation.',

            'stack' => [
                'Python',
                'TensorFlow',
                'Keras',
                'CNN',
                'LSTM',
                'NumPy',
            ],

            'features' => [
                [
                    'Data',
                    'Flickr8k images with five human captions each, cleaned and tokenised into a vocabulary.',
                ],
                [
                    'Encoder',
                    'Xception CNN turns each image into a compact feature vector.',
                ],
                [
                    'Decoder',
                    'An LSTM reads the image feature plus the words so far and predicts the next word.',
                ],
                [
                    'Training',
                    'Teacher forcing on caption sequences, with checkpoints kept for the best validation loss.',
                ],
                [
                    'Inference',
                    'Greedy word-by-word generation from a start token until an end token.',
                ],
            ],

            'flow' => [
                ['Image', 'Flickr8k'],
                ['Xception', 'CNN features'],
                ['LSTM', 'sequence model'],
                ['Caption', 'generated text'],
            ],

            'link'   => null,
            'github' => 'https://github.com/imranbrand',
        ],

        // PROJECT 03: DHUKPUK — SHORIR-DORPON
        [
            'slug'     => 'dhukpuk-health-tracker',
            'kind'     => 'Health & Wellness Web App',
            'title'    => 'Dhukpuk — শরীর-দর্পণ',
            'tagline'  => 'A Bengali-first family wellness tracker for everyday health awareness.',
            'summary'  => 'A family health and wellness tracker with family profiles, manually entered health readings, daily habit tracking and personal wellness summaries. It stores information locally in the browser and does not provide medical diagnosis.',
            'status'   => 'Live demo available. Browser-local storage; no cloud sync or multi-device account system.',
            'role'     => 'Creator and developer: product concept, interface design and web application development.',

            'stack' => [
                'HTML5',
                'CSS3',
                'JavaScript',
                'Local Storage',
                'Responsive UI',
            ],

            'features' => [
                [
                    'Family profiles',
                    'Create and manage family profiles in the browser.',
                ],
                [
                    'Health readings',
                    'Manually record weight, blood pressure, pulse, SpO₂ and glucose readings.',
                ],
                [
                    'Daily habits',
                    'Track daily steps, water intake and sleep.',
                ],
                [
                    'Wellness overview',
                    'View BMI when height and weight are available, plus a habit-based summary.',
                ],
                [
                    'Privacy-conscious storage',
                    'Data stays in the browser using local storage; it is not cloud-synchronised.',
                ],
                [
                    'Sharing',
                    'Share a wellness score using supported browser sharing or clipboard features.',
                ],
            ],

            'flow' => [
                ['Profile', 'Create a family profile'],
                ['Record', 'Enter readings manually'],
                ['Habits', 'Track daily activities'],
                ['Review', 'See a personal summary'],
            ],

            'link'   => 'https://dhukpuk-sreer-drpn.hatchable.site',
            'github' => 'https://github.com/imranbrand/dhukpuk-health-tracker',
        ],
    ],

    'skills' => [
        [
            'group' => 'Backend',
            'items' => [
                'PHP',
                'Laravel',
                'Eloquent',
                'Queues and jobs',
                'REST APIs',
                'Python (Django, Flask)',
            ],
        ],
        [
            'group' => 'Data and AI',
            'items' => [
                'Machine learning',
                'Deep learning',
                'TensorFlow',
                'Keras',
                'Computer vision',
                'CNN and LSTM',
            ],
        ],
        [
            'group' => 'Frontend',
            'items' => [
                'Blade templates',
                'HTML5',
                'CSS3',
                'JavaScript',
                'Responsive design',
            ],
        ],
        [
            'group' => 'Data stores',
            'items' => [
                'MySQL',
                'PostgreSQL',
                'Database design',
            ],
        ],
        [
            'group' => 'Delivery',
            'items' => [
                'cPanel',
                'Heroku',
                'AWS',
                'Vercel',
                'Postman',
                'PHPUnit',
            ],
        ],
        [
            'group' => 'Security',
            'items' => [
                'HTTPS',
                'Input validation',
                'SQL injection prevention',
                'Rate limiting',
            ],
        ],
    ],

    'education' => [
        [
            'when'  => 'Master of Science',
            'title' => 'Jagannath University',
            'text'  => 'Specialised in Machine Learning, Data Science and Computer Vision. Research project: Image Caption Generator, supervised by Dr. Selina Sharmin.',
        ],
        [
            'when'  => 'Certificate',
            'title' => 'Python for Data Science & Machine Learning',
            'text'  => '',
        ],
        [
            'when'  => 'Certificate',
            'title' => 'Deep Learning Specialization',
            'text'  => '',
        ],
    ],

    'contact_types' => [
        'job'       => 'Full-time or contract role',
        'freelance' => 'Freelance project',
        'other'     => 'Something else',
    ],

    // Where new contact-form messages are emailed.
    // Leave empty to only store them.
    'notify_email' => env('PORTFOLIO_NOTIFY_EMAIL'),

];

