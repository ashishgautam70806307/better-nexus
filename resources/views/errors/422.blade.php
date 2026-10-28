@include('errors.layout', [
    'errorCode' => 422,
    'errorTitle' => 'Please check your information',
    'errorMessage' => 'Some information could not be accepted. Open the form again and review the highlighted fields.',
    'errorLabel' => 'VALIDATION ERROR',
])
