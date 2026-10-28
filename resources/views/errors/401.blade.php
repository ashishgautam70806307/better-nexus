@include('errors.layout', [
    'errorCode' => 401,
    'errorTitle' => 'Please sign in first',
    'errorMessage' => 'Your session may have ended, or this page requires an account. Sign in to continue.',
    'errorLabel' => 'SIGN IN REQUIRED',
])
