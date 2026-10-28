@include('errors.layout', [
    'errorCode' => 404,
    'errorTitle' => 'This page is missing',
    'errorMessage' => 'The link may have changed, or the page may no longer exist. Let’s get you back on track.',
    'errorLabel' => 'PAGE NOT FOUND',
])
