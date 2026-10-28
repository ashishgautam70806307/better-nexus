@include('errors.layout', [
    'errorCode' => 405,
    'errorTitle' => 'This action isn’t available',
    'errorMessage' => 'This address does not accept the action you tried. Open the page again and use its available controls.',
    'errorLabel' => 'METHOD NOT ALLOWED',
])
