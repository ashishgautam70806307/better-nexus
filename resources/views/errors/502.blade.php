@include('errors.layout', [
    'errorCode' => 502,
    'errorTitle' => 'A connection didn’t go through',
    'errorMessage' => 'An upstream service returned an unexpected response. Please try again in a moment.',
    'errorLabel' => 'CONNECTION ERROR',
])
