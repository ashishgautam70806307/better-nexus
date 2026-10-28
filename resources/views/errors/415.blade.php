@include('errors.layout', [
    'errorCode' => 415,
    'errorTitle' => 'This file type isn’t supported',
    'errorMessage' => 'Check the allowed file types shown on the form, then choose a supported file.',
    'errorLabel' => 'UNSUPPORTED FORMAT',
])
