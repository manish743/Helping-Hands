<html>
<head>
    <title>CIM- Career IN Motion</title>
</head>
<body>
    <h3>Hello {{ $panel['name'] }}!</h3>
    <p>We request your valuable time for a panel interview of job {{ $job->vacant_position }}, stage: {{ $job_applicant->stage_id }}.</p>
    <p>Please follow the link to submit your confirmation</p>
    <a href="{{ $signedUrl }}">{{ $signedUrl }}</a>
</body>
</html>