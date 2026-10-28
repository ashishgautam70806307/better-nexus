@include('errors.layout', [
    'errorCode' => isset($exception) && method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 400,
    'errorTitle' => 'This request couldn’t be completed',
    'errorMessage' => 'Please check the link or return to the homepage to continue.',
    'errorLabel' => 'REQUEST ERROR',
])
