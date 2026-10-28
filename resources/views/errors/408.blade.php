@include('errors.layout', [
    'errorCode' => 408,
    'errorTitle' => 'The request took too long',
    'errorMessage' => 'The connection timed out before your request could finish. Check your connection and try again.',
    'errorLabel' => 'REQUEST TIMEOUT',
])
