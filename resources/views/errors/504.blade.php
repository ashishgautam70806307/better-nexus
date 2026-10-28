@include('errors.layout', [
    'errorCode' => 504,
    'errorTitle' => 'A service took too long',
    'errorMessage' => 'A connected service did not respond in time. Please try again later.',
    'errorLabel' => 'GATEWAY TIMEOUT',
])
