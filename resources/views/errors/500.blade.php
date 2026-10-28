@include('errors.layout', [
    'errorCode' => 500,
    'errorTitle' => 'Something went wrong',
    'errorMessage' => 'We couldn’t complete this request. Please try again later, or return to the homepage.',
    'errorLabel' => 'SERVER ERROR',
])
