<html>
<head>
    <title>CIM- Career IN Motion</title>
</head>
<body>
    <h1>Hello {{ $candidate['first_name'] }}!</h1>
    <p>This is a sample email content.</p>
    <a href="{{ $signedUrl }}">{{ $signedUrl }}</a>
</body>
</html>