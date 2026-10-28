@include('errors.layout', [
    'errorCode' => 429,
    'errorTitle' => 'Let’s take a short pause',
    'errorMessage' => 'Too many requests were sent in a short time. Please wait a moment before trying again.',
    'errorLabel' => 'TOO MANY REQUESTS',
])
