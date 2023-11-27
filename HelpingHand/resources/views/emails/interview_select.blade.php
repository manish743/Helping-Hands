<html>
<head>
    <title>CIM- Career IN Motion</title>
</head>
<body>
    <h1>Hello {{ $candidate['first_name'] }}!</h1>
    <p>This mail is sent to you to make your profile upto date so that we can properly evaluate your skills.</p>
    <a href="{{ $signedUrl }}">{{ $signedUrl }}</a>
</body>
</html>