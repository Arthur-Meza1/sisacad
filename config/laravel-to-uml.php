<?php

return [
  'route' => '/uml',

  'controllers' => false,
  'exceptions' => false,
  'middlewares' => false,
  'entities' => true,
  'models' => true,
  'dtos' => false,
  'providers' => true,
  'value_objects' => false,
  'eloquent_repositories' => false,

  'excludeFiles' => [
    'Http/Kernel.php',
    'Console/Kernel.php',
    'Exceptions/Handler.php',
    'Http/Controllers/Controller.php',
    'Http/Middleware/Authenticate.php',
    'Http/Middleware/EncryptCookies.php',
    'Http/Middleware/PreventRequestsDuringMaintenance.php',
    'Http/Middleware/RedirectIfAuthenticated.php',
    'Http/Middleware/TrimStrings.php',
    'Http/Middleware/TrustHosts.php',
    'Http/Middleware/TrustProxies.php',
    'Http/Middleware/VerifyCsrfToken.php',
    'Infrastructure/Admin/Provider/AppServiceProvider.php',
    'Infrastructure/Shared/Provider/AppServiceProvider.php',
    'Infrastructure/Student/Provider/AppServiceProvider.php',
    'Infrastructure/Teacher/Provider/AppServiceProvider.php',
    'Providers/AppServiceProvider.php',
    'Providers/AuthServiceProvider.php',
    'Providers/BroadcastServiceProvider.php',
    'Providers/EventServiceProvider.php',
    'Providers/RouteServiceProvider.php',
    'Services/HorarioService.php',
    'Application/Teacher/Services/PdfTextCleaner.php',
    ],

  'directories' => [
    'controllers' => [
      'Http/Controllers/',
      'Infrastructure/Admin/Controller/',
      'Infrastructure/Student/Controller/',
      'Infrastructure/Teacher/Controller/',
    ],

    'middlewares' => 'Http/Middleware/',


    'entities' => [
      'Domain/Shared/Entity/',
      'Domain/Student/Entity/',
      'Domain/Teacher/Entity/',
    ],

    'exceptions' => [
      'Domain/Shared/Exception/',
      'Domain/Student/Exception/',
    ],

    'models' => [
      'Infrastructure/Admin/Model/',
      'Infrastructure/Student/Model/',
      'Infrastructure/Teacher/Model/',
      'Infrastructure/Shared/Model/',
    ],

    'value_objects' => [
      'Domain/Shared/ValueObject/',
      'Domain/Student/ValueObject/',
      'Domain/Teacher/ValueObject/',
      'Domain/Admin/ValueObject/',
    ],

    'dtos' => [
      'Application/Admin/DTOs/',
      'Application/Student/DTOs/',
      'Application/Teacher/DTOs/',
      'Application/Shared/DTOs/',
    ],

    'usecases' => [
      'Application/Admin/UseCase/',
      'Application/Student/UseCase/',
      'Application/Teacher/UseCase/',
    ],

    'providers' => [
      'Infrastructure/Admin/Provider/',
      'Infrastructure/Shared/Provider/',
      'Infrastructure/Student/Provider/',
      'Infrastructure/Teacher/Provider/',
    ],

    'repositories' => [
      'Domain/Admin/Repository/',
      'Domain/Student/Repository/',
      'Domain/Teacher/Repository/',
      'Domain/Shared/Repository/',
    ],

    'eloquent_repositories' => [
      'Infrastructure/Admin/Repository/',
      'Infrastructure/Student/Repository/',
      'Infrastructure/Teacher/Repository/',
      'Infrastructure/Shared/Repository/',
    ],

    'transformers' => [
      'Application/Admin/Transformer/',
      'Application/Student/Transformer/',
      'Application/Teacher/Transformer/',
      'Application/Shared/Transformer/',
    ],

    'parsers' => [
      'Infrastructure/Admin/Parser/',
      'Infrastructure/Student/Parser/',
      'Infrastructure/Teacher/Parser/',
      'Infrastructure/Shared/Parser/',
    ]
  ],

  /**
   * You can define specific nomnoml styling.
   * For more information: https://github.com/skanaar/nomnoml
   */
  'style' => [
    'background' => '#FFFFFF',
    'stroke'     => '#000000',

    // Edges
    'arrowSize'  => 1,
    'bendSize'   => 0.5,
    'edges'      => 'rounded',
    'fillArrows' => true,
    'lineWidth'  => 2,

    // Layout
    'direction'  => 'down',
    'gutter'     => 20,
    'edgeMargin' => 5,
    'spacing'    => 75,
    'gravity'    => 1,
    'acyclicer'  => 'greedy',
    'ranker'     => 'longest-path',

    // Nodes
    'fill'       => '#6D9FD8',
    'padding'    => 10,

    // Typography
    'font'       => 'Arial',
    'fontSize'   => 20,
    'leading'    => 1.5,

    // Misc
    'title'      => 'SISACAD',
    'zoom'       => 1,
  ],

];
