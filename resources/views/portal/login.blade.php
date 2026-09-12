@include('signin', [
    'loginPortal' => ucfirst($portal),
    'loginAction' => route('portal.login.store', ['portal' => $portal]),
    'loginField' => 'username',
    'loginFieldLabel' => 'Username',
    'loginFieldPlaceholder' => 'Enter username',
    'loginRemember' => false,
    'showPortalLinks' => false,
    'registrationUrl' => in_array($portal, ['student', 'guardian'], true) ? route('portal.register', ['portal' => $portal]) : null,
])
