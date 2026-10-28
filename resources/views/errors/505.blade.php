@include('errors.layout', [
    'errorCode' => 505,
    'errorTitle' => 'Connection not supported',
    'errorMessage' => 'The server could not process this connection. Try using an updated browser.',
    'errorLabel' => 'PROTOCOL ERROR',
])
