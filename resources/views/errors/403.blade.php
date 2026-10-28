@include('errors.layout', [
    'errorCode' => 403,
    'errorTitle' => 'You don’t have access',
    'errorMessage' => 'Your account does not have permission to open this page. Return to a page you can access.',
    'errorLabel' => 'ACCESS RESTRICTED',
])
