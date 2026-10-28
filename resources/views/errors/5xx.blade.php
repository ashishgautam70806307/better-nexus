@include('errors.layout', [
    'errorCode' => isset($exception) && method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500,
    'errorTitle' => 'Something went wrong',
    'errorMessage' => 'The server could not complete this request. Please try again later.',
    'errorLabel' => 'SERVER ERROR',
])
