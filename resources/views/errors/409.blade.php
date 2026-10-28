@include('errors.layout', [
    'errorCode' => 409,
    'errorTitle' => 'Something has changed',
    'errorMessage' => 'This request conflicts with the current information. Open the page again and review the latest details.',
    'errorLabel' => 'UPDATE CONFLICT',
])
